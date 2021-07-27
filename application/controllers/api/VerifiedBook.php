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

class VerifiedBook extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Verified_book_model');
        $this->load->model('User_model');
        $this->load->model('Email_reader_model');
        $this->load->model('Purchase_model');
        $this->load->library('form_validation');
    }

    // public function sendEmail_get($id_verify_book, $id_email_reader)
    // {
    //     $verify_book = $this->Verified_book_model->getById($id_verify_book);
    //     if ($verify_book) {
    //         $email_reader = $this->Email_reader_model->getById($id_email_reader);
    //         if ($email_reader) {
    //             $send_email = $this->Email_reader_model->sendEmail($email_reader['email'], $id_verify_book);
    //             if ($send_email == 'Your email has successfully been sent') {
    //                 $this->response([
    //                     'message' => 'Success.',
    //                     'data' => $send_email,
    //                 ], REST_Controller::HTTP_OK);
    //             } else {
    //                 $this->response([
    //                     'status' => FALSE,
    //                     'message' => $send_email,
    //                 ], REST_Controller::HTTP_NOT_FOUND);
    //             } 
    //         } else {
    //             $this->response([
    //                 'status' => FALSE,
    //                 'message' => 'No email were found.'
    //             ], REST_Controller::HTTP_NOT_FOUND);
    //         }
            
    //     } else {
    //         $this->response([
    //             'status' => FALSE,
    //             'message' => 'No verified book were found.'
    //         ], REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    public function sendEmail_get()
    {
        $send_email = $this->Verified_book_model->getAllEmailReaderHaveNotSend();
        if (count($send_email) > 0) {
            foreach($send_email as $value) {

                $send_email = $this->Email_reader_model->sendEmail($value['email'], $value['id_book']);
                if ($send_email == 'The email has successfully been send.') {
                    $data = $this->Verified_book_model->updateEmailHaveSent($value['id_verified_book']);
                    $this->response([
                        'message' => 'Success.',
                        'data' => $send_email,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'Failed.',
                        'message' => $send_email,
                    ], REST_Controller::HTTP_NOT_FOUND);
                } 
            } 
        } else {
            $this->response([
                'message' => 'Success.',
                'data' => 'All email have been send.',
            ], REST_Controller::HTTP_OK);
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
                $verified_books = $this->Verified_book_model->getAllVerifiedBooks($page, $limit, $id_user);   
                if ($verified_books) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success.',
                        'data' => $verified_books,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No verified books were found'
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
        $verified_book = $this->Verified_book_model->getById($id);
        if ($verified_book) {
            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $verified_book,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'message' => 'No verified_book were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
