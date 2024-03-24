<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Mitra', 'description' => 'Isi formulir dibawah untuk mendaftar menjadi mitra']); ?>
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
                        <?= form_open(base_url('mitra/update')) ?>
                        <?php if (isset($validation)) : ?>
                            <div class="row">
                                <input type="hidden" id="mitra_id" name="mitra_id" value="<?= $mitra->id ?>">
                                <input type="hidden" id="address_id" name="address_id" value="<?= $address->id ?>">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" id="name" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" placeholder="PT. xxxx" name="name" value="<?= set_value('name', $mitra != null ? $mitra->name : old('name')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="address">Alamat Mitra</label>
                                        <input type="text" id="address" class="form-control <?= $validation->hasError('address') ? 'is-invalid' : ''; ?>" name="address" value="<?= set_value('address', $mitra != null ? $address->name : old('address')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('address'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="form-control" name="email" value="<?= session()->get('email') ?>" disabled>
                                        <input type="email" id="email" class="form-control" name="email" value="<?= session()->get('email') ?>" hidden>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pic_name">Nama PIC</label>
                                        <input type="text" id="pic_name" class="form-control <?= $validation->hasError('pic_name') ? 'is-invalid' : ''; ?>" name="pic_name" value="<?= set_value('pic_name', $mitra != null ? $mitra->pic_name : old('pic_name')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('pic_name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pic_contact">Kontak PIC</label>
                                        <input type="text" id="pic_contact" class="form-control <?= $validation->hasError('pic_contact') ? 'is-invalid' : ''; ?>" name="pic_contact" value="<?= set_value('pic_contact', $mitra != null ? $mitra->pic_contact : old('pic_contact')); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('pic_contact'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1 submit-btn">Submit</button>
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
    // $(document).ready(function() {
    //     $(document).on('click', '.submit-btn', function(e) {
    //         Swal.fire({
    //             icon: 'warning',
    //             title: 'Yakin?',
    //             text: 'Data yang anda masukkan sudah benar',
    //             showCancelButton: true, // Menampilkan tombol pembatalan
    //             confirmButtonColor: '#3085d6',
    //             cancelButtonColor: '#d33',
    //             confirmButtonText: 'Ya, Submit!',
    //             cancelButtonText: 'Batal'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 var name = $('#name').val();
    //                 var address = $('#address').val();
    //                 var email = $('#email').val();
    //                 var pic_name = $('#pic_name').val();
    //                 var pic_contact = $('#pic_contact').val();
    //                 $.ajax({
    //                     url: '<?= base_url() ?>admin/mitra/store',
    //                     type: 'POST',
    //                     data: {
    //                         "name": name,
    //                         "address": address,
    //                         "email": email,
    //                         "pic_name": pic_name,
    //                         "pic_contact": pic_contact
    //                     },
    //                     success: function(response) {
    //                     },
    //                     error: function(jqXHR, textStatus, errorThrown) {
    //                         console.error(textStatus, errorThrown);
    //                     }
    //                 });
    //             }
    //         });
    //     });
    // });
</script>
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