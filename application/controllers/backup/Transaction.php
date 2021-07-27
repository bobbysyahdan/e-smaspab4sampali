<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

	public function index()
	{   
        $data['title'] = "Transaction";
        $data['transactions'] = $this->Transaction_model->getAll();
        $data['purchase_model'] = $this->Purchase_model;
        
        $data['model'] = $this->Transaction_model;
        $data['status'] = $this->Transaction_model;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('transaction/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['transaction'] = $this->Transaction_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['transaction'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('transaction/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Transaction";
        $this->form_validation->set_rules('no_order', 'no_order', 'required');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('transaction/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Transaction_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/transaction');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Transaction";
        $this->form_validation->set_rules('no_order', 'no_order', 'required|numeric');
        if($this->form_validation->run() == FALSE) {
            $data['transaction'] = $this->Transaction_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('transaction/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Transaction_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/transaction');
        }
    }

    public function delete($id)
    {
        $this->Transaction_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/transaction');  
    }
}
