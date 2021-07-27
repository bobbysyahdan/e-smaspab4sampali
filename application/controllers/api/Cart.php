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

class Cart extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cart_model');
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
                $carts = $this->Cart_model->getAllCart($page, $limit, $id_user);   
                if ($carts) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success.',
                        'data' => $carts,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No carts were found'
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

    public function delete_post()
    {
        $id_user = $this->input->post('id_user');
        $id_cart = $this->input->post('id_cart');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_cart', 'id_cart', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $cart = $this->Cart_model->getById($id_cart);   
                if ($cart) {
                    $this->Cart_model->delete($id_cart);   
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success.',
                        'data' => 'Cart has been deleted successfully',
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No cart were found'
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
        $cart = $this->Cart_model->getById($id);
        if ($cart) {
            $this->response([
                'message' => 'Success.',
                'data' => $cart,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'message' => 'No cart were found'
            ], REST_Controller::HTTP_OK);
        }
    }
}
