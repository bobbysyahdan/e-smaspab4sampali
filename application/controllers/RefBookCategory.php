<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefBookCategory extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ref_book_category_model');
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
        $data['title'] = "Book Category";
        $data['categories'] = $this->Ref_book_category_model->getAll();
        // $categories = $this->Ref_book_category_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        // $this->load->view('ref_book_category/index', [
        //     'categories' => $categories,
        // ]);
        $this->load->view('ref_book_category/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['ref_book_category'] = $this->Ref_book_category_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['ref_book_category'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_book_category/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Book Category";
        $this->form_validation->set_rules('category', 'Category', 'required[ref_book_categories.category]');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_book_category/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_book_category_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/refBookCategory');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Book Category";
        $this->form_validation->set_rules('category', 'Category', 'required[ref_book_categories.category]');

        if($this->form_validation->run() == FALSE) {
            $data['category'] = $this->Ref_book_category_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_book_category/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_book_category_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/refBookCategory');
        }
    }

    public function delete($id)
    {
        $this->Ref_book_category_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/refBookCategory');  
    }
}
