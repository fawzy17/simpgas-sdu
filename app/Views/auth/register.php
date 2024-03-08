<?= $this->extend('layouts/main_auth'); ?>
<?= $this->section('heads'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div id="auth">

    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <h1 class="auth-title">Sign Up</h1>
                <p class="auth-subtitle mb-5">Input your data to register to our website.</p>
                <?= form_open(base_url('auth/store')) ?>
                <?php if (isset($validation)) : ?>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email" id="email" class="form-control form-control-xl <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" placeholder="Email" value="<?= $email == '' ? set_value('email', session()->get('email')) : $email; ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('email'); ?>
                        </div>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" name="username" id="username" class="form-control form-control-xl <?= $validation->hasError('username') ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?= set_value('username', session()->get('username')); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username'); ?>
                        </div>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" id="password" class="form-control form-control-xl <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" placeholder="Password" value="<?= set_value('password', session()->get('password')); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password'); ?>
                        </div>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-xl <?= $validation->hasError('confirm_password') ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" value="<?= set_value('confirm_password', session()->get('confirm_password')); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('confirm_password'); ?>
                        </div>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                <?php endif; ?>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
                <?= form_close() ?>
                <a href="<?= $link; ?>" class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Google</a>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>Already have an account? <a href="<?= base_url('/auth/login'); ?>" class="font-bold">Log
                            in</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url('assets/js/sweetalert2.min.js'); ?>"></script>
<script>
    $(() => {
        <?php if (session()->has('error_message')) : ?>
            Swal.fire({
                icon: 'error',
                text: '<?= session()->getFlashdata('error_message') ?>',
                showConfirmButton: false,
                timer: 2000
            })
        <?php endif; ?>
    })
</script>
<?= $this->endSection(); ?>