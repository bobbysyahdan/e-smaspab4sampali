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
                            <form action="<?= base_url('purchase/addShippingBook/'.$id_transaction) ?>" method="POST">
                                <div class="row mb-1">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Provinsi:</strong>
                                            <select name="id_provinsi" id="id_provinsi" class="form-control">
                                                <option value="" disabled selected>- Pilih Provinsi -</option>
                                                <?php if(count($ref_provinsi_rajaongkir_model->getAll()) > 0): foreach($ref_provinsi_rajaongkir_model->getAll() as $data): ?>
                                                    <option value="<?= $data['id'] ?>"><?= $data['provinsi'] ?></option>
                                                <?php endforeach; endif; ?>
                                            </select>
                                            <small class="text-danger"><?= form_error('id_provinsi') ?></small>
                                        </div>
                                        <div class="form-group">
                                            <strong>Kota:</strong>
                                            <select name="id_kota" id="id_kota" class="form-control">
                                                <option value="" disabled selected>- Pilih Kota -</option>
                                            </select>
                                            <small class="text-danger"><?= form_error('id_kota') ?></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Alamat:</strong>
                                            <input type="text" name="alamat" class="form-control" placeholder="alamat" value="<?= set_value('alamat') ?>">
                                            <small class="text-danger"><?= form_error('alamat') ?></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Kode Pos:</strong>
                                            <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos" value="<?= set_value('kode_pos') ?>">
                                            <small class="text-danger"><?= form_error('kode_pos') ?></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>No Handphone:</strong>
                                            <input type="text" name="no_handphone" class="form-control" placeholder="No Handphone" value="<?= set_value('no_handphone') ?>">
                                            <small class="text-danger"><?= form_error('no_handphone') ?></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 hidden" id="cek_kurir">
                                        <strong>Kurir:</strong>
                                        <!-- <div class="custom-control " > -->
                                            <!-- <input type="checkbox" name="checkbox" value="" class="custom-control-input" style="opacity: 1;">
                                            <label class="form-check-label" for="inlineCheckbox1">Checked</label> -->
                                        <!-- </div> -->
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                        <div class="form-group">
                                            <button type="button" id="cek_ongkir" class="col-md-12 btn btn-success">Cek Ongkir</button>
                                        </div>
                                    </div>

                                </div>
                                

                                <h4 class="card-title">Checkout</h4>
                                <?php foreach($purchases as $purchase):
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
                                            <td>Weight</td>
                                            <td class="pr-1 pl-1">:</td>
                                            <td><?= $purchase_model->getBookStock($purchase['id'])['weight'].' kg' ?></td>
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
                                        <tr class="hidden" id="trigger_shipping_price">
                                            <td>Shipping Book Price</td>
                                            <td class="pr-1 pl-1">:</td>
                                            <td id="total_shipping_price"></td>
                                            <input type="hidden" value="" name="shipping_price" id="shipping_price">
                                            <input type="hidden" value="" name="courier" id="courier">
                                            <input type="hidden" value="" name="courier_service" id="courier_service">
                                            <input type="hidden" value="" name="etd" id="etd">
                                            <input type="hidden" value="<?= $total_weight ?>" name="total_weight" id="total_weight">
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
                                            <td id="td_total_price"><?= 'Rp'.number_format($total_price,0,'.','.') ?></td>
                                            <input type="hidden" value="<?= $total_price ?>" name="total_price" id="total_price">
                                            <input type="hidden" value="" name="total_price_all" id="total_price_all">
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

   
