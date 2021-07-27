<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
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
        $data['title'] = "Cart";
        $data['carts'] = $this->Cart_model->getAll();
        $data['model'] = $this->Cart_model;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('cart/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['cart'] = $this->Cart_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['cart'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('cart/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    // public function create()
	// {   
    //     $data['title'] = "Create New Cart";
    //     $this->form_validation->set_rules('category', 'Category', 'required');

    //     if($this->form_validation->run() == FALSE) {
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('cart/create', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $this->Cart_model->create();
    //         $this->session->set_flashdata('success', 'Data has been saved successfully.');
    //         redirect('/refBookCategory');
    //     }
    // }

    // public function update($id)
	// {   
    //     $data['title'] = "Update Cart";
    //     $this->form_validation->set_rules('category', 'Category', 'required[ref_book_carts.category]');

    //     if($this->form_validation->run() == FALSE) {
    //         $data['category'] = $this->Cart_model->getById($id);
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('cart/update', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $this->Cart_model->update($id);
    //         $this->session->set_flashdata('success', 'Data has been updated successfully.');
    //         redirect('/refBookCategory');
    //     }
    // }

    public function delete($id)
    {
        $this->Cart_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/cart');  
    }
}
