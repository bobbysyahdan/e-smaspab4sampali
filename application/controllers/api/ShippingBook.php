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

class ShippingBook extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Shipping_book_model');
        $this->load->model('User_model');
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
                $shipping_books = $this->Shipping_book_model->getAllShippingBook($page, $limit, $id_user);   
                if ($shipping_books) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success.',
                        'data' => $shipping_books,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No shipping books were found'
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
        $shipping_book = $this->Shipping_book_model->getById($id);
        if ($shipping_book) {
            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $shipping_book,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'message' => 'No shipping book were found'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function referenceShippingBook_post($page = null, $limit = null)
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
                $shipping_books = $this->Shipping_book_model->getReferenceShippingBook($page, $limit, $id_user);   
                if ($shipping_books) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Success.',
                        'data' => $shipping_books,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No shipping books were found'
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

    public function checkOngkir_post()
    {
        $id_user = $this->input->post('id_user');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('total_weight', 'Total Weight', 'required');
        $this->form_validation->set_rules('id_kota', 'Id Kota', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
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
                                ]);

                                $this->response([
                                    'status' => TRUE,
                                    'message' => 'Success.',
                                    'data' => $results,
                                ], REST_Controller::HTTP_OK);
                            } else {
                                $this->response([
                                    'status' => TRUE,
                                    'message' => $r->status->description,
                                ], REST_Controller::HTTP_OK);
                            }
                        }
                    }
                } 
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You must login',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } 
    }
}
