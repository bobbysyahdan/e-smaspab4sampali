
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title"><?= $title ?></h4>
                            </div>
                            <div class="card-body mt-2">
                                <form action="<?= base_url('transaksiPembayaranSPP/update/'.$transaksi_pembayaran_spp['id']) ?>" method="POST">
                                    <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        
                                    <div class="form-group">
                                        <strong>Kode Pembayaran:</strong>
                                        <input type="text" name="kode_pembayaran" class="form-control" placeholder="Kode Pembayaran" value="<?= $transaksi_pembayaran_spp['kode_pembayaran'] ?>">
                                        <small class="text-danger"><?= form_error('kode_pembayaran') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <strong>Siswa:</strong>
                                        <select name="siswa" id="siswa" class="form-control">
                                            <option value="" disabled selected>- Pilih Siswa-</option>
                                            <?php if(count($siswa) > 0): foreach($siswa as $value): ?>
                                                <option value="<?= $value['id'] ?>" <?= $value['id'] == $transaksi_pembayaran_spp['siswa'] ? "selected" : "" ?>><?= $value['nis'].' - '.$value['nama_lengkap'] ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                        <small class="text-danger"><?= form_error('siswa') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <strong>Jumlah Pembayaran:</strong>
                                        <input type="text" name="jumlah_pembayaran" class="form-control" placeholder="Jumlah Pembayaran" value="<?= $transaksi_pembayaran_spp['jumlah_pembayaran'] ?>">
                                        <small class="text-danger"><?= form_error('jumlah_pembayaran') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <strong>Tanggal Pembayaran:</strong>
                                        <input type="date" name="tanggal_pembayaran" class="form-control" placeholder="Tanggal Pembayaran" value="<?= $transaksi_pembayaran_spp['tanggal_pembayaran'] ?>">
                                        <small class="text-danger"><?= form_error('tanggal_pembayaran') ?></small>
                                    </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary col-md-12">Ubah</button>
                                    </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

   
