
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
                                <form action="<?= base_url('book/subscribe/'.$book_identity['id']) ?>" method="POST">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Book Title:</strong>
                                                <input type="text" name="book" class="form-control" value="<?= $book_identity['title'] ?>" readonly>
                                                <input type="hidden" name="id_book" class="form-control" value="<?= $book_identity['id'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Subscribe Package:</strong>
                                                <select name="id_subscribe_package" id="id_subscribe_package" class="form-control">
                                                    <option value="" disabled selected>- Choose Subscribe Package-</option>
                                                    <?php if(count($subscribe_packages) > 0): foreach($subscribe_packages as $package): ?>
                                                        <option value="<?= $package['id'] ?>">
                                                        <?= $package['package'].' - '.$package['days'].' days'.' - '.'Rp'.number_format($package['price'], 0,'.','.') ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_subscribe_package') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Subscibe</button>
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

   
