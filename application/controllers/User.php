<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

	public function index()
	{   
        $data['title'] = "User";
        $data['users'] = $this->User_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('user/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['user'] = $this->User_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['user'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('user/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Create New User";
        $data['users'] = $this->User_model->getAll();
        $data['roles'] = $this->User_model->getRoles();
        $data['is_active'] = $this->User_model->getStatus();

        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]|max_length[16]|min_length[3]',[
            'is_unique' => 'This username already registered!',

        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email already registered!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('is_active', 'Status', 'required');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('user/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->User_model->create();
            $this->session->set_flashdata('success', 'Data has been saved successfully.');
            redirect('/user');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Update User";
        $data['roles'] = $this->User_model->getRoles();
        $data['is_active'] = $this->User_model->getStatus();
        $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[16]|min_length[3]',[
            'is_unique' => 'This username already registered!',

        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email already registered!',
        ]);
        // $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        // $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('is_active', 'is_active', 'required');
        if($this->form_validation->run() == FALSE) {
            $data['user'] = $this->User_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('user/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->User_model->update($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/user');
        }
    }

    public function resetPassword($id)
	{   
        $data['title'] = "Change Password";
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if($this->form_validation->run() == FALSE) {
            $data['user'] = $this->User_model->getById($id);
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('user/reset_password', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->User_model->resetPassword($id);
            $this->session->set_flashdata('success', 'Data has been updated successfully.');
            redirect('/user');
        }
    }

    public function delete($id)
    {
        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'Data has been deleted successfully.');
        redirect('/user');  
    }
}
