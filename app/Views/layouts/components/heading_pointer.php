<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?= $title_header ?></h3>
            <p class="text-subtitle text-muted"><?= $description; ?></p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <?php
                        $segments = service('uri')->getSegments();
                        $totalSegment = service('uri')->getTotalSegments();
                        if($totalSegment == 2): ?>
                        <p><?= date('l, d F Y'); ?></p>
                    <?php else: 
                        $routes = [
                            1 => '/superadmin',
                            2 => '/admin',
                            3 => '/events'
                        ];
                        foreach($segments as $segment => $value):
                        if($segment > 0):
                            if($segment < $totalSegment-1 && $value !== 'edit'):
                        ?>
                            <li class="breadcrumb-item text-capitalize"><a href="<?= base_url($routes[session()->get('role_id')]. '/'. $value); ?>"><?= $value;  ?></a></li>
                            <?php else: ?>
                            <li class="breadcrumb-item active text-capitalize" aria-current="page">
                                <?= $value; ?>
                            </li>
                            <?php endif;endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
            </nav>
        </div>
    </div>
</div>