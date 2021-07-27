
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
                                 <?php elseif($this->session->flashdata('failed')): ?>
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
                            </div>
                            <div class="card-body mt-2">
                                <!-- <form action="<s?= base_url('bookIdentity/create') ?>" method="POST" enctype="multipart/form-data"> -->
                                <?php echo form_open_multipart('bookIdentity/create');?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>ISBN:</strong>
                                                <input type="text" name="isbn" class="form-control" placeholder="ISBN" value="<?= set_value('isbn') ?>">
                                                <small class="text-danger"><?= form_error('isbn') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Title:</strong>
                                                <input type="text" name="title" class="form-control" placeholder="Title" value="<?= set_value('title') ?>">
                                                <small class="text-danger"><?= form_error('title') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Author:</strong>
                                                <input type="text" name="author" class="form-control" placeholder="Author" value="<?= set_value('author') ?>">
                                                <small class="text-danger"><?= form_error('author') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Publisher:</strong>
                                                <input type="text" name="publisher" class="form-control" placeholder="Publisher" value="<?= set_value('publisher') ?>">
                                                <small class="text-danger"><?= form_error('publisher') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Publication Year:</strong>
                                                <input type="text" name="publication_year" class="form-control" placeholder="Example: 2020" value="<?= set_value('publication_year') ?>">
                                                <small class="text-danger"><?= form_error('publication_year') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Pages:</strong>
                                                <input type="text" name="pages" class="form-control" placeholder="Pages" value="<?= set_value('pages') ?>">
                                                <small class="text-danger"><?= form_error('pages') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Category:</strong>
                                                <select name="id_category" id="id_category" class="form-control">
                                                    <option value="" disabled selected>- Choose Category-</option>
                                                    <?php if(count($categories) > 0): foreach($categories as $value): ?>
                                                        <option value="<?= $value['id'] ?>" <?= set_select('id_category', $value['id'], FALSE); ?>><?= $value['category'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_category') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Package Edition:</strong>
                                                <select name="id_package_edition" id="id_package_edition" class="form-control">
                                                    <option value="" disabled selected>- Choose Package Edition-</option>
                                                    <?php if(count($package_editions) > 0): foreach($package_editions as $value): ?>
                                                        <option value="<?= $value['id'] ?>"  <?= set_select('id_package_edition', $value['id'], FALSE); ?>><?= $value['package_edition'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_package_edition') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Cover Image (jpg/png/jpeg):</strong>
                                                <input type="file" name="cover_image" class="form-control" value="<?= set_value('cover_image') ?>">
                                                <small class="text-danger"><?= form_error('cover_image') ?></small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Upload Book File (pdf):</strong>
                                                <input type="file" name="file_uploaded" class="form-control">
                                                <small class="text-danger"><?= form_error('file_uploaded') ?></small>
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Content:</strong>
                                                <textarea id="ckeditor" name="content" rows="10" cols="80"><s?= set_value('content') ?></textarea>
                                                <small class="text-danger"><s?= form_error('content') ?></small>
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Description:</strong>
                                                <textarea class="form-control" id="description" name="description" rows="3"><?= set_value('description') ?></textarea>
                                                <small class="text-danger"><?= form_error('description') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Save</button>
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
