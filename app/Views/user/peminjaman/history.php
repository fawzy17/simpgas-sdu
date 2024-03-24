<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Peminjaman', 'description' => 'Riwayat peminjaman yang anda lakukan']); ?>
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
            <a href="<?= base_url('/peminjaman/request'); ?>" class="btn btn-sm icon icon-left btn-danger">
                <i class="bi bi-person-plus"></i>
                Tambah
            </a>
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
                        <th>
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($loan_codes as $loan) :
                        $status = "";
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <?php
                            foreach ($tabungs as $tabung) :
                                $total_amount = 0;
                                foreach ($peminjamans as $peminjaman) :
                                    if ($peminjaman->tabung_id == $tabung->id && $loan->loan_code == $peminjaman->loan_code) :
                                        $total_amount += $peminjaman->amount;
                                        $status = $peminjaman->status;
                                    endif;
                                endforeach;
                                echo '<td>' . $total_amount . '</td>';
                            endforeach;
                            ?>
                            <?php if ($status == 'done') : ?>
                                <td>
                                    <span class="badge bg-success">Selesai</span>
                                </td>
                            <?php elseif ($status == 'waiting') : ?>
                                <td>
                                    <span class="badge bg-warning">Menunggu</span>
                                </td>
                            <?php elseif ($status == 'sent') : ?>
                                <td>
                                    <span class="badge bg-info">Dikirim</span>
                                </td>
                            <?php else : ?>
                                <td>
                                    <span class="badge bg-warning">Menunggu</span>
                                </td>
                            <?php endif; ?>
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