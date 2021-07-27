
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
                                <form action="<?= base_url('user/create') ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Username:</strong>
                                                <input type="text" name="username" class="form-control" placeholder="Username" value="<?= set_value('username') ?>">
                                                <small class="text-danger"><?= form_error('username') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input type="text" name="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>">
                                                <small class="text-danger"><?= form_error('email') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Password:</strong>
                                                <input type="password" name="password" class="form-control" placeholder="Password" value="<?= set_value('password') ?>">
                                                <small class="text-danger"><?= form_error('password') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Confirm Password:</strong>
                                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?= set_value('confirm_password') ?>">
                                                <small class="text-danger"><?= form_error('confirm_password') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Role:</strong>
                                                <select name="role" id="role" class="form-control">
                                                    <option value="" disabled selected>- Choose Role-</option>
                                                    <?php if(count($roles) > 0): foreach($roles as $role): ?>
                                                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('role') ?></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Status:</strong>
                                                <div class="demo-inline-spacing">
                                                    <?php if(count($is_active) > 0): foreach($is_active as $key => $data): ?>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio<?=$key?>" name="is_active" class="custom-control-input" value="<?= $data['id'] ?>">
                                                        <label class="custom-control-label" for="customRadio<?=$key?>"><?= $data['name'] ?></label>
                                                    </div>
                                                    <?php endforeach; endif; ?>
                                                </div>
                                                <small class="text-danger"><?= form_error('role') ?></small>
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
