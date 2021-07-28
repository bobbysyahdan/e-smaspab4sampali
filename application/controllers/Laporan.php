<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('User_model');
            $this->load->model('Siswa_model');
            $this->load->model('Guru_model');
            $this->load->model('Kelas_model');
            $this->load->model('Transaksi_pembayaran_spp_model');
            $this->load->library('form_validation');
        }

	public function index()
	{
                if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
                        redirect('/site/login');
                }
                
                $data['bulan'] = [
                        [
                                "id" => 1,
                                "nama" => "Januari",
                        ],
                        [
                                "id" => 2,
                                "nama" => "Februari",
                        ],
                        [
                                "id" => 3,
                                "nama" => "Maret",
                        ],
                        [
                                "id" => 4,
                                "nama" => "April",
                        ],
                        [
                                "id" => 5,
                                "nama" => "Mei",
                        ],
                        [
                                "id" => 6,
                                "nama" => "Juni",
                        ],
                        [
                                "id" => 7,
                                "nama" => "Juli",
                        ],
                        [
                                "id" => 8,
                                "nama" => "Agustus",
                        ],
                        [
                                "id" => 9,
                                "nama" => "September",
                        ],
                        [
                                "id" => 10,
                                "nama" => "Oktober",
                        ],
                        [
                                "id" => 11,
                                "nama" => "November",
                        ],
                        [
                                "id" => 12,
                                "nama" => "Desember",
                        ],
                ];

                $data['tahun'] = date('Y');
                $data['title'] = "SMAS PAB 4 SAMPALI";
                
                $this->form_validation->set_rules('bulan', 'Bulan', 'required');
                $this->form_validation->set_rules('tahun', 'Tahun', 'required');

                if($this->form_validation->run() == FALSE) {
                        $this->load->view('layouts/header_site', $data);
                        $this->load->view('layouts/menu');
                        $this->load->view('laporan/index');
                        $this->load->view('layouts/footer');
                } else {
                        $bulan = $this->input->post('bulan');
                        $tahun = $this->input->post('tahun');
                        redirect("/laporan/cetak/$bulan/$tahun");
                }
        }


        public function cetak($bulan, $tahun)
	{
                if(!$this->session->userdata('email') || $this->session->userdata('role') != 1) {
                        redirect('/site/login');
                }
                
                $data['transaksi_pembayaran_spp'] = $this->Transaksi_pembayaran_spp_model->getAllByBulantahun($bulan, $tahun);
                
                $data['title'] = "SMAS PAB 4 SAMPALI";
                $this->load->view('laporan/cetak', $data);
        }
}
