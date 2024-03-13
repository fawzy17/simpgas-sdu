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
                        <th>Alamat Perusahaan</th>
                        <th>Nama PIC</th>
                        <th>Kontak PIC</th>
                        <th>Meminjam Tabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($mitras as $mitra) :
                        if ($mitra->verified == 1) :
                            $text =  $mitra->address;
                    ?>
                            <tr id="mitra<?= $mitra->id ?>">
                                <td class="text-left"><?= $no++ ?></td>
                                <td class="text-left"><?= $mitra->name ?></td>
                                <td class="text-left"><?= $mitra->email ?></td>
                                <td class="text-left address-detail" data-address-mitra="<?= $mitra->address ?>"><?= strlen($text) > 35 ? substr($text, 0, 35) . '...' : $text; ?></td>
                                <td class="text-left"><?= $mitra->pic_name ?></td>
                                <td class="text-left"><?= $mitra->pic_contact ?></td>
                                <td class="text-left"><?= $mitra->total_tubes_borrowed ?></td>
                                <td class="text-left">
                                    <a href="<?= base_url('/admin/mitra/edit/' . $mitra->id); ?>" class="btn btn-success edit-btn" type="submit" data-id-mitra="<?= $mitra->id ?>">Edit</a>
                                    <button class="btn btn-danger delete-mitra-btn" type="submit" data-id-mitra="<?= $mitra->id ?>" data-name-mitra="<?= $mitra->name ?>" data-tubes-borrowed="<?= $mitra->total_tubes_borrowed ?>">Delete</button>
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
            "targets": "_all"
        }],
        "fixedColumns": {
            start: 2,
            end: 0
        },
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

    $(document).on('click', '.delete-mitra-btn', function(e) {
        var id_mitra = $(this).data('id-mitra');
        var name_mitra = $(this).data('name-mitra');
        var tubes_borrowed = $(this).data('tubes-borrowed');
        console.log(tubes_borrowed > 1);
        if (tubes_borrowed > 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Gagal',
                text: 'Anda tidak dapat menghapus data mitra yang masih meminjam tabung'
            });

            return
        }
        Swal.fire({
            icon: 'warning',
            title: 'Yakin?',
            text: 'Menghapus ' + name_mitra + ' dari daftar mitra',
            showCancelButton: true, // Menampilkan tombol pembatalan
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>admin/mitra/delete-from-list',
                    type: 'POST',
                    data: {
                        "id_mitra": id_mitra
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        console.log('berhasil menghapus ' + name_mitra);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: name_mitra + ' telah dihapus dari daftar mitra, data dipindahkan ke tabel request',
                        });
                        $('#mitra' + response.id).remove();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection(); ?>