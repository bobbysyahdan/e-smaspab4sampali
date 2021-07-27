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

class Voucher extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Voucher_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index_get($page = null, $limit = null)
    {
        $vouchers = $this->Voucher_model->getAllAvailable($page, $limit);   
        $id = $this->get('id');
        $voucher = $this->Voucher_model->getById($id);

        if ($id === NULL)
        {   
            if ($vouchers)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $vouchers,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No vouchers were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            if ($voucher)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $voucher,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No voucher were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function checkVoucherCode_post()
    {
        $id_user = $this->input->post('id_user');
        $voucher_code = $this->input->post('voucher_code');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('voucher_code', 'voucher_code', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $check_voucher_code = $this->Voucher_model->getByVoucherCode($voucher_code);
                if($check_voucher_code) {
                    $date = date('Y-m-d');
                    if($date >= $check_voucher_code['start_date'] && $date <= $check_voucher_code['end_date']) {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Success.',
                            'data' => $check_voucher_code,
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => ' Voucher validity period is not valid!'
                        ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Voucher code not found!'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login.'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }

}
