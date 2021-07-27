
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
                                <form action="<?= base_url('kelas/update/'.$kelas['id']) ?>" method="POST">
                                    <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        
                                    <div class="form-group">
                                        <strong>Nama kelas:</strong>
                                        <input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas" value="<?= $kelas['nama_kelas'] ?>">
                                        <small class="text-danger"><?= form_error('nama_kelas') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <strong>Wali Kelas:</strong>
                                        <select name="wali_kelas" id="wali_kelas" class="form-control">
                                            <option value="" disabled selected>- Pilih Wali Kelas-</option>
                                            <?php if(count($guru) > 0): foreach($guru as $value): ?>
                                                <option value="<?= $value['id'] ?>" <?= $value['id'] ==  $kelas['wali_kelas'] ? 'selected' : '' ?>><?= $value['nip'].' - '.$value['nama_lengkap'] ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                        <small class="text-danger"><?= form_error('wali_kelas') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <strong>Tahun Ajaran:</strong>
                                        <input type="text" name="tahun_ajaran" class="form-control" placeholder="Tahun Ajaran" value="<?= $kelas['tahun_ajaran'] ?>">
                                        <small class="text-danger"><?= form_error('tahun_ajaran') ?></small>
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

   
