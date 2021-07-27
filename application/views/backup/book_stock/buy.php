
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
                                <form action="<?= base_url('bookStock/buy/'.$book_stock['id']) ?>" method="POST">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Book:</strong>
                                                <input type="text" name="id_book" class="form-control" value="<?= $model->getBook($book_stock['id_book'])['title'] ?>" readonly>
                                                <input type="hidden" name="id_book_stock" class="form-control" value="<?= $book_stock['id'] ?>">

                                                <!-- <small class="text-danger"><s?= form_error('id_book') ?></small> -->
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Quantity:</strong>
                                                <input type="text" id="amount_book" name="quantity" class="form-control" placeholder="Quantity" value="1">
                                                <small class="text-danger"><?= form_error('quantity') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong> Price (IDR):</strong>
                                                <input type="hidden" name="trigger_price" id="trigger_price" class="form-control" placeholder="Price" value="<?= $book_stock['price'] ?>">
                                                <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="<?= $book_stock['price'] ?>" readonly>
                                                <small class="text-danger"><?= form_error('price') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Buy</button>
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

   
