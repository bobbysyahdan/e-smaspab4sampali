<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransaksiPembayaranSPP extends CI_Controller {


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
        $data['title'] = "Data Transaksi Pembayaran SPP";
        $data['transaksi_pembayaran_spp'] = $this->Transaksi_pembayaran_spp_model->getAll();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/menu');
        $this->load->view('transaksi_pembayaran_spp/index', $data);
        $this->load->view('layouts/footer');
    }

    public function show($id)
    {
        $data['transaksi_pembayaran_spp'] = $this->Transaksi_pembayaran_spp_model->getById($id);
        $data['title'] = 'Detail Data';
        if(isset($data['transaksi_pembayaran_spp'])) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('transaksi_pembayaran_spp/show', $data);
            $this->load->view('layouts/footer');
        }
    }
    
    public function create()
	{   
        $data['title'] = "Tambah Data Transaksi Pembayaran SPP";
        $data['siswa'] = $this->Siswa_model->getAll();
        $this->form_validation->set_rules('kode_pembayaran', 'Kode Pembayaran', 'required');
        $this->form_validation->set_rules('siswa', 'Siswa', 'required');
        $this->form_validation->set_rules('jumlah_pembayaran', 'Jumlah Pembayaran', 'required');
        $this->form_validation->set_rules('tanggal_pembayaran', 'Tanggal Pembayaran', 'required');


        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('transaksi_pembayaran_spp/create', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Transaksi_pembayaran_spp_model->create();
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('/transaksiPembayaranSPP');
        }
    }

    public function update($id)
	{   
        $data['title'] = "Ubah Data Transaksi Pembayaran SPP";
        $data['siswa'] = $this->Siswa_model->getAll();
        $data['transaksi_pembayaran_spp'] = $this->Transaksi_pembayaran_spp_model->getById($id);
        $this->form_validation->set_rules('kode_pembayaran', 'Kode Pembayaran', 'required');
        $this->form_validation->set_rules('siswa', 'Siswa', 'required');
        $this->form_validation->set_rules('jumlah_pembayaran', 'Jumlah Pembayaran', 'required');
        $this->form_validation->set_rules('tanggal_pembayaran', 'Tanggal Pembayaran', 'required');


        if($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/menu');
            $this->load->view('transaksi_pembayaran_spp/update', $data);
            $this->load->view('layouts/footer');
        } else {
            $this->Transaksi_pembayaran_spp_model->update($id);
            $this->session->set_flashdata('success', 'Data berhasil diubah.');
            redirect('/transaksiPembayaranSPP');
        }
    }

    public function delete($id)
    {
        $this->Transaksi_pembayaran_spp_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('/transaksiPembayaranSPP');  
    }
}
