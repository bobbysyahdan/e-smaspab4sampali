<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookStock extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Book_stock_model');
        $this->load->model('Book_identity_model');
        $this->load->model('Cart_model');
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
        $data['title'] = "Book Stock";
        $data['book_stocks'] = $this->Book_stock_model->getAll();
        $data['model'] = $this->Book_stock_model;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('book_stock/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['book_stock'] = $this->Book_stock_model->getById($id);
        $data['model'] = $this->Book_stock_model;
        $data['title'] = 'Detail Data';
        if(isset($data['book_stock'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_stock/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Book Stock";
        $data['book_identities'] = $this->Book_identity_model->getAll();
        // $data['book_types'] = $this->Book_stock_model->getBookTypes();
        $data['available_status'] = $this->Book_stock_model->getAvailableStatus();

        $this->form_validation->set_rules('id_book', 'Book', 'required|is_unique[book_stocks.id_book]');
        // $this->form_validation->set_rules('book_type', 'Book Type', 'required');
        $this->form_validation->set_rules('is_available', 'Available', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('weight', 'Weight', 'required|decimal');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_stock/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Book_stock_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/bookStock');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Book Stock";
        $data['book_identities'] = $this->Book_identity_model;
        // $data['book_types'] = $this->Book_stock_model->getBookTypes();
        $data['available_status'] = $this->Book_stock_model->getAvailableStatus();

        // $this->form_validation->set_rules('id_book', 'Book', 'required');
        // $this->form_validation->set_rules('book_type', 'Book Type', 'required');
        $this->form_validation->set_rules('is_available', 'Available', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('weight', 'Weight', 'required|decimal');
        if($this->form_validation->run() == FALSE) {
            $data['book_stock'] = $this->Book_stock_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_stock/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Book_stock_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/bookStock');
        }
    }

    public function delete($id)
    {
        $this->Book_stock_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/bookStock');  
    }

    public function buy($id_book_stock)
	{   
        $data['title'] = "Buy Book";
        $data['book_identities'] = $this->Book_identity_model->getAll();
        $data['available_status'] = $this->Book_stock_model->getAvailableStatus();
        $this->form_validation->set_rules('id_book_stock', 'Book', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if($this->form_validation->run() == FALSE) {
            $data['book_stock'] = $this->Book_stock_model->getById($id_book_stock);
            $data['model'] = $this->Book_stock_model;
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('book_stock/buy', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Cart_model->addBookToCart();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/cart');
        }
    }
}
