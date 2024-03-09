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
                        <th>Ukuran(L)</th>
                        <th>Berat(KG)</th>
                        <th>Stok</th>
                        <th>Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($tabungs as $tabung) : ?>
                        <tr>
                            <td class="text-left"><?= $no++ ?></td>
                            <td class="text-left"><?= $tabung->name ?></td>
                            <td class="text-left">
                                <?php if ($tabung->category == 1) {
                                    echo "Gass";
                                } elseif ($tabung->category == 2) {
                                    echo "Liquid";
                                } elseif ($tabung->category == 3) {
                                    echo "Solid";
                                }
                                ?>
                            </td>
                            <td class="text-left"><?= $tabung->size ?></td>
                            <td class="text-left"><?= $tabung->weight ?></td>
                            <td class="text-left">200</td>
                            <td class="text-left"><?= $tabung->total_borrowed ?> </td>
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
        "responsive": true,
        "columnDefs": [{
                "type": "string",
                "targets": [0, 3, 4, 5, 6]
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

<?= $this->endSection(); ?>