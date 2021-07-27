<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="ajax-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title"><?= $title ?></h4>
                                <div style="text-align: right;">
                                    <a href="/transaksiPembayaranSPP/create" class="btn btn-primary"><b>
                                    <i data-feather="plus" style="margin-right: 5px;"></i></b>Tambah Data</a>
                                </div>
                                 <?php if($this->session->flashdata('success')): ?>
                                   <div class="col-md-12 p-0 mt-2">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Berhasil
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h4>
                                            <div class="alert-body">
                                                <?= $this->session->flashdata('success') ?>
                                            </div>
                                        </div>
                                   </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="table_id"> 
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kode Pembayaran</th>
                                                <th>NIS</th>
                                                <th>Nama Siswa</th>
                                                <th>Jumlah Pembayaran</th>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($transaksi_pembayaran_spp) > 0):
                                                foreach($transaksi_pembayaran_spp as $key => $value): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $value['kode_pembayaran'] ?></td>
                                                <td><?= $this->Siswa_model->getById($value['siswa'])['nis'] ?></td>
                                                <td><?= $this->Siswa_model->getById($value['siswa'])['nama_lengkap'] ?></td>
                                                <td><?= 'Rp'.number_format($value['jumlah_pembayaran'],0,'.','.') ?></td>
                                                <td><?= $value['tanggal_pembayaran'] ?></td>

                                                <td>
                                                    <!-- <a href="<?= base_url('/transaksiPembayaranSPP/show/'.$value['id']) ?>"><i data-feather="eye"></i></a> -->
                                                    <a href="<?= base_url('/transaksiPembayaranSPP/update/'.$value['id']) ?>"><i data-feather="edit"></i></a>
                                                    <a href="<?= base_url('/transaksiPembayaranSPP/delete/'.$value['id']) ?>" onclick="return confirm('Apakah anda yakin ?')"><i data-feather="trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                endforeach; 
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->

