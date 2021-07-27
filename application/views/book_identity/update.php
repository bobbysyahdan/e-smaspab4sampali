
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
                                <form action="<?= base_url('bookIdentity/update/'.$book_identity['id']) ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>ISBN:</strong>
                                                <input type="text" name="isbn" class="form-control" placeholder="ISBN" value="<?= $book_identity['isbn'] ?>">
                                                <small class="text-danger"><?= form_error('isbn') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Title:</strong>
                                                <input type="text" name="title" class="form-control" placeholder="Title" value="<?= $book_identity['title'] ?>">
                                                <small class="text-danger"><?= form_error('title') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Author:</strong>
                                                <input type="text" name="author" class="form-control" placeholder="Author" value="<?= $book_identity['author'] ?>">
                                                <small class="text-danger"><?= form_error('author') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Publisher:</strong>
                                                <input type="text" name="publisher" class="form-control" placeholder="Publisher" value="<?= $book_identity['publisher'] ?>">
                                                <small class="text-danger"><?= form_error('publisher') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Publication Year:</strong>
                                                <input type="text" name="publication_year" class="form-control" placeholder="Example: 2020" value="<?= $book_identity['publication_year'] ?>">
                                                <small class="text-danger"><?= form_error('publication_year') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Pages:</strong>
                                                <input type="text" name="pages" class="form-control" placeholder="Pages" value="<?= $book_identity['pages'] ?>">
                                                <small class="text-danger"><?= form_error('pages') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Category:</strong>
                                                <select name="id_category" id="id_category" class="form-control">
                                                    <?php if(count($categories) > 0): foreach($categories as $category): ?>
                                                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $book_identity['id_category'] ? 'selected' : ''?>><?= $category['category'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_category') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Package Edition:</strong>
                                                <select name="id_package_edition" id="id_package_edition" class="form-control">
                                                    <?php if(count($package_editions) > 0): foreach($package_editions as $package_edition): ?>
                                                        <option value="<?= $package_edition['id'] ?>" <?= $package_edition['id'] == $book_identity['id_package_edition'] ? 'selected' : ''?>><?= $package_edition['package_edition'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_package_edition') ?></small>
                                            </div>
                                        </div>                      
                                        

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Cover Image:</strong>
                                                <input type="hidden" name="old_cover_image" value="<?= $book_identity['cover_image']?>" >
                                                <input type="file" name="cover_image" class="form-control">
                                                <small class="text-danger"><?= form_error('cover_image') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>File:</strong>
                                                <input type="hidden" name="old_file" value="<?= $book_identity['file_uploaded']?>" >
                                                <input type="file" name="file_uploaded" class="form-control">
                                                <small class="text-danger"><?= form_error('file_uploaded') ?></small>
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Content:</strong>
                                                <textarea id="ckeditor" name="content" rows="10" cols="80"><s?= $book_identity['content'] ?></textarea>
                                                <small class="text-danger"><s?= form_error('content') ?></small>
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Description:</strong>
                                                <textarea class="form-control" id="description" name="description" rows="3"><?= $book_identity['description'] ?></textarea>
                                                <small class="text-danger"><?= form_error('description') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary col-md-12">Update</button>
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

   
