<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Siswa_model');
        $this->load->model('Guru_model');
        $this->load->model('Kelas_model');
        $this->load->model('Transaksi_pembayaran_spp_model');
        $this->load->library('form_validation');
        if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
            redirect('/site/login');
        }
    }

	public function index()
	{   
        $data['title'] = "Data Siswa";
        $data['siswa'] = $this->Siswa_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('siswa/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['siswa'] = $this->Siswa_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['siswa'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('siswa/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Tambah Data Siswa";
        $data['kelas'] = $this->Kelas_model->getAll();

        $this->form_validation->set_rules('nis', 'Nomor Induk Siswa', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal lahir', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_handphone', 'No Handphone', 'required');
        $this->form_validation->set_rules('nama_orangtua', 'Nama Orangtua', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('siswa/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Siswa_model->create();
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('/siswa');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Ubah Data Siswa";
        $data['siswa'] = $this->Siswa_model->getById($id);
        $data['kelas'] = $this->Kelas_model->getAll();

        $this->form_validation->set_rules('nis', 'Nomor Induk Siswa', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal lahir', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_handphone', 'No Handphone', 'required');
        $this->form_validation->set_rules('nama_orangtua', 'Nama Orangtua', 'required');


        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('siswa/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Siswa_model->update($id);
            $this->session->set_flashdata('success', 'Data berhasil diubah.');
            redirect('/siswa');
        }
    }

    public function delete($id)
    {
        $this->Siswa_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('/siswa');  
    }
}
