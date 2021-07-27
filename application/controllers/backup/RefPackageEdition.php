<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefPackageEdition extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ref_package_edition_model');
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
        $data['title'] = "Package Edition";
        $data['ref_package_editions'] = $this->Ref_package_edition_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('ref_package_edition/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['ref_package_edition'] = $this->Ref_package_edition_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['ref_package_edition'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_package_edition/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Package Edition";
        $this->form_validation->set_rules('package_edition', 'package_edition', 'required[ref_book_categories.category]');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_package_edition/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_package_edition_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/refPackageEdition');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Package Edition";
        $this->form_validation->set_rules('package_edition', 'package_edition', 'required[ref_book_categories.category]');

        if($this->form_validation->run() == FALSE) {
            $data['ref_package_edition'] = $this->Ref_package_edition_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_package_edition/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_package_edition_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/refPackageEdition');
        }
    }

    public function delete($id)
    {
        $this->Ref_package_edition_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/refPackageEdition');  
    }
}
