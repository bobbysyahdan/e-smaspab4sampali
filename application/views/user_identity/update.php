
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
                                <form action="<?= base_url('userIdentity/update/'.$id_user) ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Fullname:</strong>
                                                <input type="text" name="fullname" class="form-control" placeholder="Fullname" value="<?= $user_identity['fullname'] ?>">
                                                <small class="text-danger"><?= form_error('fullname') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Date of Birth:</strong>
                                                <input type="date" name="date_of_birth" class="form-control" placeholder="Date of Birth" value="<?= $user_identity['date_of_birth'] ?>">
                                                <small class="text-danger"><?= form_error('date_of_birth') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>No Handphone:</strong>
                                                <input type="text" name="no_handphone" class="form-control" placeholder="No Handphone" value="<?= $user_identity['no_handphone'] ?>">
                                                <small class="text-danger"><?= form_error('no_handphone') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Gender:</strong>
                                                <div class="demo-inline-spacing">
                                                    <?php if(count($gender) > 0): foreach($gender as $key => $data): ?>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio<?=$key?>" name="gender" class="custom-control-input" value="<?= $data['id'] ?>" <?= $user_identity['gender'] == $data['id'] ? 'checked = ""' : 'unchecked = ""'?>>
                                                        <label class="custom-control-label" for="customRadio<?=$key?>"><?= $data['name'] ?></label>
                                                    </div>
                                                    <?php endforeach; endif; ?>
                                                </div>
                                                <small class="text-danger"><?= form_error('gender') ?></small>
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
