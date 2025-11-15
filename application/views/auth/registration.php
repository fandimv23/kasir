<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>

                            <?php if ($this->session->flashdata('message')): ?>
                                <?php echo $this->session->flashdata('message'); ?>
                            <?php endif; ?>

                            <?php echo form_open('auth/registration', ['class' => 'user']); ?>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nama" name="nama"
                                    placeholder="Full Name" value="<?php echo set_value('nama'); ?>">
                                <?php echo form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="username" name="username"
                                    placeholder="Username" value="<?php echo set_value('username'); ?>">
                                <?php echo form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                        id="password1" name="password1" placeholder="Password">
                                    <?php echo form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                        id="password2" name="password2" placeholder="Repeat Password">
                                    <?php echo form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>

                            <?php echo form_close(); ?>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>