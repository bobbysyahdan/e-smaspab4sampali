<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Purchase_model');
        $this->load->model('Transaction_model');
        $this->load->model('Book_stock_model');
        $this->load->model('Book_identity_model');
        $this->load->model('Email_reader_model');
        $this->load->model('Shipping_book_model');
        $this->load->model('Verified_book_model');
        $this->load->model('Ref_provinsi_rajaongkir_model');
        $this->load->model('Ref_kota_rajaongkir_model');
        $this->load->model('Transaction_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

    public function addPurchaseBook()
	{    
        if(count($this->input->post()) == 1) {
            $this->session->set_flashdata('failed', 'You must choose one.');
            redirect('/cart');    
        } else {
            $id_transaction = $this->Purchase_model->addPurchaseBook();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            if($this->input->post()['book_type'] == 1) {
                redirect('/purchase/addEmailReader/'.$id_transaction);
            } else {
                redirect('/purchase/addShippingBook/'.$id_transaction);
            }
        }
    }

    public function newNoTransaction($id_transaction)
    {
        $data['transaction'] = $this->Transaction_model->getById($id);
        $this->Transaction_model->updateNoOrder($id_transaction);
        redirect('/purchase/paymentProcess/'.$transaction['id']);
    }

    public function paymentProcess($id_transaction) {
        $transaction = $this->Transaction_model->getById($id_transaction);
        if(isset($transaction)) {
            if($this->Transaction_model->getShippingBook($transaction['id']) != null|| $this->Transaction_model->getEmailReader($transaction['id']) != null) {
                $response = $this->Transaction_model->updateMidToken($id_transaction);
            } else {
                if($transaction['book_type'] == 1) {
                    redirect('/purchase/addEmailReader/'.$id_transaction);
                } else {
                    redirect('/purchase/addShippingBook/'.$id_transaction);
                }
            }  
       } else {
           $response = null;
       }

       redirect($response->redirect_url);
    }


	public function index()
	{   
        $data['title'] = "purchase";
        $data['purchases'] = $this->Purchase_model->getAll();
        $data['transactions'] = $this->Transaction_model->getAll();
        $data['transaction_model'] = $this->Transaction_model;
        $data['purchase_model'] = $this->Purchase_model;
        $data['book_stock_model'] = $this->Book_stock_model;
        $this->Purchase_model->updateDibaca();
        foreach ($data['purchases'] as $key => $purchase) {
            $transaction = $this->Transaction_model->getById($purchase['id_transaction']);
            if(isset($transaction)) {
                $midtrans = $this->Midtrans_model->notificationMidtrans($transaction['no_order']);
               
                if($midtrans->status_code != 404) {
                    $midtrans_notification = $this->Midtrans_model->getByOrderId($midtrans->order_id);
                    if(isset($midtrans_notification)) {
                        $this->db->where('id', $midtrans_notification['id']);
                        $this->db->update('midtrans_notifications', $midtrans);
                    } else {
                        $this->db->insert('midtrans_notifications', $midtrans);
                    }

                    $transaction_status = 1;

                    if($midtrans->transaction_status == 'pending') {
                        $transaction_status = $this->Ref_transaction_status_model->getByLevel(2);
                    } else if($midtrans->transaction_status == 'cancel') {
                        $this->Purchase_model->updateCanceled($purchase['id']);
                        $transaction_status = $this->Ref_transaction_status_model->getByLevel(3); 
                    } else if($midtrans->transaction_status == 'expire') {
                        $this->Purchase_model->updateCanceled($purchase['id']);
                        $transaction_status = $this->Ref_transaction_status_model->getByLevel(4);
                    } else if($midtrans->transaction_status == 'settlement') {
                        if($purchase['id_status'] == 1) {
                            if($purchase['book_type'] == 1) {
                                $id_verify_book = $this->Verified_book_model->addVerifiedBook($purchase['id']);
                                $verify_book = $this->Verified_book_model->getByID($id_verify_book);
                                $this->Purchase_model->updateDelivered($purchase['id']);
                                $this->Book_stock_model->updateAmountBuyer($purchase['id']);
                                // $email_reader = $this->Email_reader_model->getByIdTransaction($transaction['id']);
                                // $this->Email_reader_model->sendEmail($email_reader['email'], $id_verify_book);
                                // $this->Email_reader_model->sendEmail($verify_book['email'], $verify_book['id_book']);
                            } else {
                                $this->Verified_book_model->addVerifiedBook($purchase['id']);
                                $this->Purchase_model->updateDeliveryProgress($purchase['id']); 
                                $this->Book_stock_model->updateAmountBuyer($purchase['id']);
                            }                        
                        } 
                        $transaction_status = $this->Ref_transaction_status_model->getByLevel(5);
                    }  

                    $transaction_update = [
                        "id_status" =>  $transaction_status['id'],
                    ];
                    
                    $this->Transaction_model->updateStatus($transaction['id'], $transaction_update);  
                }
            }
        }
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('purchase/index', $data);
        $this->load->view('layouts/footer');
    }

    public function addEmailReader($id_transaction)
	{   
        $data['title'] = "Add Email Reader";
        $data['purchases'] = $this->Purchase_model->getByIdTransactions($id_transaction);
        $data['transaction'] = $this->Transaction_model->getById($id_transaction);
        $data['email_reader_model'] = $this->Email_reader_model;
        $data['shipping_book_model'] = $this->Shipping_book_model;
        $data['purchase_model'] = $this->Purchase_model;
        $data['id_transaction'] = $id_transaction;
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('purchase/email_reader', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Email_reader_model->addEmailReader($id_transaction);
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/purchase/paymentProcess/'.$id_transaction);
        }
    }

    public function addShippingBook($id_transaction)
	{   
        $data['title'] = "Add Shipping Address";
        $data['purchases'] = $this->Purchase_model->getByIdTransactions($id_transaction);
        $data['transaction'] = $this->Transaction_model->getById($id_transaction);
        $data['email_reader_model'] = $this->Email_reader_model;
        $data['shipping_book_model'] = $this->Shipping_book_model;
        $data['purchase_model'] = $this->Purchase_model;
        $data['ref_provinsi_rajaongkir_model'] = $this->Ref_provinsi_rajaongkir_model;
        $data['ref_kota_rajaongkir_model'] = $this->Ref_provinsi_rajaongkir_model;
        $data['id_transaction'] = $id_transaction;
        $data['total_weight'] = $this->Purchase_model->getTotalBookWeight($id_transaction);
        $data['total_price'] = $this->Purchase_model->getTotalBookPrice($id_transaction);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_handphone', 'No Handphone', 'required');
        $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('id_provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('id_kota', 'Kota', 'required');
        $this->form_validation->set_rules('courier', 'Kurir', 'required');
        $this->form_validation->set_rules('etd', 'Etd', 'required');
        $this->form_validation->set_rules('shipping_price', 'Shipping Price', 'required');
        $this->form_validation->set_rules('total_price_all', 'Total Price All', 'required');
        $this->form_validation->set_rules('courier_service', 'Courier Service', 'required');
        $this->form_validation->set_rules('total_weight', 'Total Weight', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('purchase/shipping_book', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Shipping_book_model->addShippingBook($id_transaction);
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/purchase/paymentProcess/'.$id_transaction);
        }
    }

    public function getCities()
    {
        $cities = $this->Ref_kota_rajaongkir_model->getByIdProvinsi($this->input->post('id_provinsi'));
        foreach($cities as $city){
            echo "<option value='$city[id]'>$city[type] $city[nama_kota]</option>";
        }
    }

    public function getCheckOngkir()
    {
        $couriers = [
            "jne",
            "tiki",
            "pos",
        ];
        $weight = $this->input->post('total_weight');
        $weight = intval($weight * 1000);
        $origin = 278;
        $destination = $this->input->post('id_kota');
        $results = [];
            
        foreach($couriers as $courier) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$weight&courier=$courier",
            // CURLOPT_POSTFIELDS => "origin=$origin&originType=subdistrict&destination=$destination&destinationType=subdistrict&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: b3e809e540040eb3c0d8c8f804ec98a2"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response);
                if(isset($response)) {
                    $r = $response->rajaongkir;
                    if($r->status->code == 200) {
                        array_push($results, [
                            "query" => $r->query,
                            "asal" => $r->origin_details,
                            "tujuan" => $r->destination_details,
                            "hasil" => $r->results,
                            "logo" => '/template_index/img/logo-vendor/'.$courier.'.png',
                            "berat_barang" => $weight,
                        ]);
                    }
                }
            }
        } 
        
        foreach($results as $result_key => $result){
        
            foreach($result['hasil'] as $a_key => $a){
                foreach($a->costs as $b_key => $b){
                    $price = "Rp".number_format($b->cost[0]->value,0,'.','.');
                    $price_courier = $b->cost[0]->value;
                    $day = preg_replace("/[^0-9 -]/", "", $b->cost[0]->etd).'hari';
                    echo "
                    <div class='custom-control'>
                    <input class='form-check-input' type='radio' name='result_courier' id='result_courier' value='$a->code/$b->service/$day/$price_courier'>
                    <label class='form-check-label' for='result_courier'>$a->code ($b->service) ($day) - $price</label>
                    </div>
                    ";
                }

                // <input type='hidden' value='$b->service' name='courier_service'>
                //     <input type='hidden' value='$day' name='day'>
                //     <input type='text' value='$price_courier' name='price_courier' id='price_courier$b_key'>
            }  
        } 
    }

    public function show($id)
    {
        $data['purchase'] = $this->Purchase_model->getById($id);
        $data['model'] = $this->Purchase_model;
        $data['title'] = 'Detail Data';
        if(isset($data['purchase'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('purchase/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function detail($id_transaction)
    {
        $data['purchases'] = $this->Purchase_model->getByIdTransactions($id_transaction);
        $data['transaction'] = $this->Transaction_model->getById($id_transaction);
        $data['email_reader_model'] = $this->Email_reader_model;
        $data['shipping_book_model'] = $this->Shipping_book_model;
        $data['purchase_model'] = $this->Purchase_model;
        $data['total_weight'] = $this->Purchase_model->getTotalBookWeight($id_transaction);
        $data['total_price'] = $this->Purchase_model->getTotalBookPrice($id_transaction);
        $data['title'] = 'Detail Data';
        if(isset($data['purchases'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('purchase/detail', $data);
            $this->load->view('layouts/footer');
        }
    }

    public function finish()
    {
        $data['order_id'] = $this->input->get()['order_id'];
        $data['status_code'] = $this->input->get()['status_code'];
        $data['transaction_status'] = $this->input->get()['transaction_status'];

        $data['title'] = 'Detail Data';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('purchase/finish', $data);
        $this->load->view('layouts/footer');
    }

    public function updateStatusDelivered($id_transaction)
    {
        $purchases = $this->Purchase_model->getByIdTransactions($id_transaction);
        foreach($purchases as $purchase) {
            $this->Purchase_model->updateDelivered($purchase['id_purchase']);
        }
        
        $this->session->set_flashdata('success', 'Data has been saved successfully.');
        redirect('/purchase');
    }
    
    // public function create()
	// {   
    //     $data['title'] = "Create New purchase";
    //     $this->form_validation->set_rules('category', 'Category', 'required');

    //     if($this->form_validation->run() == FALSE) {
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('purchase/create', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $this->Purchase_model->create();
    //         $this->session->set_flashdata('success', 'Data has been saved successfully.');
    //         redirect('/refBookCategory');
    //     }
    // }

    // public function update($id)
	// {   
    //     $data['title'] = "Update purchase";
    //     $this->form_validation->set_rules('category', 'Category', 'required[ref_book_purchases.category]');

    //     if($this->form_validation->run() == FALSE) {
    //         $data['category'] = $this->Purchase_model->getById($id);
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('purchase/update', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $this->Purchase_model->update($id);
    //         $this->session->set_flashdata('success', 'Data has been updated successfully.');
    //         redirect('/refBookCategory');
    //     }
    // }

    public function delete($id)
    {
        $this->Purchase_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/purchase');  
    }

    public function receiptNumber($id) 
    {
        $data['transaction'] = $this->Transaction_model->getById($id);
        $this->form_validation->set_rules('no_resi', 'Receipt Number', 'required');
        $data['title'] = "Receipt Number";
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('purchase/no_resi', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Transaction_model->receiptNumber($id);
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/purchase');  
        }
    }

    

}
