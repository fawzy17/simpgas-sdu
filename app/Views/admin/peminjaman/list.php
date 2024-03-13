<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Peminjaman', 'description' => 'Kelola data tabung yang dipinjam oleh mitra']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content section -->
<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Tabel Pinjaman Tabung oleh Mitra
            </h5>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Mitra</th>
                        <?php foreach ($tabungs as $tabung) : ?>
                            <th>
                                <?php if ($tabung->category_massa == 'kubik') : ?>
                                    <?= $tabung->name . ' ' . $tabung->category_name ?>m<sup>3</sup>
                                <?php elseif ($tabung->category_massa == 'kilogram') : ?>
                                    <?= $tabung->name . ' ' . $tabung->category_name ?>Kg
                                <?php else : ?>
                                    <?= $tabung->name . ' ' . $tabung->category_name ?>
                                <?php endif; ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($mitras as $mitra) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $mitra->name ?></td>
                            <?php
                            foreach ($tabungs as $tabung) :
                                $total_amount = 0;
                                foreach ($peminjamans as $peminjaman) :
                                    if ($peminjaman->tabung_id == $tabung->id && $peminjaman->mitra_id == $mitra->id) :
                                        $total_amount += $peminjaman->total_amount;
                                    endif;
                                endforeach;
                                echo '<td>' . $total_amount . '</td>';
                            endforeach;
                            ?>
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
        "fixedColumns": {
            start: 2,
            end: 0
        },
        "responsive": true,
        "columnDefs": [{
            "type": "string",
            "targets": "_all"
        }],
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


<?= $this->endSection(); ?>