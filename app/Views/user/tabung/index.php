<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Tabung', 'description' => 'Data tabung yang dipinjam']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content section -->
<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Tabel Tabung yang dipinjam
            </h5>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
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
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_borrowed = 0;
                    ?>
                    <tr>
                        <?php if ($mitra != null) : ?>
                            <td><?= $no++ ?></td>
                            <?php
                            foreach ($tabungs as $tabung) :
                                $total_amount = 0;
                                foreach ($peminjamans as $peminjaman) :
                                    if ($peminjaman->tabung_id == $tabung->id && $peminjaman->mitra_id == $mitra->id) :
                                        $total_amount += $peminjaman->total_amount;
                                    endif;
                                endforeach;
                                $total_borrowed += $total_amount;
                                echo '<td>' . $total_amount . '</td>';
                            endforeach;
                            ?>
                            <td><?= $total_borrowed ?></td>
                        <?php else : ?>
                            <td><?= $no++ ?></td>
                            <?php foreach ($tabungs as $tabung) : ?>
                                <td>0</td>
                            <?php endforeach; ?>
                            <td>0</td>
                        <?php endif; ?>
                    </tr>
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