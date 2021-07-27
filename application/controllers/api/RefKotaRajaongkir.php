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

class RefKotaRajaongkir extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Ref_kota_rajaongkir_model');
        $this->load->library('form_validation');
    }

    public function index_get($id_province = null)
    {
        $cities = $this->Ref_kota_rajaongkir_model->getAll();   
        $city = $this->Ref_kota_rajaongkir_model->getByIdProvinsi($id_province);

        if ($id_province === NULL)
        {   
            if ($cities)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $cities,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'No cities were found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            if ($city)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $city,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'No city were found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }
}
