<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefPurchaseStatus extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ref_purchase_status_model');
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
        $data['title'] = "Purchase Status";
        $data['ref_purchase_status'] = $this->Ref_purchase_status_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('ref_purchase_status/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['ref_purchase_status'] = $this->Ref_purchase_status_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['ref_purchase_status'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_purchase_status/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Purchase Status";
        $this->form_validation->set_rules('level', 'level', 'required|numeric');
        $this->form_validation->set_rules('status', 'status', 'required');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_purchase_status/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_purchase_status_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/refPurchaseStatus');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Purchase Status";
        $this->form_validation->set_rules('level', 'level', 'required|numeric');
        $this->form_validation->set_rules('status', 'status', 'required');
        if($this->form_validation->run() == FALSE) {
            $data['purchase_status'] = $this->Ref_purchase_status_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_purchase_status/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_purchase_status_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/refPurchaseStatus');
        }
    }

    public function delete($id)
    {
        $this->Ref_purchase_status_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/refPurchaseStatus');  
    }
}
