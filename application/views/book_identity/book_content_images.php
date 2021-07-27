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
                            </div>
                            <div class="card-body">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="table_id"> 
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Filename</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($book_content_images) > 0):
                                                foreach($book_content_images as $key => $value): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $value['file_image'] ?></td>
                                                <td><a href="<?= base_url('/upload/content_book/'.$value['file_image']) ?>" target="_blank">File Image</a></td>
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

