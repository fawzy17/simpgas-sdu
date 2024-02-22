<?= $this->section('heads'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css'); ?>">
<?= $this->endSection(); ?>
<?= $this->include('layouts/head'); ?>
<div id="app">
    <?= $this->renderSection('content'); ?>
</div>
<?= $this->include('layouts/foot'); ?>