<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Voucher_model');
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
        $data['title'] = "Voucher";
        $data['voucher'] = $this->Voucher_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('voucher/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['voucher'] = $this->Voucher_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['voucher'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('voucher/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Voucher";
        $this->form_validation->set_rules('voucher_code', 'Voucher Code', 'required[voucher.voucher_code]');
        $this->form_validation->set_rules('percentage_discount', 'Percentage Discount', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('voucher/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Voucher_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/voucher');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Voucher";
        $this->form_validation->set_rules('voucher_code', 'Voucher Code', 'required[voucher.voucher_code]');
        $this->form_validation->set_rules('percentage_discount', 'Percentage Discount', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');

        if($this->form_validation->run() == FALSE) {
            $data['voucher'] = $this->Voucher_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('voucher/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Voucher_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/voucher');
        }
    }

    public function delete($id)
    {
        $this->Voucher_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/voucher');  
    }
}
