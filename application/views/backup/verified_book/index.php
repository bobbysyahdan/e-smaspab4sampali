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
                                                <th>Book Type</th>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Serial Number</th>
                                                <th>Is Verified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($verified_books) > 0):
                                                foreach($verified_books as $key => $book): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $model->getBook($book['id_book'])['title'] ?></td>
                                                <td><?= $book['book_type'] == 1 ? 'Digital' : 'Printed' ?></td>
                                                <td><?= $model->getUser($book['id_user'])['fullname'] ?></td>
                                                <td><?= $book['email'] != null ? $book['email'] : '-' ?></td>
                                                <td><?= $book['serial_number'] ?></td>
                                                <td><button type="button" class="btn <?= $book['is_verified'] == 1 ? 'btn-success' : 'btn-danger' ?>"><?= $book['is_verified'] == 1 ? '<i data-feather="check"></i> Yes' : '<i data-feather="x"></i> No' ?></button></td>
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

