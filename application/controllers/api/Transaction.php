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

class Transaction extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->library('form_validation');
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
                $transactions = $this->Transaction_model->getAllTransaction($page, $limit, $id_user); 
                if ($transactions) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success.',
                        'data' => $transactions,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No transactions were found'
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
        $transaction = $this->Transaction_model->getById($id);
        if ($transaction) {
            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $transaction,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'message' => 'No transaction were found'
            ], REST_Controller::HTTP_OK);
        }
    }
}
