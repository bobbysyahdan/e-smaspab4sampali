<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Purchase_model');
        $this->load->model('Transaction_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

    public function resetPassword($remember_token)
	{   
        $data['title'] = "Reset Password Akun Pengguna";
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $user = $this->User_model->getByRememberToken($remember_token);
        if($this->form_validation->run() == FALSE) {
            $user = $this->User_model->getByRememberToken($remember_token);
            $data['user'] = $user;
            if($user) {
                // $this->load->view('layouts/header', $data);
                $this->load->view('akun/reset_password', $data);
            }
        } else {
            if($user) {
                if($user['email'] == $this->input->post('email')) {
                    $this->User_model->resetPassword($user['id']);
                    $this->session->set_flashdata('success', 'Reset password akun anda berhasil. Silahkan login akun anda kembali pada aplikasi BidLit.');
                    redirect('/akun/successResetPassword/'.$remember_token);
                } else {
                    $this->session->set_flashdata('failed', 'Email anda tidak valid.');
                    redirect('/akun/resetPassword/'.$remember_token);
                }
            }
            
        }
    }

    public function successResetPassword($remember_token)
	{   
        $user = $this->User_model->getByRememberToken($remember_token);
        if($user) {
            $this->User_model->deleteRememberToken($user['id']);
            $this->load->view('akun/success_reset_password');
        }
    }
}
