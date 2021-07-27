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
                                    <h4 style="margin-bottom: 10px">List Detail Purchase</h4>
                                    <?php foreach($purchases as $purchase):?>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Book Title</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $this->Book_stock_model->getById($purchase['id_book_stock'])['title'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Quantity</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $purchase['quantity'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td>Rp<?= number_format($this->Book_stock_model->getById($purchase['id_book_stock'])['price'],0,'.','.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <?php endforeach; ?>

                                    <hr>
                                    <h4 style="margin-bottom: 10px">Voucher</h4>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Voucher</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $transaction['id_voucher'] == NULL ? '-' : $this->Voucher_model->getById($transaction['id_voucher'])['voucher_code'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Persentage Discount Voucher</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $transaction['discount'] == NULL ? '-' : $this->Voucher_model->getById($transaction['id_voucher'])['percentage_discount'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Discount</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $transaction['discount'] == NULL ? '-' : 'Rp'.number_format($transaction['discount'],0,'.','.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr>
                                    <h4 style="margin-bottom: 10px">Total Purchase</h4>
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
                                                <td>
                                                    <b><?= $email_reader_model->getByIdTransaction($transaction['id']) ? $email_reader_model->getByIdTransaction($transaction['id'])['email'] : 'No set' ?></b>
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                            <tr>
                                                <td>Shipping Address</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $shipping_book_model->getByIdTransaction($transaction['id']) ? $shipping_book_model->getByIdTransaction($transaction['id'])['alamat'] : 'No set' ?></td>
                                            </tr>
                                            <?php 
                                                $shipping_book = $shipping_book_model->getByIdTransaction($transaction['id']);
                                                if($shipping_book):
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td class="pr-1 pl-1"></td>
                                                <td>
                                                    <b><?= $this->Ref_kota_rajaongkir_model->getById($shipping_book_model->getByIdTransaction($transaction['id'])['id_kota'])['nama_kota']. ' - '.$this->Ref_kota_rajaongkir_model->getById($shipping_book_model->getByIdTransaction($transaction['id'])['id_kota'])['provinsi'] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="pr-1 pl-1"></td>
                                                <td>
                                                    <b><?= $shipping_book_model->getByIdTransaction($transaction['id'])['kode_pos'] ?></b>
                                                </td>
                                            </tr>
                                            <?php endif; ?>

                                            <tr>
                                                <td>Shipping Price</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $shipping_book_model->getByIdTransaction($transaction['id']) ? 'Rp'.number_format($shipping_book_model->getByIdTransaction($transaction['id'])['shipping_price'],0,'.','.') : 'No set' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Total Weight</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $total_weight.' kg' ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            
                                            <tr>
                                                <td>Total Price</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= 'Rp'.number_format($transaction['total_price'],0,'.','.') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td class="pr-1 pl-1">:</td>
                                                <td><?= $purchase_model->getStatus($purchase['status_purchase'])['status'] ?></td>
                                            </tr>
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
</div>
<!-- END: Content-->

   
