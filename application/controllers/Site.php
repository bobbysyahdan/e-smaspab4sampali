<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('User_model');
            $this->load->library('form_validation');
        }

	public function index()
	{
                if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
                        redirect('/site/login');
                }
                $data['title'] = "SMAS PAB 4 SAMPALI";
                $this->load->view('layouts/header_site', $data);
                $this->load->view('layouts/menu');
                $this->load->view('site/index');
                $this->load->view('layouts/footer');
        }
        
        public function login()
        {
                $data['title'] = "Login";
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
                $this->form_validation->set_rules('password', 'Password', 'required|trim');
                $email = $this->input->post('email', true);
                $password = $this->input->post('password', true);
                if($this->form_validation->run() == FALSE) {
                        $this->load->view('layouts/login', $data);
                } else {
                        $user = $this->db->get_where('users', ['email' => $email])->row_array();
                        if(isset($user)) {
                                if($user['is_active'] == 1) {
                                        if(password_verify($password, $user['password'])) {
                                                if($user['role'] == 1) {
                                                        $data = [
                                                                'id' => $user['id'],
                                                                'email' => $user['email'],
                                                                'username' => $user['username'],
                                                                'role' => $user['role'],
                                                        ];
                                                        $this->session->set_userdata($data);
                                                        $test = $this->User_model->lastLogin($user['id']);
                                                        redirect('/');
                                                } else {
                                                        $this->session->set_flashdata('failed', 'You have not access!.');
                                                        redirect('/site/login');
                                                }
                                        } else {
                                                $this->session->set_flashdata('failed', 'Wrong Password!.');
                                                redirect('/site/login');
                                        }
                                } else {
                                        $this->session->set_flashdata('failed', 'Account has not been actived!.');
                                        redirect('/site/login');
                                }
                        } else {
                                $this->session->set_flashdata('failed', 'Email has not been registered!.');
                                redirect('/site/login');
                        }
                }
        }

        public function logout()
        {
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('email');
                $this->session->unset_userdata('username');
                $this->session->unset_userdata('role');
                redirect('site/login');
        }
}
