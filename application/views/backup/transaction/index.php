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
                            </div>
                            <div class="card-body">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="table_id"> 
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Datetime</th>
                                                <th>No Order</th>
                                                <!-- <th>Book Type</th> -->
                                                <th>Price</th>
                                                <th>Voucher Code</th>
                                                <th>Percentage Discount (%)</th>
                                                <th>Total Discount</th>
                                                <th>Shipping Price</th>
                                                <th>Total Price</th>
                                                <th>Transaction Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($transactions) > 0):
                                                foreach($transactions as $key => $transaction): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $transaction['waktu'] ?></td>
                                                <td><?= $transaction['no_order'] ?></td>
                                                <!-- <td><?= $transaction['book_type'] == 1 ? 'Digital' : 'Printed' ?></td> -->
                                                <td><?= 'Rp'.number_format($transaction['price'], 0, '.','.') ?></td>
                                                <td><?= $transaction['id_voucher'] == 0 ? "-" : $this->Voucher_model->getById($transaction['id_voucher'])['voucher_code'] ?></td>
                                                <td><?= $transaction['id_voucher'] == 0 ? "-" : $this->Voucher_model->getById($transaction['id_voucher'])['percentage_discount'] ?></td>
                                                <td><?= $transaction['discount'] == 0 ? "-" : 'Rp'.number_format($transaction['discount'], 0, '.','.') ?></td>
                                                <td><?= 'Rp'.number_format($model->getShippingBook($transaction['id'])['shipping_price'], 0, '.','.') ?></td>
                                                <td><?= 'Rp'.number_format($transaction['total_price'], 0, '.','.') ?></td>
                                                <!-- <td><?= $status->getStatus($transaction['id_status'])['status'] ?></td> -->
                                                <td>
                                                    <?php if($transaction['id_status'] == 1): ?>
                                                        <a disable class="btn btn-warning col-md-12 mt-2">Payment</a>
                                                    <?php elseif($transaction['id_status'] == 2): ?>
                                                        <a disable class="btn btn-warning col-md-12 mt-2">Transaction on Pending</a>
                                                    <?php elseif($transaction['id_status'] == 4): ?>
                                                        <a disable class="btn btn-danger col-md-12 mt-2">Expire</a>
                                                    <?php elseif($transaction['id_status'] == 5): ?>
                                                        <a disable class="btn btn-success col-md-12 mt-2">Settlement</a>
                                                    <?php elseif($transaction['id_status'] == 3): ?>
                                                        <a disable class="btn btn-danger col-md-12 mt-2">Canceled</a>
                                                    <?php endif; ?>
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

