<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifiedBook extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Verified_book_model');
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
        $data['title'] = "Verified Book";
        $data['verified_books'] = $this->Verified_book_model->getAll();
        $data['model'] = $this->Verified_book_model;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('verified_book/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['verified_book'] = $this->Verified_book_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['verified_book'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('verified_book/show', $data);
            $this->load->view('layouts/footer');
        }
    }
}
