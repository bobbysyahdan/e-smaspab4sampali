<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {


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
        $data['title'] = "Data Kelas";
        $data['kelas'] = $this->Kelas_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('kelas/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['kelas'] = $this->Kelas_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['kelas'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('kelas/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Tambah Data Kelas";
        $data['guru'] = $this->Guru_model->getAll();

        $this->form_validation->set_rules('nama_kelas', 'Nama kelas', 'required');
        $this->form_validation->set_rules('wali_kelas', 'Wali Kelas', 'required');
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('kelas/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Kelas_model->create();
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('/kelas');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Ubah Data Kelas";
        $data['kelas'] = $this->Kelas_model->getById($id);
        $data['guru'] = $this->Guru_model->getAll();
        $this->form_validation->set_rules('nama_kelas', 'Nama kelas', 'required');
        $this->form_validation->set_rules('wali_kelas', 'Wali Kelas', 'required');
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('kelas/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Kelas_model->update($id);
            $this->session->set_flashdata('success', 'Data berhasil diubah.');
            redirect('/kelas');
        }
    }

    public function delete($id)
    {
        $this->Kelas_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('/kelas');  
    }
}
