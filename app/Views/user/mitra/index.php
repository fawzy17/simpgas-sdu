<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Mitra', 'description' => 'Kelola data Anda disini']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <?php foreach ($mitras as $mitra) : ?>
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name" class="fw-bold">Nama</label>
                                        <p><?= $mitra->name ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="fw-bold" for="address">Alamat Mitra</label>
                                        <p><?= $mitra->address ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="fw-bold" for="email">Email</label>
                                        <p><?= $mitra->email ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="fw-bold" for="pic_name">Nama PIC</label>
                                        <p><?= $mitra->pic_name ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="fw-bold" for="pic_contact">Kontak PIC</label>
                                        <p><?= $mitra->pic_contact ?></p>
                                    </div>
                                </div>
                                <?php if ($mitra->verified == null) : ?>
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-outline-primary me-1 mb-1">Edit</button>
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Cancel</button>
                                    </div>
                                <?php elseif ($mitra->verified == 1) : ?>
                                    <div class="col-12 d-flex justify-content-center">
                                        <a class="btn btn-success">Approved</a>
                                    </div>
                                <?php else : ?>
                                    <div class="col-12 d-flex justify-content-center">
                                        <a class="btn btn-danger">Delete</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(() => {
        <?php if (session()->has('success_message')) : ?>
            Swal.fire({
                icon: 'success',
                text: '<?= session()->getFlashdata('success_message') ?>',
                showConfirmButton: false,
                timer: 2000
            })
        <?php endif; ?>
    })
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