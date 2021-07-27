<div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?= date('Y'); ?><a class="ml-25" href="<?= base_url('/') ?>" target="_blank">BidLit PPKS</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span></p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/vendors.min.js') ?>"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="<s?= base_url('/assets_template/app-assets/vendors/js/charts/apexcharts.min.js') ?>"></script> -->
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/extensions/toastr.min.js') ?>"></script>
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') ?>"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/forms/select/select2.full.min.js') ?>"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?= base_url('/assets_template/app-assets/js/core/app-menu.js') ?>"></script>
    <script src="<?= base_url('/assets_template/app-assets/js/core/app.js') ?>"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?= base_url('/assets_template/app-assets/js/scripts/forms/form-select2.js') ?>"></script>
    <!-- END: Page JS-->

    <!-- Datepicker -->
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/pickers/pickadate/picker.js') ?>"></script>
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/pickers/pickadate/picker.date.js') ?>"></script>
    <script src="<?= base_url('/assets_template/app-assets/vendors/js/pickers/pickadate/picker.time.js') ?>"></script>

    <!-- Begin CK Editor -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.15.1/full/ckeditor.js"></script>
    <!-- END: CK Editor -->

    <!-- BEGIN: Datatable  JS-->
    <!-- <script src="<s?= base_url('/assets_template/app-assets/js/scripts/tables/table-datatables-advanced.js') ?>"></script> -->
    <script src="<?= base_url('/assets/js/datatable_script.js') ?>"></script>
    <!-- END: Datatable JS-->
    

    <script src="<?= base_url('/assets/js/cart_book.js') ?>"></script>
    <script src="<?= base_url('/assets/js/book_type.js') ?>"></script>
    <script src="<?= base_url('/assets/js/select_area.js') ?>"></script>

    <!-- BEGIN: Page JS-->
    <!-- <script src="<s?= base_url('/assets_template/app-assets/js/scripts/pages/dashboard-ecommerce.js') ?>"></script> -->
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
    </script>

</body>
<!-- END: Body-->

</html>