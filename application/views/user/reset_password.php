
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
                                <form action="<?= base_url('user/resetPassword/'.$user['id']) ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                       
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Password Baru:</strong>
                                                <input type="password" name="password" class="form-control" placeholder="Password">
                                                <small class="text-danger"><?= form_error('password') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Konfirmasi Password Baru:</strong>
                                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                                <small class="text-danger"><?= form_error('confirm_password') ?></small>
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
