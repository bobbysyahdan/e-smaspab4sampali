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
                                <h4 class="card-title">Book Product</h4>
                            </div>
                            <div class="card-body">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="table_id"> 
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Publisher</th>
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
                                                <td><?= $book_identity['title'] ?></td>
                                                <td><?= $book_identity['author'] ?></td>
                                                <td><?= $book_identity['publisher'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('/book/read/'.$book_identity['id']) ?>" class="btn btn-primary mb-1 col-md-12">Read</a>
                                                    <!-- <a href="<s?= base_url('/book/subscribe/'.$book_identity['id']) ?>" class="btn btn-primary btn-block">Subscribe</a> -->
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

