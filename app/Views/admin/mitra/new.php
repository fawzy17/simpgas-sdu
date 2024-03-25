<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Mitra', 'description' => 'Isi form dibawah untuk menambahkan data mitra']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content section -->
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <?= form_open(base_url('admin/mitra/store')) ?>
                        <?php if (isset($validation)) : ?>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" id="name" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" placeholder="PT. xxxx" name="name" value="<?= set_value('name', old('name')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="address">Alamat Mitra</label>
                                        <input type="text" id="address" class="form-control <?= $validation->hasError('address') ? 'is-invalid' : ''; ?>" placeholder="Jl. xxxxxx" name="address" value="<?= set_value('address', old('address')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('address'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" placeholder="user@gmail.com" name="email" value="<?= set_value('email', old('email')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pic_name">Nama PIC</label>
                                        <input type="text" id="pic_name" class="form-control <?= $validation->hasError('pic_name') ? 'is-invalid' : ''; ?>" name="pic_name" value="<?= set_value('pic_name', old('pic_name')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('pic_name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pic_contact">Kontak PIC</label>
                                        <input type="text" id="pic_contact" class="form-control <?= $validation->hasError('pic_contact') ? 'is-invalid' : ''; ?>" name="pic_contact" value="<?= set_value('pic_contact', old('pic_contact')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('pic_contact'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?= form_close()  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    let jquery_datatable = $("#table1").DataTable({
        responsive: true,
        scrollX: true,
        fixedColumns: {
            leftColumns: 3
        }
    })

    const setTableColor = () => {
        document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
            dt.classList.add('pagination-primary')
        })
    }
    setTableColor()
    jquery_datatable.on('draw', setTableColor)
</script>

<?= $this->endSection(); ?>