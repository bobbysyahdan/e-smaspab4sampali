<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Reset Password Akun Pengguna</title>
    <link rel="apple-touch-icon" href="<?= base_url('assets_template/app-assets/images/ico/apple-icon-120.png') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets_template/app-assets/images/ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/vendors/css/vendors.min.css') ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/bootstrap-extended.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/colors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/components.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/themes/dark-layout.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/themes/bordered-layout.css') ?>">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/plugins/forms/form-validation.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/app-assets/css/pages/page-auth.css') ?>">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_template/assets/css/style.css') ?>">
    <!-- END: Custom CSS-->

</head>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern dark-layout blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page" data-layout="dark-layout">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Reset Password</h4>
                                <?php if($this->session->flashdata('success')): ?>
                                   <div class="col-md-12 p-0 mt-2">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Success
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h4>
                                            <div class="alert-body">
                                                <?= $this->session->flashdata('success') ?>
                                            </div>
                                        </div>
                                   </div>
                                 <?php elseif($this->session->flashdata('failed')): ?>
                                    <div class="col-md-12 p-0 mt-2">
                                        <div class="alert alert-danger" role="alert">
                                            <h4 class="alert-heading">Failed
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h4>
                                            <div class="alert-body">
                                                <?= $this->session->flashdata('failed') ?>
                                            </div>
                                        </div>
                                   </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body mt-2">
                                <form action="<?= base_url('akun/resetPassword/'.$user['remember_token']) ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input type="text" name="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>">
                                                <small class="text-danger"><?= form_error('email') ?></small>
                                            </div>
                                        </div>
                                       
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
</body>
</html>
