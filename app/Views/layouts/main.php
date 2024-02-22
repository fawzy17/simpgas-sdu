<?= $this->section('heads'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/table-datatable-jquery.css'); ?>">
<?= $this->endSection(); ?>
<?= $this->include('layouts/head'); ?>
<div id="app">
    <?= $this->include('layouts/components/sidebar'); ?>
    <div id="main" class='layout-navbar navbar-fixed'>
        <?= $this->include('layouts/components/navbar'); ?>
        <div id="main-content">
            <div class="page-heading">
                <?= $this->renderSection('page_title'); ?>
                <section class="section">
                    <?= $this->renderSection('content'); ?>
                </section>
            </div>
        </div>
    </div>
</div>
<?= $this->section('scripts'); ?>
    <script src="<?= base_url('assets/js/app.js')?>"></script>
<?= $this->endSection(); ?>
<?= $this->include('layouts/foot'); ?>