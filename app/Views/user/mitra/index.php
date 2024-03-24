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
                                        <label class="fw-bold" for="address">Alamat Mitra: </label>
                                        <div id="list-address">
                                            <?php foreach ($addresses as $address) : ?>
                                                <li class="<?= $address->main_address == 1 ? 'fw-bold' : "" ?>"><?= $address->name ?><?= $address->main_address == 1 ? ' - Alamat Utama' : "" ?></li>
                                            <?php endforeach; ?>
                                        </div>
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
                                        <a href="<?= base_url("mitra/edit/" . $mitra->id) ?>" type="submit" class="btn btn-outline-primary me-1 mb-1">Edit</a>
                                        <a type="submit" class="btn btn-primary me-1 mb-1 delete-btn" data-mitra-id="<?= $mitra->id ?>">Cancel</a>
                                    </div>
                                <?php elseif ($mitra->verified == 1) : ?>
                                    <div class="col-12 d-flex justify-content-center">
                                        <a class="btn btn-success">Approved</a>
                                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" id="add-address-btn" data-bs-target="#exampleModalCenter">
                                            Add Address
                                        </button>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tambahkan Alamat
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" id="address" data-mitra-id="<?= $mitra->id ?>" class="form-control" name="address">
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <a type="button" class="btn btn-primary ms-1 submit-add-address">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Submit</span>
                    </a>
                </div>
            </div>
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
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            var deleteButton = $(this);
            mitra_id = deleteButton.data("mitra-id")
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "anda tidak dapat mengembalikan pengajuan yang sudah dibatalkan",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
                confirmButtonColor: "#f14836"
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url() ?>mitra/delete/' + mitra_id,
                        type: 'DELETE',
                        success: function(response) {
                            window.location.href = '<?= base_url() ?>mitra';
                        }
                    })
                }
            });
        });

        $(document).on('click', '#add-address-btn', function(e) {
            e.preventDefault();
            $('#exampleModalCenter').modal('show');
            $('.modal-backdrop').show();
        });

        $(document).on('click', '.submit-add-address', function(e) {
            e.preventDefault();
            var address = $('#address').val();
            var mitra_id = $('#address').data('mitra-id');

            $.ajax({
                url: '<?= base_url() ?>mitra/add-address/' + mitra_id,
                type: 'POST',
                data: {
                    'address': address
                },
                success: function(response) {
                    // response = JSON.parse(response)
                    if (response.status == 'error') {

                    } else {
                        $('#exampleModalCenter').modal('hide');
                        $('body').removeClass('modal-open');
                        $('body').removeAttr('style');
                        $('.modal-backdrop').hide();
                        $('#address').val('');
                        $('#list-address').append(`<li>${address}</li>`);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                }
            })

        });
    });
</script>
<?= $this->endSection(); ?>