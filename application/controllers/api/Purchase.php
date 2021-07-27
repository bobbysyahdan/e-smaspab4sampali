<?php
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type'); 
// if($_SERVER['HTTP_ORIGIN'] == "http://localhost/POS-SL/index.php/api") {
//     header('Access-Control-Allow-Origin: http://localhost:3000');
//     header('Content-Type: application/x-www-form-urlencoded');
//     header('Access-Control-Allow-Headers: *');
//     header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,PATCH,OPTIONS');
// }
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Purchase extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Purchase_model');
        $this->load->model('Midtrans_model');
        $this->load->model('Transaction_model');
        $this->load->model('Verified_book_model');
        $this->load->model('Email_reader_model');
        $this->load->model('Shipping_book_model');
        $this->load->library('form_validation');
    }

    public function checkPurchase_get()
    {
        $purchases = $this->Purchase_model->getCheckAllPurchase();   
      
        if ($purchases) {
            foreach ($purchases as $key => $purchase) {
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
                            if($purchase['id_status_purchase'] == 1) {
                                if($purchase['book_type'] == 1) {
                                    $this->Purchase_model->updateDelivered($purchase['id']);
                                    $this->Book_stock_model->updateAmountBuyer($purchase['id']);
                                    $this->Verified_book_model->addVerifiedBook($purchase['id']);
                                    // $email_reader = $this->Email_reader_model->getByIdTransaction($transaction['id']);
                                    // $this->Email_reader_model->sendEmail($email_reader['email'], $id_verify_book);
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
                            "dibaca_user" => 0,
                            "dibaca_admin" => 0,
                        ];
                        $this->Transaction_model->updateStatus($transaction['id'], $transaction_update);  
                    }
                }
            }
            $data = $this->Purchase_model->getCheckAllPurchase();   

            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => "Checking purchase have been finished successfully.",
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'message' => 'No purchases were found'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_post($page = null, $limit = null)
    {
        $id_user = $this->input->post('id_user');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $purchases = $this->Purchase_model->getAllPurchase($page, $limit, $id_user);   
                if ($purchases) {
                    // foreach ($purchases as $key => $purchase) {
                    //     $transaction = $this->Transaction_model->getById($purchase['id_transaction']);
                    //     if(isset($transaction)) {
                    //         $midtrans = $this->Midtrans_model->notificationMidtrans($transaction['no_order']);
                        
                    //         if($midtrans->status_code != 404) {
                    //             $midtrans_notification = $this->Midtrans_model->getByOrderId($midtrans->order_id);
                    //             if(isset($midtrans_notification)) {
                    //                 $this->db->where('id', $midtrans_notification['id']);
                    //                 $this->db->update('midtrans_notifications', $midtrans);
                    //             } else {
                    //                 $this->db->insert('midtrans_notifications', $midtrans);
                    //             }
            
                    //             $transaction_status = 1;
            
                    //             if($midtrans->transaction_status == 'pending') {
                    //                 $transaction_status = $this->Ref_transaction_status_model->getByLevel(2);
                    //             } else if($midtrans->transaction_status == 'cancel') {
                    //                 $transaction_status = $this->Ref_transaction_status_model->getByLevel(3); 
                    //             } else if($midtrans->transaction_status == 'expire') {
                    //                 $transaction_status = $this->Ref_transaction_status_model->getByLevel(4);
                    //             } else if($midtrans->transaction_status == 'settlement') {
                    //                 if($purchase['id_status'] == 1) {
                    //                     if($purchase['book_type'] == 1) {
                    //                         $this->Verified_book_model->addVerifiedBook($purchase['id']);
                    //                         $this->Purchase_model->updateDelivered($purchase['id']);
                    //                         $this->Book_stock_model->updateAmountBuyer($purchase['id']);
                    //                         // $email_reader = $this->Email_reader_model->getByIdTransaction($transaction['id']);
                    //                         // $this->Email_reader_model->sendEmail($email_reader['email'], $id_verify_book);
                    //                     } else {
                    //                         $this->Verified_book_model->addVerifiedBook($purchase['id']);
                    //                         $this->Purchase_model->updateDeliveryProgress($purchase['id']); 
                    //                         $this->Book_stock_model->updateAmountBuyer($purchase['id']);
                    //                     }                        
                    //                 } 
                    //                 $transaction_status = $this->Ref_transaction_status_model->getByLevel(5);
                    //             }  
            
                    //             $transaction_update = [
                    //                 "id_status" =>  $transaction_status['id'],
                    //             ];
                    //             $this->Transaction_model->updateStatus($transaction['id'], $transaction_update);  
                    //         }
                    //     }
                    // }
                    $data = $this->Purchase_model->getAllPurchase($page, $limit, $id_user);   

                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success.',
                        'data' => $data,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No purchases were found'
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }

    public function index_get($id = NULL)
    {
        $purchase = $this->Purchase_model->getById($id);
        if ($purchase) {
            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $purchase,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'message' => 'No purchase were found'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function checkout_post()
	{    
        $id_user = $this->input->post('id_user');
        $id_transaction = $this->input->post('id_transaction');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_transaction', 'id_transaction', 'required');
        if($this->form_validation->run() == FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $transactions = $this->Purchase_model->getByIdTransactions($id_transaction);
                $transaction = $this->Transaction_model->getById($id_transaction);
                if(count($transactions) > 0){
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success',
                        'data' => [
                            'transactions' => $transactions,
                            'transaction' => $transaction,
                        ],
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No purchases were found',
                    ], REST_Controller::HTTP_OK);
                }   
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }

    public function addPurchaseBook_post()
	{    
        $id_user = $this->input->post('id_user');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('book_type', 'Book Type', 'required');
        if($this->form_validation->run() == FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                if(count($this->input->post()) < 3) {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'You must choose one book.',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    foreach ($this->input->post() as $key => $id_cart) {
                        if($key != "book_type" && $key != "id_user"  && $key != "voucher_code") {
                            $check_cart = $this->Cart_model->getByIdAndUser($id_cart, $id_user);
                            
                            if(!isset($check_cart)) {
                                return $this->response([
                                    'status' => FALSE,
                                    'message' => 'No cart were found.',
                                ], REST_Controller::HTTP_BAD_REQUEST);
                            } 
                        }
                    }

                    $id_transaction = $this->Purchase_model->addPurchaseBookAPI($id_user);
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success',
                        'data' => [
                            'id_transaction' => $id_transaction,
                        ],
                    ], REST_Controller::HTTP_CREATED);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }

    public function addEmailReader_post()
	{   
        $id_user = $this->input->post('id_user');
        $id_transaction = $this->input->post('id_transaction');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_transaction', 'id_transaction', 'required');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $transaction = $this->Transaction_model->getById($id_transaction);
                if($transaction) {
                    if($transaction['book_type'] == 1) {
                        $data = $this->Email_reader_model->addEmailReaderAPI($id_user, $id_transaction);
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Success',
                            'data' => $data,
                        ], REST_Controller::HTTP_CREATED);
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Book type is not digital.',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No transaction were found.',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }

    public function addShippingBook_post()
	{   
        $id_user = $this->input->post('id_user');
        $id_transaction = $this->input->post('id_transaction');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_transaction', 'id_transaction', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');
        $this->form_validation->set_rules('id_provinsi', 'id_provinsi', 'required');
        $this->form_validation->set_rules('id_kota', 'id_kota', 'required');
        $this->form_validation->set_rules('kode_pos', 'kode_pos', 'required');
        $this->form_validation->set_rules('no_handphone', 'no_handphone', 'required');
        $this->form_validation->set_rules('shipping_price', 'shipping_price', 'required');
        $this->form_validation->set_rules('courier', 'courier', 'required');
        $this->form_validation->set_rules('courier_service', 'courier_service', 'required');
        $this->form_validation->set_rules('etd', 'etd', 'required');
        $this->form_validation->set_rules('total_weight', 'total_weight', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $transaction = $this->Transaction_model->getById($id_transaction);
                if($transaction) {
                    if($transaction['book_type'] == 2) {
                        $data = $this->Shipping_book_model->addShippingBookAPI($id_user, $id_transaction);
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Success',
                            'data' => $data,
                        ], REST_Controller::HTTP_CREATED);
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Book type is not printed.',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No transaction were found.',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function paymentProcess_post() {
        $id_user = $this->input->post('id_user');
        $id_transaction = $this->input->post('id_transaction');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_transaction', 'id_transaction', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $check_transaction = $this->Transaction_model->getByIdJoinPurchase($id_transaction, $id_user);
                $transaction = $this->Transaction_model->getById($id_transaction);

                if($check_transaction) {
                    if($this->Transaction_model->getShippingBook($id_transaction) != null || $this->Transaction_model->getEmailReader($id_transaction) != null) {
                        if($transaction['id_status'] == 1) {
                            if($transaction['total_price'] != 0) {
                                $response = $this->Transaction_model->updateMidToken($id_transaction);
                                $this->response([
                                    'status' => TRUE,
                                    'message' => 'Success.',
                                    'data' => $response->redirect_url,
                                ], REST_Controller::HTTP_OK);
                            } else {
                                $purchases = $this->Purchase_model->getByIdTransactions($transaction['id']);
                                
                                if(count($purchases) > 0) {
                                    foreach($purchases as $purchase) {
                                        if($purchase['book_type'] == 1) {
                                            $this->Purchase_model->updateDelivered($purchase['id_purchase']);
                                            $this->Book_stock_model->updateAmountBuyer($purchase['id_purchase']);
                                            $this->Verified_book_model->addVerifiedBook($purchase['id_purchase']);
                                        } else {
                                            $this->Verified_book_model->addVerifiedBook($purchase['id_purchase']);
                                            $this->Purchase_model->updateDeliveryProgress($purchase['id_purchase']); 
                                            $this->Book_stock_model->updateAmountBuyer($purchase['id_purchase']);
                                        }     
                                    }

                                    $transaction_status = $this->Ref_transaction_status_model->getByLevel(5);
                                    $transaction_update = [
                                        "id_status" =>  $transaction_status['id'],
                                    ];
                                    $this->Transaction_model->updateStatus($transaction['id'], $transaction_update);  
                                        
                                    $this->response([
                                        'status' => TRUE,
                                        'message' => 'Success.',
                                        'data' => "Transaction on Succces.",
                                    ], REST_Controller::HTTP_OK);
                                }
                            }
                            
                        } else {
                            $transaction_status = $transaction['status'];
                            $this->response([
                                'status' => TRUE,
                                'message' => 'Transaction on '.$transaction_status,
                            ], REST_Controller::HTTP_OK);
                        }
                    }  else {
                        if($transaction['book_type'] == 1) {
                            $this->response([
                                'status' => TRUE,
                                'message' => 'You have not email for send digital book.',
                            ], REST_Controller::HTTP_OK);
                        } else {
                            $this->response([
                                'status' => TRUE,
                                'message' => 'You have not shipping address for send printed book.',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No transaction were found.',
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function cancel_post()
	{    
        $id_user = $this->input->post('id_user');
        $id_transaction = $this->input->post('id_transaction');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_transaction', 'id_transaction', 'required');
        if($this->form_validation->run() == FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $transactions = $this->Purchase_model->getByIdTransactions($id_transaction);
                $transaction = $this->Transaction_model->getById($id_transaction);
                if(count($transactions) > 0){

                    if($transaction['id_status'] != 5) {
                        foreach($transactions as $transaction) {
                            $this->Purchase_model->updateCanceled($transaction['id_purchase']);
                        }
    
                        $this->Transaction_model->updateStatusCancel($id_transaction);
                        $transaction = $this->Transaction_model->getById($id_transaction);
    
                        if($transaction['mid_token'] != null) {
                            $this->Midtrans_model->cancelMidtrans($transaction['no_order']);
                        }
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Success',
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Transaction have been settlement.',
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No purchases were found',
                    ], REST_Controller::HTTP_OK);
                }   
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }
}
