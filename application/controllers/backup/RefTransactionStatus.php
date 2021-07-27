<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefTransactionStatus extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ref_transaction_status_model');
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
        $data['title'] = "Transaction Status";
        $data['transaction_status'] = $this->Ref_transaction_status_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('ref_transaction_status/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['ref_transaction_status'] = $this->Ref_transaction_status_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['ref_transaction_status'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_transaction_status/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Transaction Status";
        $this->form_validation->set_rules('level', 'level', 'required|numeric');
        $this->form_validation->set_rules('status', 'status', 'required');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_transaction_status/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_transaction_status_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/refTransactionStatus');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Transaction Status";
        $this->form_validation->set_rules('level', 'level', 'required|numeric');
        $this->form_validation->set_rules('status', 'status', 'required');
        if($this->form_validation->run() == FALSE) {
            $data['transaction_status'] = $this->Ref_transaction_status_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_transaction_status/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_transaction_status_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/refTransactionStatus');
        }
    }

    public function delete($id)
    {
        $this->Ref_transaction_status_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/refTransactionStatus');  
    }
}
