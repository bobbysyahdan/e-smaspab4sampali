<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefSubscribePackage extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ref_subscribe_package_model');
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
        $data['title'] = "Subscribe Package";
        $data['subscribe_packages'] = $this->Ref_subscribe_package_model->getAll();
        $data['package_edition'] = $this->Ref_package_edition_model;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('ref_subscribe_package/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['ref_subscribe_package'] = $this->Ref_subscribe_package_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['ref_subscribe_package'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_subscribe_package/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New Subscribe Package";
        $data['package_editions'] = $this->Ref_package_edition_model->getAll();
        $this->form_validation->set_rules('id_package_edition', 'Package Edition', 'required');
        $this->form_validation->set_rules('package', 'Package Name', 'required');
        $this->form_validation->set_rules('days', 'Days', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_subscribe_package/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Ref_subscribe_package_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/refSubscribePackage');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update Subscribe Package";
        $data['package_editions'] = $this->Ref_package_edition_model->getAll();
        $this->form_validation->set_rules('id_package_edition', 'Package Edition', 'required');
        $this->form_validation->set_rules('package', 'Package Name', 'required');
        $this->form_validation->set_rules('days', 'Days', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        if($this->form_validation->run() == FALSE) {
            $data['ref_subscribe_package'] = $this->Ref_subscribe_package_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('ref_subscribe_package/update', $data);
            $this->load->view('layouts/footer');
        } else {
            
            $this->Ref_subscribe_package_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/refSubscribePackage');
        }
    }

    public function delete($id)
    {
        $this->Ref_subscribe_package_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/refSubscribePackage');  
    }

    public function subscribe($id_package)
	{   
        $this->Ref_subscribe_package_model->userSubscribePackage($id_package);
        $this->session->set_flashdata('success', 'Data has been saved successfully.');
        redirect('/subscribe');
    }
}
