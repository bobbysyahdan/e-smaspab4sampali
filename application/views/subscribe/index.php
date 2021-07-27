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
                                    <a href="/subscribe/create" class="btn btn-primary"><b>
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
                                                <th>Subscriber</th>
                                                <th>Subscribe Package</th>
                                                <th>Start Date</th>
                                                <th>Status</th>
                                                <th>Transaction</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($subscribes) > 0):
                                                foreach($subscribes as $key => $subscribe): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $model->getUser($subscribe['id_user'])['username'] ?></td>
                                                <td><?= $model->getSubscribePackage($subscribe['id_subscribe_package'])['package'] ?></td>
                                                <td><?= $subscribe['start_date'] == '0000-00-00' ? 'Not-Active' : $subscribe['start_date'] ?></td>
                                                <td><?= $subscribe['id_subscribe_status'] == 1 ? 'Active' : 'Non-Active' ?></td>
                                                <td>
                                                    <?php if($model->getTransactionLevelStatus($subscribe['id_transaction'])['level'] == 1): ?>
                                                        <a href="<?= base_url('/subscribe/checkout/'.$subscribe['id']) ?>" class="btn btn-primary mb-1 col-md-12">Checkout</a>
                                                    <?php endif; ?>
                                                    <?php if($model->getTransactionLevelStatus($subscribe['id_transaction'])['level'] == 2): ?>
                                                        Transaction On Pending
                                                    <?php endif; ?>
                                                    <?php if($model->getTransactionLevelStatus($subscribe['id_transaction'])['level'] == 3): ?>
                                                        Transaction On Cancel
                                                    <?php endif; ?>
                                                    <?php if($model->getTransactionLevelStatus($subscribe['id_transaction'])['level'] == 4): ?>
                                                        Transaction On Expire
                                                    <?php endif; ?>
                                                    <?php if($model->getTransactionLevelStatus($subscribe['id_transaction'])['level'] == 5): ?>
                                                        Transaction on Success
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/subscribe/show/'.$subscribe['id']) ?>"><i data-feather="eye"></i></a>
                                                    <a href="<?= base_url('/subscribe/update/'.$subscribe['id']) ?>"><i data-feather="edit"></i></a>
                                                    <a href="<?= base_url('/subscribe/delete/'.$subscribe['id']) ?>" onclick="return confirm('Are you sure ?')"><i data-feather="trash-2"></i></a>
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

