<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Tabung', 'description' => 'Kelola data tabung anda disini']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content section -->

<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Tabel Stok Tabung
            </h5>
            <a href="<?= base_url('/admin/tabung/new'); ?>" class="btn btn-sm icon icon-left btn-danger">
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
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Dipinjam</th>
                        <th>Ready</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($tabungs as $tabung) : ?>
                        <tr id="tabung<?= $tabung->id ?>">
                            <td class="text-left"><?= $no++ ?></td>
                            <td class="text-left"><?= $tabung->name ?></td>
                            <td class="text-left">
                                <?php if ($tabung->category_massa == 'kubik') : ?>
                                    <?= $tabung->category_name ?>m<sup>3</sup>
                                <?php elseif ($tabung->category_massa == 'kilogram') : ?>
                                    <?= $tabung->category_name ?>Kg
                                <?php else : ?>
                                    <?= $tabung->category_name ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-left"><?= $tabung->stock ?></td>
                            <td class="text-left"><?= $tabung->total_borrowed ?> </td>
                            <td class="text-left"><?= $tabung->stock - $tabung->total_borrowed ?> </td>
                            <td class="text-left">
                                <a href="<?= base_url('/admin/tabung/edit/' . $tabung->id); ?>" class="btn btn-success edit-btn" type="submit" data-id-tabung="<?= $tabung->id ?>">Edit</a>
                                <button class="btn btn-danger delete-tabung-btn" type="submit" data-id-tabung="<?= $tabung->id ?>" data-name-tabung="<?= $tabung->name ?>" data-tubes-borrowed="<?= $tabung->total_borrowed ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
        "ordering": false,
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
    $(document).on('click', '.delete-tabung-btn', function(e) {
        var id_tabung = $(this).data('id-tabung');
        var name_tabung = $(this).data('name-tabung');
        var tubes_borrowed = $(this).data('tubes-borrowed');
        console.log(tubes_borrowed > 1);
        if (tubes_borrowed > 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Gagal',
                text: 'Anda tidak dapat menghapus data tabung yang masih dipinjam oleh mitra'
            });

            return
        }
        Swal.fire({
            icon: 'warning',
            title: 'Yakin?',
            text: 'Menghapus ' + name_tabung + ' dari daftar tabung',
            showCancelButton: true, // Menampilkan tombol pembatalan
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>admin/tabung/delete/' + id_tabung,
                    type: 'DELETE',
                    success: function(response) {
                        response = JSON.parse(response);
                        Swal.fire({
                            icon: response.status,
                            title: response.title,
                            text: response.message + ' ' + name_tabung,
                        });
                        if (response.status == 'success') {
                            $('#tabung' + response.id).remove();
                        }
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