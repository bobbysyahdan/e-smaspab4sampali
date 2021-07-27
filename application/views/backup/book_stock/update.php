
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
                                <form action="<?= base_url('bookStock/update/'.$book_stock['id']) ?>" method="POST">
                                    <div class="row">
                                        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Book:</strong>
                                                <select name="id_book" id="id_book" class="form-control" readonly>
                                                    <option value="" disabled selected>- Choose Book -</option>
                                                    <s?php if(count($book_identities) > 0): foreach($book_identities as $data): ?>
                                                        <option value="<s?= $data['id'] ?>" <s?= $book_stock['id_book'] == $data['id'] ? 'selected' : ''?>><s?= $data['title'] ?></option>
                                                    <s?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><s?= form_error('id_book') ?></small>
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Book:</strong>
                                                <input type="text" name="id_book" class="form-control" placeholder="Book" value="<?= $book_identities->getById($book_stock['id_book'])['title'] .' (ISBN: '.$book_identities->getById($book_stock['id_book'])['isbn'].')' ?>" readonly>
                                                <small class="text-danger"><?= form_error('id_book') ?></small>
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Book Type:</strong>
                                                <select name="book_type" id="book_type" class="form-control">
                                                    <option value="" disabled selected>- Choose Book -</option>
                                                    <s?php if(count($book_types) > 0): foreach($book_types as $data): ?>
                                                        <option value="<s?= $data['id'] ?>" <s?= $book_stock['book_type'] == $data['id'] ? 'selected' : ''?>><?= $data['name'] ?></option>
                                                    <s?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><s?= form_error('book_type') ?></small>
                                            </div>
                                        </div> -->
                                        
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Total Stock of Printed Book:</strong>
                                                <input type="text" name="stock" class="form-control" placeholder="Stock" value="<?= $book_stock['stock'] ?>">
                                                <small class="text-danger"><?= form_error('stock') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Weight (Kg):</strong>
                                                <input type="text" name="weight" class="form-control" placeholder="weight" value="<?= $book_stock['weight'] ?>">
                                                <small class="text-danger"><?= form_error('weight') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Available:</strong>
                                                <div class="demo-inline-spacing">
                                                    <?php if(count($available_status) > 0): foreach($available_status as $key => $data): ?>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio<?=$key?>" name="is_available" class="custom-control-input" value="<?= $data['id'] ?>" <?= $data['id'] == $book_stock['is_available'] ? 'checked=""' : 'unchecked=""'?>>
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
                                                <input type="text" name="price" class="form-control" placeholder="Price" value="<?= $book_stock['price'] ?>">
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

   
