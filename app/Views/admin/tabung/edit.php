<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Tabung', 'description' => 'Isi form dibawah untuk menambahkan data tabung']); ?>
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
                        <?= form_open(base_url('admin/tabung/update/' . $tabung->id)) ?>
                        <?php if (isset($validation)) : ?>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" id="name" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" placeholder="Nama" name="name" value="<?= set_value('name', $tabung != null ? $tabung->name : old('name')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="category">Kategori</label>
                                        <select id="category" name="category" class="choices form-select <?= $validation->hasError('category') ? 'is-invalid' : ''; ?>" value="<?= set_value('category', $tabung != null ? $tabung->category : old('category')); ?>">
                                            <option value="1">Gass</option>
                                            <option value="2">Liquid</option>
                                            <option value="3">Solid</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('category'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="stock">Stok</label>
                                        <input type="number" id="stock" class="form-control <?= $validation->hasError('stock') ? 'is-invalid' : ''; ?>" name="stock" placeholder="Jumlah Tabung" value="<?= set_value('stock', $tabung != null ? $tabung->stock : old('stock')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('stock'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="total_borrowed">Tabung Sedang Dipinjam</label>
                                        <input type="hidden" id="total_borrowed" name="total_borrowed" value="<?= set_value('total_borrowed', $tabung != null ? $tabung->total_borrowed : old('total_borrowed')); ?>">
                                        <input type="number" id="total_borrowed" class="form-control <?= $validation->hasError('total_borrowed') ? 'is-invalid' : ''; ?>" name="total_borrowed" placeholder="Jumlah Tabung" value="<?= set_value('total_borrowed', $tabung != null ? $tabung->total_borrowed : old('total_borrowed')); ?>" disabled>
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