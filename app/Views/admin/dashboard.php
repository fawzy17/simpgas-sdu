<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Dashboard', 'description' => 'Kelola data Anda disini']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Basic Tables start -->
<div class="col-12 col-lg-9">
    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon purple mb-2">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Mitra</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_mitras ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon blue mb-2">
                                <i class="iconly-boldProfile"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Stok Tabung</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_stock_tabungs ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon green mb-2">
                                <i class="iconly-boldAdd-User"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Tabung Dipinjam</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_borrowed ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon red mb-2">
                                <i class="iconly-boldBookmark"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Tabung Tersedia</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_stock_tabungs - $total_borrowed ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Profile Visit</h4>
                </div>
                <div class="card-body">
                    <div id="chart-peminjaman-perbulan"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Basic Tables end -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url('assets\js\apexcharts.min.js'); ?>"></script>
<script>
    var peminjamanPerbulan = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            height: 300,
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {},
        series: [{
            name: "sales",
            data: [<?php foreach ($borrowed_per_month as $borrowed) : ?> "<?= $borrowed->total_amount ?>,",
                <?php endforeach; ?>
            ],
        }],
        colors: "#435ebe",
        xaxis: {
            categories: [
                <?php foreach ($months as $month) : ?> "<?= $month ?>,",
                <?php endforeach; ?>
            ],
        },
    };
    var chartPeminjamanPerbulan = new ApexCharts(
        document.querySelector("#chart-peminjaman-perbulan"),
        peminjamanPerbulan
    )
    chartPeminjamanPerbulan.render()
</script>

<?= $this->endSection(); ?>