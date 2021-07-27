<style>
    table {
        text-align:center;
    }
</style>
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
                                                <th>Datetime</th>
                                                <th>No. Order</th>
                                                <th>Book Type</th>
                                                <th>Detail</th>
                                                <th>Status</th>
                                                <th>Receipt Number</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($transactions) > 0):
                                                foreach($transactions as $key => $transaction): 
                                            ?>
                                            
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <!-- <td>
                                                    <s?php 
                                                        foreach($transaction_model->getPurchases($transaction['id']) as $key => $purchase){
                                                            if(isset($purchase)) {
                                                                echo '<li>'.$book_stock_model->getBook($book_stock_model->getById($purchase['id_book_stock'])['id_book'])['title'].'</li>';
                                                            }
                                                        }
                                                    ?>
                                                </td> -->
                                                <!-- <td><s?= $transaction['book_type'] == 1 ? 'Digital' : 'Printed' ?></td> -->
                                                <td><?= $purchase_model->getByIdTransactions($transaction['id'])[0]['waktu'] ?></td>
                                                <td><?= $transaction['no_order'] ?></td>
                                                <!-- <td><?= 'Rp'.number_format($transaction['total_price'], 0, '.','.') ?></td> -->
                                                <!-- <td><?= $purchase_model->getStatus($purchase_model->getByIdTransaction($transaction['id'])['id_status'])['status'] ?></td> -->
                                                <td><?= $transaction['book_type'] == 1 ? 'Digital' : 'Printed' ?></td>
                                                <td><a href="/purchase/detail/<?= $transaction['id'] ?>" class="btn btn-primary">Detail</a></td>

                                                <td>
                                                    <?php if($purchase_model->getByIdTransactions($transaction['id'])[0]['status_purchase'] == 1): ?>
                                                        <p class="mt-2">Payment Verification</p>
                                                    <?php elseif($purchase_model->getByIdTransactions($transaction['id'])[0]['status_purchase'] == 2): ?>
                                                        <p class="mt-2">Delivery on Progress</a>
                                                    <?php elseif($purchase_model->getByIdTransactions($transaction['id'])[0]['status_purchase'] == 3): ?>
                                                        <p class="mt-2">Delivered</p>
                                                    <?php elseif($purchase_model->getByIdTransactions($transaction['id'])[0]['status_purchase'] == 4): ?>
                                                        <p class="mt-2">Canceled</p>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <p><?= $transaction['no_resi'] == null ? '-' : $transaction['no_resi'] ?></p>
                                                </td>
                                                <td>
                                                    <?php if($purchase_model->getByIdTransactions($transaction['id'])[0]['status_purchase'] == 2 && $transaction['no_resi'] == NULL): ?>
                                                        <a href="<?= base_url('/purchase/receiptNumber/'.$transaction['id']) ?>" class="btn btn-primary mt-2">Enter Receipt Number</a>                                                    
                                                    <?php elseif($purchase_model->getByIdTransactions($transaction['id'])[0]['status_purchase'] == 2 && $transaction['no_resi'] != NULL): ?>
                                                        <p></p><a href="<?= base_url('/purchase/receiptNumber/'.$transaction['id']) ?>" class="btn btn-primary">Update Receipt Number</a></p>
                                                        <p><a href="<?= base_url('/purchase/updateStatusDelivered/'.$transaction['id']) ?>" class="btn btn-primary" onclick="return confirm('Are you sure ?')">Click for Change Status be Delivered</a></p>
                                                    <?php else: ?>
                                                        <p>No Action</p>
                                                    <?php endif; ?>
                                                </td>
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
            </div>
        </div>
    </div>
    <!-- END: Content-->

   
