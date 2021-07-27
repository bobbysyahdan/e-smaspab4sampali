
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
                                <?php $total_price = 0; ?>
                            </div>
                            <div class="card-body mt-2">
                                <form action="<?= base_url('purchase/addEmailReader/'.$id_transaction) ?>" method="POST">
                                    <div class="row mb-1">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Plesea Insert Your Email for send e-book:</strong>
                                                <input type="text" name="email" class="form-control" placeholder="email" value="<?= set_value('email') ?>">
                                                <small class="text-danger"><?= form_error('email') ?></small>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title">Checkout</h4>
                                    <?php foreach($purchases as $purchase):
                                        $total_price += $purchase['price'];
                                    ?>
                                    <table class="mt-1">
                                        <tbody>
                                            <tr>
                                                <td>Book Title</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $purchase_model->getBook($purchase['id'])['title'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Quantity</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $purchase['quantity'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td>Rp<?= number_format($purchase_model->getBookStock($purchase['id'])['price'],0,'.','.')?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php endforeach; ?>
                                    <hr>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>NO. ORDER</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $transaction['no_order'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Book Type</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $transaction['book_type'] == 1 ? 'Digital' : 'Printed' ?></td>
                                            </tr>
                                            <?php if($transaction['book_type'] == 1): ?>
                                            <tr>
                                                <td>Email Reader</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $email_reader_model->getByIdTransaction($transaction['id']) ? $email_reader_model->getByIdTransaction($transaction['id'])['email'] : 'No set' ?></td>
                                            </tr>
                                            <?php else: ?>
                                            <tr>
                                                <td>Shipping Address</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $shipping_book_model->getByIdTransaction($transaction['id']) ? $shipping_book_model->getByIdTransaction($transaction['id'])['alamat'] : 'No set' ?></td>
                                            </tr>
                                            <?php endif; ?>

                                            <tr>
                                                <td>Total Price</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= 'Rp'.number_format($total_price,0,'.','.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row mt-2">
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Payment Process</button>
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

   
