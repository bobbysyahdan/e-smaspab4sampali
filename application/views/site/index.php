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
                        <div class="card-body">
                            <h1><?= $title ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Books</h4>
                            <h1><?= count($books) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Users</h4>
                            <h1><?= count($users) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Vouchers</h4>
                            <h1><?= count($vouchers) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Transactions on Settlement</h4>
                            <h1><?= count($transactions) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Books on Sold Out</h4>
                            <h1><?= count($verified_books) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Digital Books on Sold Out</h4>
                            <h1><?= count($digital_books) ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Printed Books on Sold Out</h4>
                            <h1><?= count($printed_books) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body mt-2">
                            <h4 style="text-align: center">Dokumentasi Tutorial Penggunaan Dashboard BIDLIT</h4>
                            <p style="text-align: center">Untuk mempermudah memahami penggunaan Dashboard BIDLIT, Anda dapat membaca dokumentasi tutorial penggunaan Dashboard BIDLIT di link dibawah ini : </p>
                            <div class="col-md-12 mt-5 mb-5" style="text-align: center;">
                                <i data-feather="file" style="width:150px; height: 150px; text-align: center;"></i>
                            </div>
                            <div class="col-md-12 mb-2" style="text-align: center;">
                                <a href="/upload/documentation/dokumentasi-dashboard-bidlit.pdf" target="_blank" class="col-md-6 btn btn-primary">Lihat Dokumentasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

