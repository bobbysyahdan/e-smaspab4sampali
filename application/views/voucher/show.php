
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
                                                <tr>
                                                    <td>Voucher Code</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $voucher['voucher_code'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Percentage Discount</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $voucher['percentage_discount'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Start Date</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $voucher['start_date'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>End Date</td>
                                                    <td class="pr-1 pl-1">:</td>
                                                    <td><?= $voucher['end_date'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
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

   
