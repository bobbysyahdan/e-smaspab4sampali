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
                                <h4 class="card-title">Book Identity</h4>
                                <div style="text-align: right;">
                                    <a href="/bookIdentity/create" class="btn btn-primary"><b>
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
                                                <th>ISBN</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Publisher</th>
                                                <!-- <th>Publication Year</th> -->
                                                <th>Pages</th>
                                                <th>Category</th>
                                                <th>Amount Subscribe</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($book_identities) > 0):
                                                foreach($book_identities as $key => $book_identity): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $book_identity['isbn'] ?></td>
                                                <td><?= $book_identity['title'] ?></td>
                                                <td><?= $book_identity['author'] ?></td>
                                                <td><?= $book_identity['publisher'] ?></td>
                                                <!-- <td><s?= $book_identity['publication_year'] ?></td> -->
                                                <td><?= $book_identity['pages'] ?></td>
                                                <td><?= $model->getCategory($book_identity['id_category']) ?></td>
                                                <td><?= $book_identity['amount_subscribe'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('/bookIdentity/show/'.$book_identity['id']) ?>"><i data-feather="eye"></i></a>
                                                    <a href="<?= base_url('/bookIdentity/update/'.$book_identity['id']) ?>"><i data-feather="edit"></i></a>
                                                    <a href="<?= base_url('/bookIdentity/delete/'.$book_identity['id']) ?>" onclick="return confirm('Are you sure ?')"><i data-feather="trash-2"></i></a>
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

