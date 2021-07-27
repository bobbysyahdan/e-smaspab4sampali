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
                            <div class="card-body">
                                <div class="row">
                                    <div class="card-datatable ml-1 mt-2">
                                            <h5 class="title"></b></h5>
                                            <div class="col-md-12 p-0">
                                                <div class="alert <?= $transaction_status == "settlement" ? 'alert-success' : 'alert-danger'?>" role="alert">
                                                    <h4 class="alert-heading">No Transaksi #<b><?= $order_id ?>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </h4>
                                                    <div class="alert-body">
                                                        <?php if($transaction_status != null): ?>
                                                            <?php if($transaction_status == "pending"): ?>
                                                                <h5 class="title mb-2">Anda belum bayar pada transaksi ini. Silahkan bayar untuk menyelesaikan transaksi.</h5>
                                                                <a href="/purchase" class="btn btn-primary cold-md-12" target="_blank">Back to Purchase</a>
                                                            <?php elseif($transaction_status == "expire"): ?>
                                                                <h5 class="title mb-2">Masa waktu pada transaksi ini sudah expired. Silahkan buat transaksi baru</h5>
                                                                <a href="/purchase/repayment" class="btn btn-primary cold-md-12">Re-Payment</a>
                                                            <?php elseif($transaction_status == "settlement"): ?>
                                                                <h5 class="title mb-2">Pembayaran sukses. Transaksi anda selesai. <br> Terimakasih sudah menggunakan platform kami.</h5>
                                                                <a href="/purchase" class="btn btn-primary cold-md-12" target="_blank">Back to Purchase</a>
                                                            <?php else:?>
                                                                <h5 class="title mb-2">Nomor transaksi tidak ditemukan.</h5>
                                                            <?php endif;?>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
