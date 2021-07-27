
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
                                <form action="<?= base_url('refSubscribePackage/update/'.$ref_subscribe_package['id']) ?>" method="POST">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Package Name:</strong>
                                                <input type="text" name="package" class="form-control" placeholder="Package Name" value="<?= $ref_subscribe_package['package'] ?>">
                                                <small class="text-danger"><?= form_error('package') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Package Edition:</strong>
                                                <select name="id_package_edition" id="id_package_edition" class="form-control">
                                                    <?php if(count($package_editions) > 0): foreach($package_editions as $package_edition): ?>
                                                        <option value="<?= $package_edition['id'] ?>" <?= $package_edition['id'] == $ref_subscribe_package['id_package_edition'] ? 'selected' : ''?>><?= $package_edition['package_edition'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_package_edition') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Amout of Days:</strong>
                                                <input type="text" name="days" class="form-control" placeholder="Days" value="<?= $ref_subscribe_package['days'] ?>">
                                                <small class="text-danger"><?= form_error('days') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Price:</strong>
                                                <input type="text" name="price" class="form-control" placeholder="Price" value="<?= $ref_subscribe_package['price'] ?>">
                                                <small class="text-danger"><?= form_error('price') ?></small>
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

   
