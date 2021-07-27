<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {


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
        $data['title'] = "Data Guru";
        $data['guru'] = $this->Guru_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('guru/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['guru'] = $this->Guru_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['guru'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('guru/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Tambah Data Guru";
        $this->form_validation->set_rules('nip', 'Nomor Induk Guru', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal lahir', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_handphone', 'No Handphone', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('guru/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Guru_model->create();
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('/guru');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Ubah Data Guru";
        $data['guru'] = $this->Guru_model->getById($id);
        $this->form_validation->set_rules('nip', 'Nomor Induk Guru', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal lahir', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_handphone', 'No Handphone', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('guru/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Guru_model->update($id);
            $this->session->set_flashdata('success', 'Data berhasil diubah.');
            redirect('/guru');
        }
    }

    public function delete($id)
    {
        $this->Guru_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('/guru');  
    }
}
