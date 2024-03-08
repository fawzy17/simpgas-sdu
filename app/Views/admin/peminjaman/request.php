<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Pinjaman', 'description' => 'Kelola data permintaan menjadi mitra dari perusahaan lain disini']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content section -->

<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Tabel Permintaan Menjadi Mitra
            </h5>
            <a href="<?= base_url('/admin/mitra/new'); ?>" class="btn btn-sm icon icon-left btn-danger">
                <i class="bi bi-person-plus"></i>
                Tambah
            </a>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Tabung yang dipinjam</th>
                        <th>Alamat mitra</th>
                        <th>Persetujuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($mitras as $mitra) :
                        if ($mitra->verified != 1) :
                            $text =  $mitra->address;
                    ?>
                            <tr id="mitra<?= $mitra->id ?>">
                                <td class="text-left"><?= $no++ ?></td>
                                <td class="text-left"><?= $mitra->name ?></td>
                                <td class="text-left"><?= $mitra->tubes_borrowed ?></td>
                                <td class="text-left address-detail" data-address-mitra="<?= $mitra->address ?>"><?= strlen($text) > 35 ? substr($text, 0, 35) . '...' : $text; ?></td>
                                <td id="verified<?= $mitra->id ?>" class="text-left">
                                    <?php if ($mitra->verified == null) : ?>
                                        <button class="btn btn-success approve-btn" type="submit" data-id-mitra="<?= $mitra->id ?>">Approve</button>
                                        <button class="btn btn-danger reject-btn" type="submit" data-id-mitra="<?= $mitra->id ?>" data-name-mitra="<?= $mitra->name ?>">Reject</button>
                                    <?php elseif ($mitra->verified == 0) : ?>
                                        <a type="button" class="btn btn-outline-info revert-btn" data-id-mitra="<?= $mitra->id ?>" data-name-mitra="<?= $mitra->name ?>">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Revert
                                        </a>
                                    <?php endif; ?>
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
                "targets": [0, 2]
            } // Assuming column indexes 3 and 4 contain numerical values
        ],
        "scrollX": true,
        "autoWidth": true,
        "scrollCollapse": true,
        "fixedColumns": {
            "leftColumns": 3
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
<script>
    $(document).ready(function() {
        $(document).on('click', '.approve-btn', function(e) {
            var id_mitra = $(this).data('id-mitra');
            $.ajax({
                url: '<?= base_url() ?>admin/mitra/approve',
                type: 'POST',
                data: {
                    "id_mitra": id_mitra
                },
                success: function(response) {
                    response = JSON.parse(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Permintaan menjadi mitra disetujui',
                        showConfirmButton: false,
                        timer: 2000
                    })

                    $('#mitra' + response.id).remove();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });

        });

        $(document).on('click', '.reject-btn', function(e) {
            var id_mitra = $(this).data('id-mitra');
            var name_mitra = $(this).data('name-mitra');
            $.ajax({
                url: '<?= base_url() ?>admin/mitra/reject',
                type: 'POST',
                data: {
                    "id_mitra": id_mitra
                },
                success: function(response) {
                    response = JSON.parse(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Permintaan menjadi mitra ditolak',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $('#verified' + response.id).empty();
                    $('#verified' + response.id).html(
                        `
                            <a type="button" class="btn btn-outline-info revert-btn" data-id-mitra="${response.id}" data-name-mitra="${name_mitra}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Revert
                            </a>
                        `
                    );
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
        });

        $(document).on('click', '.revert-btn', function(e) {
            var id_mitra = $(this).data('id-mitra');
            var name_mitra = $(this).data('name-mitra');
            Swal.fire({
                icon: 'warning',
                title: 'Yakin?',
                text: 'Merubah status persetujuan ' + name_mitra,
                showCancelButton: true, // Menampilkan tombol pembatalan
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Revert!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url() ?>admin/mitra/revert',
                        type: 'POST',
                        data: {
                            "id_mitra": id_mitra
                        },
                        success: function(response) {
                            response = JSON.parse(response);
                            console.log('berhasil revert ' + response.id);
                            $('#verified' + response.id).empty();
                            $('#verified' + response.id).html(
                                `
                                    <button class="btn btn-success approve-btn" type="submit" data-id-mitra="${response.id}">Approve</button>
                                    <button class="btn btn-danger reject-btn" type="submit" data-id-mitra="${response.id}" data-name-mitra="${name_mitra}">Reject</button>
                                `
                            );
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error(textStatus, errorThrown);
                        }
                    });
                }
            });
        });

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
    });
</script>


<?= $this->endSection(); ?>