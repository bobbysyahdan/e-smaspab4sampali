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

class Authentication extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('User_identity_model');
        $this->load->library('form_validation');
    }

    public function index_get()
    {

    }

    public function login_post()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $this->form_validation->set_rules('password', 'pasword', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if(isset($user)) {
                if($user['is_active'] == 1) {
                    if(password_verify($password, $user['password'])) {
                            $data_login = $this->User_model->login($user['id']);
                            $response = [
                                    'id' => $user['id'],
                                    'email' => $user['email'],
                                    'username' => $user['username'],
                                    'role' => $user['role'],
                                    'is_login' => $data_login['is_login'],
                                    'device_model' => $data_login['device_model'],
                                    'device_token' => $data_login['device_token'],
                                    'device_version' => $data_login['device_version'],
                                    'status' => TRUE,
                                    'message' => 'Success.',
                            ];
                            $this->session->set_userdata($response);
                            $this->User_model->lastLogin($user['id']);
                            $this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                    } else {
                            $this->response([
                                'status' => TRUE,
                                'message' => 'Wrong Password!.'
                            ],REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Account has not been actived!.'
                    ],REST_Controller::HTTP_OK);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                ],REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
    }

    public function register_post()
    {
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email already registered!',
        ]);
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'confirm_password', 'required|matches[password]');
        $this->form_validation->set_rules('fullname', 'fullname', 'required');
        // $this->form_validation->set_rules('date_of_birth', 'date_of_birth', 'required');
        $this->form_validation->set_rules('no_handphone', 'no_handphone', 'required');
        // $this->form_validation->set_rules('gender', 'gender', 'required');

        // $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]|max_length[16]|min_length[3]',[
        //     'is_unique' => 'This username already registered!',
        // ]);
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = $this->User_model->registerUser();
            if($data) {
                $data['user_identity'] = $this->User_identity_model->create($data['id']);
            }
            $response = [
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $data,
            ];
            $this->set_response($response, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
    }

    public function logout_post()
    {
        $id_user = $this->input->post('id_user', true);
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $this->User_model->logout($id_user);
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('email');
                $this->session->unset_userdata('username');
                $this->session->unset_userdata('role');
                $response = [
                    'status' => TRUE,
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

}
