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
                                <div style="text-align: right;">
                                    <a href="/bookStock/create" class="btn btn-primary"><b>
                                    <i data-feather="plus" style="margin-right: 5px;"></i></b>Create New</a>
                                </div>
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
                            </div>
                            <div class="card-body">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="table_id"> 
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Book</th>
                                                <!-- <th>Book Type</th> -->
                                                <th>Total Stock of Printed Book</th>
                                                <th>Weight
                                                <th>Amount of digital books sold out</th>
                                                <th>Amount of printed books sold out</th>
                                                <th>Stock Available of Printed Book</th>
                                                <th>Price</th>
                                                <th>Available</th>
                                                <!-- <th>Buy</th> -->
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($book_stocks) > 0):
                                                foreach($book_stocks as $key => $book_stock): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $model->getBook($book_stock['id_book'])['title'] ?></td>
                                                <!-- <td><s?= $model->getBookTypes()[$book_stock['book_type']-1]['name'] ?></td> -->
                                                <td><?= $book_stock['stock'] ?></td>
                                                <td><?= $book_stock['weight'].'kg' ?></td>
                                                <td><?= $book_stock['amount_digital_buyer'] == NULL ? 0 : $book_stock['amount_digital_buyer'] ?></td>
                                                <td><?= $book_stock['amount_printed_buyer'] == NULL ? 0 : $book_stock['amount_printed_buyer'] ?></td>
                                                <td><?= $book_stock['stock'] - $book_stock['amount_printed_buyer'] ?></td>
                                                <td><?= 'Rp'.number_format($book_stock['price'], 0, '.', '.') ?></td>
                                                <td><?= $book_stock['is_available'] == 1 ? 'Available' : 'No Available' ?></td>
                                                <!-- <td><a href="<?= base_url('/bookStock/buy/'.$book_stock['id']) ?>" class="btn btn-primary">Buy</a></td> -->
                                                <td>
                                                    <a href="<?= base_url('/bookStock/show/'.$book_stock['id']) ?>"><i data-feather="eye"></i></a>
                                                    <a href="<?= base_url('/bookStock/update/'.$book_stock['id']) ?>"><i data-feather="edit"></i></a>
                                                    <a href="<?= base_url('/bookStock/delete/'.$book_stock['id']) ?>" onclick="return confirm('Are you sure ?')"><i data-feather="trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                endforeach; 
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>
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

