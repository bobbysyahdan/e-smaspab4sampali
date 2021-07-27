
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
                                <form action="<?= base_url('voucher/update/'.$voucher['id']) ?>" method="POST">
                                    <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Voucher Code:</strong>
                                                <input type="text" name="voucher_code" class="form-control" placeholder="Voucher Code" value="<?= $voucher['voucher_code'] ?>">
                                                <small class="text-danger"><?= form_error('voucher_code') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Percentage Discount:</strong>
                                                <input type="text" name="percentage_discount" class="form-control" placeholder="Percentage Discount" value="<?= $voucher['percentage_discount'] ?>">
                                                <small class="text-danger"><?= form_error('percentage_discount') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Start Date:</strong>
                                                <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date" value="<?= $voucher['start_date'] ?>">
                                                <small class="text-danger"><?= form_error('start_date') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>End Date:</strong>
                                                <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date" value="<?= $voucher['end_date'] ?>">
                                                <small class="text-danger"><?= form_error('end_date') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Update</button>
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

   
