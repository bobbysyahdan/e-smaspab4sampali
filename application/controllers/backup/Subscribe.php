<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subscribe_model');
        $this->load->model('Transaction_model');
        $this->load->model('Ref_transaction_status_model');
        $this->load->model('Ref_subscribe_package_model');
        $this->load->model('User_model');
        $this->load->model('Midtrans_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

    public function index()
	{   
        $data['title'] = "Subscribe";
        $data['subscribes'] = $this->Subscribe_model->getAll();
        $data['model'] = $this->Subscribe_model;
        foreach ($data['subscribes'] as $key => $subscribe) {
            $transaction = $this->Transaction_model->getById($subscribe['id_transaction']);
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
                        $transaction_status = $this->Ref_transaction_status_model->getByLevel(3); 
                    } else if($midtrans->transaction_status == 'expire') {
                        $transaction_status = $this->Ref_transaction_status_model->getByLevel(4);
                    } else if($midtrans->transaction_status == 'settlement') {
                        if($subscribe['id_subscribe_status'] == 0) {
                            $this->Subscribe_model->updateActive($subscribe['id']);
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
        $this->load->view('subscribe/index', $data);
        $this->load->view('layouts/footer');
    }

    // public function subscribePackage($id_package)
	// {   
    //     $this->Subscribe_model->subscribePackage();
    //     $this->session->set_flashdata('success', 'Data has been saved successfully.');
    //     redirect('/subscribe');
    // }

    public function create()
	{   
        $data['title'] = "Create New Subscribe";
        $data['subscribe_packages'] = $this->Ref_subscribe_package_model->getAll();
        $data['users'] = $this->User_model->getAll();
        $this->form_validation->set_rules('id_subscribe_package', 'Subscribe Package', 'required');
        $this->form_validation->set_rules('id_user', 'User', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('subscribe/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Subscribe_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/subscribe');
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Data';
        $data['subscribe'] = $this->Subscribe_model->getById($id);
        $data['model'] = $this->Subscribe_model;
        if(isset($data['subscribe'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('subscribe/show', $data);
            $this->load->view('layouts/footer');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Subscribe";
        $data['subscribe_packages'] = $this->Ref_subscribe_package_model->getAll();
        $data['users'] = $this->User_model->getAll();
        $this->form_validation->set_rules('id_subscribe_package', 'Subscribe Package', 'required');
        $this->form_validation->set_rules('id_user', 'User', 'required');

        if($this->form_validation->run() == FALSE) {
            $data['subscribe'] = $this->Subscribe_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('subscribe/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Subscribe_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/subscribe');
        }
    }

    public function delete($id)
    {
        $this->Subscribe_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/subscribe');  
    }

    public function checkout($id_subscribe, $token=null) {
        $data['subscribe'] = $this->Subscribe_model->getById($id_subscribe);
        // $data['book'] = $this->Subscribe_model->getBook($data['subscribe']['id_book']);
        $data['user'] = $this->Subscribe_model->getUser($data['subscribe']['id_user']);
        $data['transaction'] = $this->Subscribe_model->getTransaction($data['subscribe']['id_transaction']);
        $data['package'] = $this->Subscribe_model->getSubscribePackage($data['subscribe']['id_subscribe_package']);
        $data['title'] = 'Checkout';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('subscribe/checkout', $data);
        $this->load->view('layouts/footer');
    }

    public function paymentProcess($id_transaction) {
        $id_user = $this->session->userdata('id');
        $transaction = $this->Transaction_model->getById($id_transaction);
        if(isset($transaction)) {
            $response = $this->Transaction_model->updateMidToken($id_transaction);
       } else {
           $response = null;
       }
       redirect($response->redirect_url);
    }

    

    // public function test() {
    //     echo "<pre>";
    //     print_r($this->Subscribe_model->getValidDate(1));
    //     echo "</pre>";
    //     exit();   
    // }
}
