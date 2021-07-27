
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <?php foreach($transactions as $transaction):
                    $total_price = 0 ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title"><?= $title ?></h4>
                            </div>
                                
                            <div class="card-body">
                                <?php 
                                    foreach($purchases as $purchase): 
                                    if($transaction['id'] == $purchase['id_transaction']):
                                    $total_price += $purchase['price'];
                                ?>
                                <div class="row">
                                    <div class="card-datatable ml-1 mt-2">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Book Title</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $model->getBook($purchase['id_book_stock'])['title'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Book Type</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $purchase['book_type'] == 1 ? 'Digital' : 'Printed'?></td>
                                                </tr>
                                                <tr>
                                                    <td>Quantity</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $purchase['quantity'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Price</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= 'Rp'.number_format($purchase['price'],0,'.','.') ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endif; endforeach; ?>
                                <hr>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>NO. ORDER</td>
                                            <td class="pr-1 pl-1">:</td>
                                            <td><?= $transaction['no_order'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Price</td>
                                            <td class="pr-1 pl-1">:</td>
                                            <td><?= 'Rp'.number_format($total_price,0,'.','.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php if($transaction['id_status'] == 1): ?>
                                    <a href="/purchase/paymentProcess/<?= $transaction['id'] ?>" class="btn btn-primary col-md-12 mt-2">Payment Process</a>
                                <?php elseif($transaction['id_status'] == 2): ?>
                                    <a disable class="btn btn-primary col-md-12 mt-2">Transaction on Pending</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- END: Content-->

   
