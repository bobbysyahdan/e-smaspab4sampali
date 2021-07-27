
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
                                <!-- <form action="<s?= base_url('bookIdentity/create') ?>" method="POST" enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('bookIdentity/test');?>
                                    <div class="row">
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>File:</strong>
                                                <input type="file" name="file" class="form-control">
                                                <small class="text-danger"><?= form_error('file') ?></small>
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
