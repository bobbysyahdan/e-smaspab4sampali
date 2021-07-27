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

class User extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('User_identity_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index_post()
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
                $user_identity = $this->User_identity_model->getById($id_user);
                $response = [
                    'status' => TRUE,
                    'data' => [
                        'user_identity' =>  $user_identity,
                        'user' =>  $user,
                    ],
                    'message' => 'Success.',
                ];
                $this->set_response($response, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    } 

    public function createUserIdentity_post()
    {
        $id_user = $this->input->post('id_user');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('fullname', 'fullname', 'required');
        $this->form_validation->set_rules('date_of_birth', 'date_of_birth', 'required');
        $this->form_validation->set_rules('no_handphone', 'no_handphone', 'required');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $data = $this->User_identity_model->create($id_user);
                $response = [
                    'status' => TRUE,
                    'data' => $data,
                    'message' => 'Success.',
                ];
                $this->set_response($response, REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    } 

    public function updateUserIdentity_post()
    {
        $id_user = $this->input->post('id_user');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('fullname', 'fullname', 'required');
        $this->form_validation->set_rules('date_of_birth', 'date_of_birth', 'required');
        $this->form_validation->set_rules('no_handphone', 'no_handphone', 'required');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $data = $this->User_identity_model->update($id_user);
                $response = [
                    'status' => TRUE,
                    'data' => $data,
                    'message' => 'Success.',
                ];
                $this->set_response($response, REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    } 


    public function sendEmailResetPassword_post()
    {
        $email = $this->input->post('email');
        $this->form_validation->set_rules('email', 'Email', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $get_user_by_email = $this->User_model->getByEmail($email);
            // $user = $this->User_model->checkUserLogin($get_user_by_email['id']);
            if($get_user_by_email) {
                $data = $this->User_model->sendEmailResetPassword($email);
                $response = [
                    'status' => TRUE,
                    'data' => $data,
                    'message' => 'Success.',
                ];
                $this->set_response($response, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => TRUE,
                    'message' => 'No email were found.'
                ], REST_Controller::HTTP_OK);
            }
        } 
    } 
}
