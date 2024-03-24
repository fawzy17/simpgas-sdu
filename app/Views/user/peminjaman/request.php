<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/choices.css'); ?>">
<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Pinjaman', 'description' => 'Isi form dibawah untuk menambahkan data mitra']); ?>
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
                        <?php if ($mitra != null) : ?>
                            <?= form_open(base_url('peminjaman/request')) ?>
                            <?php if ($mitra[0]->verified == 1) : ?>
                                <?php if (isset($validation)) : ?>
                                    <div class="row">
                                        <input type="hidden" name="mitra_id" value="<?= $mitra[0]->id ?>">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="name">Mitra</label>
                                                <input type="hidden" name="name" value="<?= $mitra[0]->name ?>">
                                                <input type="text" id="name" class="form-control" placeholder="Dikirim ke alamat ini" name="name" value="<?= $mitra[0]->name ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="address">Alamat</label>
                                                <select id="address" name="address" class="choices form-select">
                                                    <?php foreach ($addresses as $address) : ?>
                                                        <option value="<?= $address->id ?>" <?= old('address') == $address->id ? "selected" : "" ?>>
                                                            <?= $address->name ?> <?= $address->main_address == 1 ? " - Alamat utama" : "" ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php foreach ($tabungs as $tabung) : ?>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="<?= $tabung->name . $tabung->id ?>">
                                                        <?= $tabung->name ?> (<?= $tabung->category_name ?>
                                                        <?php if ($tabung->category_massa == 'kubik') : ?>
                                                            m<sup>3</sup>
                                                        <?php elseif ($tabung->category_massa == 'kilogram') : ?>
                                                            Kg
                                                            <?php endif; ?>) - Stock: <?= $tabung->stock_ready ?>
                                                    </label>
                                                    <input type="number" id="<?= $tabung->name . $tabung->id ?>" class="form-control <?= $validation->hasError($tabung->name . $tabung->id) ? 'is-invalid' : ''; ?>" placeholder="10xxxx" name="<?= $tabung->name . $tabung->id ?>" value="<?= set_value($tabung->name . $tabung->id, old($tabung->name . $tabung->id)) ?? '0'; ?>">
                                                    <div class="invalid-feedback">
                                                        <?= $validation->getError($tabung->name . $tabung->id); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?= form_close()  ?>
                            <?php else : ?>
                                <div class="text-center">
                                    <h1>Pengajuan Mitra anda belum diterima, silahkan menunggu admin untuk menerima pendaftaran anda</h1>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="text-center">
                                    <h1>Anda belum mendaftar sebagai mitra, daftar untuk mengajukan peminjaman</h1>
                                    <a href="<?= base_url('mitra') ?>" type="submit" class="btn btn-primary me-1 mb-1">Request Mitra</a>
                                </div>
                            <?php endif; ?>
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
<script src="<?= base_url('assets/js/choices.js'); ?>"></script>
<script src="<?= base_url('assets/js/form-element-select.js'); ?>"></script>
<?= $this->endSection(); ?>