<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Mitra', 'description' => 'Kelola data mitra yang sudah terdaftar disini']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content section -->
<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Tabel Mitra Terdaftar
            </h5>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tabung Dipinjam</th>
                        <th>Alamat mitra</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($mitras as $mitra) :
                        if ($mitra->verified == 1) :
                            $text =  $mitra->address;
                    ?>
                            <tr>
                                <td class="text-left"><?= $no++ ?></td>
                                <td class="text-left"><?= $mitra->name ?></td>
                                <td class="text-left"><?= $mitra->email ?></td>
                                <td class="text-left"><?= $mitra->tubes_borrowed ?></td>
                                <td class="text-left address-detail" data-address-mitra="<?= $mitra->address ?>"><?= strlen($text) > 35 ? substr($text, 0, 35) . '...' : $text; ?></td>
                                <td class="text-left">
                                    <button class="btn btn-success edit-btn" type="submit" data-id-mitra="<?= $mitra->id ?>">Edit</button>
                                    <button class="btn btn-danger delete-btn" type="submit" data-id-mitra="<?= $mitra->id ?>">Delete</button>
                                </td>
                            </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
<!-- Basic Tables end -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    let jquery_datatable = $("#table1").DataTable({
        "responsive": true,
        "columnDefs": [{
                "type": "string",
                "targets": [0, 3, 5]
            } // Assuming column indexes 3 and 4 contain numerical values
        ],
        "scrollX": true,
        "autoWidth": true,
        "scrollCollapse": true,

    })

    const setTableColor = () => {
        document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
            dt.classList.add('pagination-primary')
        })
    }
    setTableColor()
    jquery_datatable.on('draw', setTableColor)
</script>
<script>
    $(document).on('click', '.address-detail', function(e) {
        var truncated = $(this).data('truncated');
        var address_mitra = $(this).data('address-mitra');
        if (!truncated) {
            $(this).text(address_mitra);
            $(this).data('truncated', true);
        } else {
            var deskripsi = address_mitra;
            var truncatedDeskripsi = deskripsi.length > 35 ? deskripsi.substring(0, 35) + '...' : deskripsi;
            $(this).text(truncatedDeskripsi);
            $(this).data('truncated', false);
        }
    });
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