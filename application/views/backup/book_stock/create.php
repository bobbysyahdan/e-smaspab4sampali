
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
                                <form action="<?= base_url('bookStock/create') ?>" method="POST">
                                    <div class="row">

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Book:</strong>
                                                <select name="id_book" class="select2 form-control" id="default-select">
                                                    <option value="" disabled selected>- Choose Book  -</option>
                                                    <?php if(count($book_identities) > 0): foreach($book_identities as $value): ?>
                                                        <option value="<?= $value['id'] ?>"><?= $value['title'].' '.'(ISBN: '.$value['isbn'].')' ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_book') ?></small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Total Stock of Printed Book :</strong>
                                                <input type="text" name="stock" id="stock" class="form-control" placeholder="Stock" value="<?= set_value('stock') ?>">
                                                <small class="text-danger"><?= form_error('stock') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Weight (Kg):</strong>
                                                <input type="text" name="weight" id="weight" class="form-control" placeholder="0.5" value="<?= set_value('weight') ?>">
                                                <small class="text-default">Format nilai harus desimal. Untuk nilai desimal gunakan simbol titik ( . )</small>
                                                <small class="text-danger"><?= form_error('weight') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Available:</strong>
                                                <div class="demo-inline-spacing">
                                                    <?php if(count($available_status) > 0): foreach($available_status as $key => $data): ?>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio<?=$key?>" name="is_available" class="custom-control-input" value="<?= $data['id'] ?>">
                                                        <label class="custom-control-label" for="customRadio<?=$key?>"><?= $data['name'] ?></label>
                                                    </div>
                                                    <?php endforeach; endif; ?>
                                                </div>
                                                <small class="text-danger"><?= form_error('is_available') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Price (IDR):</strong>
                                                <input type="text" name="price" class="form-control" id="price" placeholder="Price" value="<?= set_value('price') ?>">
                                                <small class="text-danger"><?= form_error('price') ?></small>
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

   
