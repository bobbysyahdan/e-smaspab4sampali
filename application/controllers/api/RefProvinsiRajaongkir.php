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

class RefProvinsiRajaongkir extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Ref_provinsi_rajaongkir_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = null)
    {
        $provinces = $this->Ref_provinsi_rajaongkir_model->getAll();   
        $province = $this->Ref_provinsi_rajaongkir_model->getById($id);

        if ($id === NULL)
        {   
            if ($provinces)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $provinces,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'No provinces were found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            if ($province)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $province,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'No province were found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }
}
