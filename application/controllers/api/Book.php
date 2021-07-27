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

class Book extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Book_identity_model');
        $this->load->model('Book_stock_model');
        $this->load->model('book_content_images_model');
        $this->load->model('Verified_book_model');
        $this->load->model('Cart_model');
        $this->load->model('Ref_book_category_model');
        $this->load->library('form_validation');
    }

    public function index_get($page = null, $limit = null)
    {
        $books = $this->Book_identity_model->getAllAvailable($page, $limit);   
        $id = $this->get('id');
        $book = $this->Book_identity_model->getById($id);

        if ($id === NULL)
        {   
            if ($books)
            {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $books,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'No books were found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            if ($book)
            {
                // $book_content_images = $this->Book_content_images_model->getAllByBookIdentities($book['id']);
                // if($book_content_images) {
                //     $book_content_images = $book_content_images;
                // } else {
                //     $book_content_images = [];
                // }
                $this->response([
                    'status' => TRUE,
                    'message' => 'Success.',
                    'data' => $book,
                    // 'book_content_images' => $book_content_images,
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'No book were found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function search_get($page = null, $limit = null)
    {
        $keyword = $this->get('keyword');
        $books = $this->Book_identity_model->getBySearchTitle($page, $limit, $keyword);
        if ($books) {
            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $books,
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'message' => 'No books were found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function filterCategory_get($page = null, $limit = null)
    {
        $id_category = $this->get('category');
        $books = $this->Book_identity_model->getByCategory($page, $limit, $id_category);
        if ($books) {
            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $books,
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'message' => 'No books were found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function bookPerCategory_get($page = null, $limit = null)
    {
        $books = $this->Book_identity_model->getBookPerCategory($page, $limit);
        if (count($books) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'Success.',
                'data' => $books,
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No books were found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function addToCart_post()
    {
        $id_user = $this->input->post('id_user');
        $id_book_stock = $this->input->post('id_book');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_book', 'id_book', 'required');
        $this->form_validation->set_rules('quantity', 'quantity', 'required');
        $this->form_validation->set_rules('price', 'price', 'required|numeric');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $book = $this->Book_stock_model->getById($id_book_stock);
                if($book){
                    if ($book['is_available'] == 1) {
                        $data = $this->Cart_model->addToCart($id_user);
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Success.',
                            'data' => $data,
                        ], REST_Controller::HTTP_CREATED);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Book not available!'
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No book were found.'
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

    public function read_post()
    {
        $id_user = $this->input->post('id_user');
        $id_book = $this->input->post('id_book');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_book', 'id_book', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $verified_book = $this->Verified_book_model->getVerifiedBook($id_user, $id_book);
                if($verified_book){
                    if ($verified_book['is_verified'] == 1) {
                            // $book_content_images = $this->Book_content_images_model->getByBookIdentities($verified_book['id']);
                            // if($book_content_images) {
                            //     $book_content_images = $book_content_images;
                            // } else {
                            //     $book_content_images = [];
                            // }
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Success.',
                            'data' => $verified_book,
                            // 'book_content_images' => $book_content_images,
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'You have not verified the book!'
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'You have not bought the book!'
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


    public function verifiedBook_post()
    {
        $id_user = $this->input->post('id_user');
        $id_book = $this->input->post('id_book');
        $serial_number = $this->input->post('serial_number');
        $this->form_validation->set_rules('id_user', 'id_user', 'required');
        $this->form_validation->set_rules('id_book', 'id_book', 'required');
        $this->form_validation->set_rules('serial_number', 'Serial Number', 'required');
        if($this->form_validation->run()== FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user = $this->User_model->checkUserLogin($id_user);
            if($user) {
                $check_serial_number = $this->Verified_book_model->getCheckSerialNumber($serial_number);
                if($check_serial_number) {
                    $verified_book = $this->Verified_book_model->getVerifiedBook($id_user, $id_book);
                    if($verified_book) {
                        if ($verified_book['is_verified'] == 0) {
                            $data = $this->Verified_book_model->verified($id_user, $id_book, $serial_number);
                            if($data == null) {
                                $this->response([
                                    'status' => FALSE,
                                    'message' => 'Serial number is invalid!'
                                ], REST_Controller::HTTP_OK);
                            } else {
                                $this->response([
                                    'status' => TRUE,
                                    'message' => 'Success.',
                                    'data' => $data,
                                ], REST_Controller::HTTP_OK);
                            }
                        } else {
                            $this->response([
                                'status' => TRUE,
                                'message' => 'The book have been verified!'
                            ], REST_Controller::HTTP_OK);
                        }
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'You have not bought the book!'
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Serial number not found!'
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
}
