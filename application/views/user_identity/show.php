
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

   
