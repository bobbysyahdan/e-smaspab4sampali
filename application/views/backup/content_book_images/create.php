
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
                                <!-- <form action="<s?= base_url('bookContentImages/create/'.$id_book_identity) ?>" method="POST" enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart("bookContentImages/create/$id_book_identity");?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Book Identity:</strong>
                                                <input type="text" name="book_identity" value="<?= $title_book_identity ?>" class="form-control" readonly>
                                                <small class="text-danger"><?= form_error('book_identity') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Upload File PDF:</strong>
                                                <input type="file" name="file_pdf_uploaded" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Save</button>
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
