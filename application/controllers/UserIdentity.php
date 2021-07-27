<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserIdentity extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_identity_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }
    
	public function index($id_user)
	{   
        $user_identity = $this->User_identity_model->hasIdentity($id_user);
        if(isset($user_identity)) {
            redirect('/userIdentity/update/'.$id_user);
        } else {
            redirect('/userIdentity/create/'.$id_user);
        }
    }

    public function create($id_user)
	{   
        $data['id_user'] = $id_user;
        $data['title'] = "User Identity";
        $data['gender'] = $this->User_identity_model->getGender();
        $this->form_validation->set_rules('fullname', 'Fullname', 'required');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
        $this->form_validation->set_rules('no_handphone', 'No. Handphone', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('user_identity/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->User_identity_model->create($id_user);
            $this->session->set_flashdata('success', 'Data has been created successfully.');
            redirect('/user');
        }
    }

    public function update($id_user)
	{   
        $data['id_user'] = $id_user;
        $data['title'] = "User Identity";
        $data['gender'] = $this->User_identity_model->getGender();
        $this->form_validation->set_rules('fullname', 'Fullname', 'required');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
        $this->form_validation->set_rules('no_handphone', 'No. Handphone', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        if($this->form_validation->run() == FALSE) {
            $data['user_identity'] = $this->User_identity_model->hasIdentity($id_user);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('user_identity/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->User_identity_model->update($id_user);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/user');
        }
    }

    // public function show($id)
    // {
    //     $data['user_identity'] = $this->User_identity_model->getById($id);
    //     $data['title'] = 'Detail Data';
    //     if(isset($data['user_identity'])) {
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('user_identity/show', $data);
    //         $this->load->view('layouts/footer');
    //     }
    // }

    
    // public function create()
	// {   
    //     $data['title'] = "Create New User Identity";
    //     $data['categories'] = $this->ref_book_category_model->getAll();
    //     $this->form_validation->set_rules('isbn', 'ISBN', 'required|numeric|is_unique[book_identities.isbn]|max_length[13]');
    //     $this->form_validation->set_rules('title', 'Title', 'required');
    //     $this->form_validation->set_rules('author', 'Author', 'required');
    //     $this->form_validation->set_rules('publisher', 'Publisher', 'required');
    //     $this->form_validation->set_rules('publication_year', 'Publication Year', 'required');
    //     $this->form_validation->set_rules('pages', 'Pages', 'required|numeric');
    //     // $this->form_validation->set_rules('id_category', 'Category', 'required');
    //     // if (empty($_FILES['file_uploaded']['name']))
    //     // {
    //     //    $this->form_validation->set_rules('file_uploaded', 'File', 'required');
    //     // }
    //     if($this->form_validation->run() == FALSE) {
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('user_identity/create', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $this->User_identity_model->create();
    //         $this->session->set_flashdata('success', 'Data has been saved successfully.');
    //         redirect('/bookIdentity');
    //     }
    // }

    // public function update($id)
	// {   
    //     $data['title'] = "Update User Identity";
    //     $data['categories'] = $this->ref_book_category_model->getAll();
    //     // $this->form_validation->set_rules('isbn', 'ISBN', 'required|numeric|is_unique[book_identities.isbn]');
    //     $this->form_validation->set_rules('title', 'Title', 'required');
    //     $this->form_validation->set_rules('author', 'Author', 'required');
    //     $this->form_validation->set_rules('publisher', 'Publisher', 'required');
    //     $this->form_validation->set_rules('publication_year', 'Publication Year', 'required');
    //     $this->form_validation->set_rules('pages', 'Pages', 'required|numeric');

    //     if($this->form_validation->run() == FALSE) {
    //         $data['user_identity'] = $this->User_identity_model->getById($id);
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/menu');
    //         $this->load->view('user_identity/update', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $this->User_identity_model->update($id);
    //         $this->session->set_flashdata('success', 'Data has been updated successfully.');
    //         redirect('/bookIdentity');
    //     }
    // }

    // public function delete($id)
    // {
    //     $this->User_identity_model->delete($id);
    //     $this->session->set_flashdata('success', 'Data has been deleted successfully.');
    //     redirect('/bookIdentity');  
    // }
}
