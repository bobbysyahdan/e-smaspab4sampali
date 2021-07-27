
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

                            <?php if($this->session->flashdata('failed')): ?>
                                   <div class="col-md-12 p-0 mt-2">
                                        <div class="alert alert-danger" role="alert">
                                            <h4 class="alert-heading">Failed
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h4>
                                            <div class="alert-body">
                                                <?= $this->session->flashdata('failed') ?>
                                            </div>
                                        </div>
                                   </div>
                                <?php endif; ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="card-datatable ml-1 mt-2">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>ISBN</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $book_identity['isbn'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Title</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $book_identity['title'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Author</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $book_identity['author'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Publisher</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $book_identity['publisher'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Publication Year</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $book_identity['publication_year'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <?php if($is_verified == TRUE):?>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <?= $book_identity['content'] ?>
                                        <!-- <iframe src="<s?= $filename ?>" width="100%" style="height:500px"></iframe> -->
                                    </div>
                                </div>
                                <?php else: ?>
                                <form action="<?= base_url('book/read/'.$book_identity['id']) ?>" method="POST">
                                    <div class="row mb-1 mt-3">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Plesea Insert Access Code for Read The Book:</strong>
                                                <input type="text" name="serial_number" class="form-control" placeholder="Access Code" value="<?= set_value('serial_number') ?>">
                                                <small class="text-danger"><?= form_error('serial_number') ?></small>
                                            </div>
                                            <button type="submit" class="btn btn-primary col-md-12">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

   
