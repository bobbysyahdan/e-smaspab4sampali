
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
                                        <table>
                                            <tbody>
                                                <!-- <tr>
                                                    <td>Book Title</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><s?= $book['title'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>ISBN</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><s?= $book['isbn'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Author</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><s?= $book['author'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Publisher</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><s?= $book['publisher'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Publication Year</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><s?= $book['publication_year'] ?></td>
                                                </tr> -->
                                                <tr>
                                                    <td>Subscribe Package</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $package['package'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>User</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $user['username'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Amount of Days</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $package['days'].' days' ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Price</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= 'Rp'.number_format($package['price'], 0,'.','.') ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                    <a href="<?= base_url('subscribe/paymentProcess/'.$transaction['id'])?>" class="btn btn-primary col-md-12" target="_blank">Payment Process</a>
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


   
