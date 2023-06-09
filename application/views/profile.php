<section class="section">
    <div class="section-body">
        <!-- main -->
        <div class="row">
            <div class="col-md-4">
                <div class="card card-danger">
                    <div class="card-header">
                        <h4>Photo Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="user-item">
                            <img alt="image" src="<?= $this->dt_user->image; ?>" class="img-fluid" width="200">
                            <div class="user-details">
                                <div class="user-name"><?= $this->dt_user->name; ?></div>
                                <div class="text-job text-muted"><?= $this->dt_user->username; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-danger">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('profile/edit'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $this->dt_user->image; ?>" name="previmage">
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label>Foto</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" value="<?= $this->dt_user->username; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="<?= $this->dt_user->name; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Retype Password</label>
                                        <input type="password" class="form-control" name="retypepwd" value="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end main -->
</section>