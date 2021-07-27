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
                                <h4 class="card-title">User</h4>
                                <div style="text-align: right;">
                                    <a href="/user/create" class="btn btn-primary"><b>
                                    <i data-feather="plus" style="margin-right: 5px;"></i></b>Create New</a>
                                </div>
                                 <?php if($this->session->flashdata('success')): ?>
                                   <div class="col-md-12 p-0 mt-2">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Success
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </h4>
                                            <div class="alert-body">
                                                <?= $this->session->flashdata('success') ?>
                                            </div>
                                        </div>
                                   </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="table_id"> 
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <!-- <th>Password</th> -->
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Identity</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(count($users) > 0):
                                                foreach($users as $key => $user): 
                                            ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $user['username'] ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <!-- <td><s?= $user['password'] ?></td> -->
                                                <td><?= $user['role'] == 1 ? 'Admin' : 'User'?></td>
                                                <td><?= $user['is_active'] == 1 ? 'Active' : 'Non-Active'?></td>
                                                <td>
                                                    <a href="<?= base_url('/userIdentity/index/'.$user['id']) ?>" class="btn btn-primary">User Identity</a>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/user/show/'.$user['id']) ?>" class="btn btn-primary mb-1">Show</a>
                                                    <a href="<?= base_url('/user/resetPassword/'.$user['id']) ?>" class="btn btn-warning mb-1">Reset Password</a>
                                                    <a href="<?= base_url('/user/update/'.$user['id']) ?>" class="btn btn-success mb-1">Edit</a>
                                                    <a href="<?= base_url('/user/delete/'.$user['id']) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger mb-1">Delete</a>
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

