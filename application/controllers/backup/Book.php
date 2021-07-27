<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Book_identity_model');
        $this->load->model('Verified_book_model');
        $this->load->model('Subscribe_model');
        $this->load->model('Ref_subscribe_package_model');
        $this->load->model('Purchase_model');
        $this->load->model('Transaction_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

	public function index()
	{   
        $data['title'] = "Book";
        $data['model'] = $this->Book_identity_model;
        $data['book_identities'] = $this->Book_identity_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('book/index', $data);
        $this->load->view('layouts/footer');
    }

    public function read($id)
    {
        $data['is_verified'] = FALSE;
        $data['book_identity'] = $this->Book_identity_model->getById($id);
        $data['title'] = $data['book_identity']['title'];
        $data['filename'] = $this->Book_identity_model->getFile($id); 
        $verified_book =  $this->db->where('id_user', $this->session->userdata('id'))
        ->where('id_book', $id)->where('is_verified', 1)->get('verified_books')->row_array();
        $this->form_validation->set_rules('serial_number', 'Serial Number', 'required');   
        if(isset($verified_book)) {
            $data['is_verified'] = TRUE;
        }
        if($this->form_validation->run() == FALSE) {
            
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book/read', $data);
            $this->load->view('layouts/footer');
        } else {
            if($this->Verified_book_model->getBySerialNumber($this->input->post('serial_number'), $id)) {
                if($data['is_verified'] == FALSE) {
                    $this->Verified_book_model->verifySerialNumber($id);
                    $this->session->set_flashdata($this->Verified_book_model->verifySerialNumber($id));
                }
            } else {
                $this->session->set_flashdata('failed', 'Serial number invalid!');
            }
            redirect('/book/read/'.$id);
        }
    }

    public function checkSerialNumber($id){
        $data['is_verified'] = FALSE;
        $verified_book =  $this->db->where('id_user', $this->session->userdata('id'))
        ->where('id_book', $id)->where('is_verified', 1)->get('verified_books')->row_array();
        if(isset($verified_book)) {
            $is_verified = TRUE;
        }
        $data['book_identity'] = $this->Book_identity_model->getById($id);
        $data['title'] = $data['book_identity']['title'];
        $data['filename'] = $this->Book_identity_model->getFile($id); 
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('book/read', $data);
        $this->load->view('layouts/footer');
    }

    // public function subscribe($id_book) {
    //     $data['book_identity'] = $this->Book_identity_model->getById($id_book);
    //     $data['subscribe_packages'] = $this->ref_subscribe_package_model->getAll();
    //     $data['title'] = 'Subscribe - '.$data['book_identity']['title'];
    //     $this->form_validation->set_rules('id_book', 'Book', 'required');
    //     $this->form_validation->set_rules('id_subscribe_package', 'Subscribe Package', 'required');
    //     if($this->form_validation->run() == FALSE) {
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('book/subscribe', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $this->subscribe_model->subscribeBook();
    //         $insert_id = $this->db->insert_id();
    //         redirect('/subscribe/checkout/'.$insert_id);
    //     }
    // }
}
