
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
                                <form action="<?= base_url('guru/create') ?>" method="POST">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Nomor Induk Guru:</strong>
                                                <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Guru" value="<?= set_value('nip') ?>">
                                                <small class="text-danger"><?= form_error('nip') ?></small>
                                            </div>
                                            <div class="form-group">
                                                <strong>Nama Lengkap:</strong>
                                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" value="<?= set_value('nama_lengkap') ?>">
                                                <small class="text-danger"><?= form_error('nama_lengkap') ?></small>
                                            </div>
                                            <div class="form-group">
                                                <strong>Alamat:</strong>
                                                <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?= set_value('alamat') ?>">
                                                <small class="text-danger"><?= form_error('alamat') ?></small>
                                            </div>
                                            <div class="form-group">
                                                <strong>Tempat Lahir:</strong>
                                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?= set_value('tempat_lahir') ?>">
                                                <small class="text-danger"><?= form_error('tempat_lahir') ?></small>
                                            </div>
                                            <div class="form-group">
                                                <strong>Tanggal Lahir:</strong>
                                                <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="<?= set_value('tanggal_lahir') ?>">
                                                <small class="text-danger"><?= form_error('tanggal_lahir') ?></small>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Jenis Kelamin:</strong>
                                                <div class="demo-inline-spacing">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio1" name="jenis_kelamin" class="custom-control-input" value="1">
                                                        <label class="custom-control-label" for="customRadio1">Laki-laki</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio2" name="jenis_kelamin" class="custom-control-input" value="2">
                                                        <label class="custom-control-label" for="customRadio2">Perempuan</label>
                                                    </div>
                                                </div>
                                                <small class="text-danger"><?= form_error('role') ?></small>
                                            </div>
                                            <div class="form-group">
                                                <strong>Nomor Handphone:</strong>
                                                <input type="text" name="no_handphone" class="form-control" placeholder="no_handphone" value="<?= set_value('no_handphone') ?>">
                                                <small class="text-danger"><?= form_error('no_handphone') ?></small>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Simpan</button>
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

   
