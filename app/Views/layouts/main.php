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
<?= $this->include('layouts/foot'); ?>