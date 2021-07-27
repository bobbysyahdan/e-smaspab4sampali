
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
                                <form action="<?= base_url('subscribe/update/'.$subscribe['id']) ?>" method="POST">
                                <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>User:</strong>
                                                <select name="id_user" id="id_user" class="form-control">
                                                    <?php if(count($users) > 0): foreach($users as $user): ?>
                                                        <option value="<?= $user['id'] ?>" <?= $user['id'] == $subscribe['id_user'] ? 'selected' : ''?>><?= $user['username'].'('.$user['email'].')' ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_user') ?></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Subscribe Package:</strong>
                                                <select name="id_subscribe_package" id="id_subscribe_package" class="form-control">
                                                    <?php if(count($subscribe_packages) > 0): foreach($subscribe_packages as $subscribe_package): ?>
                                                        <option value="<?= $subscribe_package['id'] ?>" <?= $subscribe_package['id'] == $subscribe['id_subscribe_package'] ? 'selected' : ''?>><?= $subscribe_package['package'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                </select>
                                                <small class="text-danger"><?= form_error('id_subscribe_package') ?></small>
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

   
