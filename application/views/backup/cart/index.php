<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="ajax-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title"><?= $title ?></h4>
                                <!-- <div style="text-align: right;">
                                    <a href="/cart/create" class="btn btn-primary"><b>
                                    <i data-feather="plus" style="margin-right: 5px;"></i></b>Create New</a>
                                </div> -->
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
                                <?php endif; ?>

                                <?php if($this->session->flashdata('failed')): ?>
                                   <div class="col-md-12 p-0 mt-2">
                                        <div class="alert alert-danger" role="alert">
                                            <h4 class="alert-heading">failed
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
                            <div class="card-body">
                                <div class="card-datatable">
                                    <form action="<?= base_url('purchase/addPurchaseBook') ?>" method="POST">
                                        <table class="datatables-ajax table"> 
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>No.</th>
                                                    <th>Book</th>
                                                    <!-- <th>Type</th> -->
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    if(count($carts) > 0):
                                                    foreach($carts as $key => $cart): 
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control">
                                                            <input type="checkbox" name="checkbox<?=$cart['id']?>" value="<?= $cart['id']?>" class="custom-control-input" style="opacity: 1;">
                                                        </div>
                                                    </td>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $model->getBook($cart['id_book_stock'])['title'] ?></td>
                                                    <!-- <td><s?= $model->getBookType($cart['id_book_stock'])['name'] ?></td> -->
                                                    <td><?= $cart['quantity'] ?></td>
                                                    <td><?= 'Rp'.number_format($cart['price'],0,'.','.') ?></td>
                                                    <td>
                                                        <a href="<?= base_url('/cart/delete/'.$cart['id']) ?>" class="btn btn-primary" onclick="return confirm('Are you sure ?')">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    endforeach; 
                                                    endif;
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php if(count($carts) > 0): ?>
                                        <button type="button" class="btn btn-primary waves-effect col-md-12 mt-2" data-toggle="modal" data-target="#exampleModalCenter">
                                            Purchase
                                        </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-primary col-md-12" style="margin-top: 20px;">Purchase</button>
                                        <?php endif; ?>

                                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Choose Book Type:</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>

                                                    <input type="hidden" name="book_type" id="book_type">
                                                    <div class="modal-body">
                                                        <div class="mt-2 mb-2" style="display: flex;">
                                                            <div class="col-md-6">
                                                                <button type="submit" id="btn-digital" class="btn btn-primary col-md-12">Digital</button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="submit" id="btn-printed" class="btn btn-primary col-md-12">Printed</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-primary waves-effect waves-float waves-light" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->

