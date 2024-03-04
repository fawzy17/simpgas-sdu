<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a class="fs-5 fw-bold d-flex gap-2 align-items-center" href="<?= base_url()?>">
                        <!-- <div class="border border-danger p-1 rounded">
                            <img src="<?= base_url('assets/images/logo.png'); ?>" alt="logo" width="32px">
                        </div> -->
                        <span class="text-2xl">SIMPGAS - SDU</span>
                    </a>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <?php if (session()->get('role_id') == 1) : ?>
                <ul class="menu">
                    <li class="sidebar-item <?= service('uri')->getSegment(2) == 'dashboard' ? 'active' : '' ?>">
                        <a href="<?= base_url('/superadmin/dashboard'); ?>" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= service('uri')->getSegment(2) == 'users' ? 'active' : '' ?>">
                        <a href="<?= base_url('/superadmin/users'); ?>" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= service('uri')->getSegment(2) == 'events' ? 'active' : '' ?>">
                        <a href="<?= base_url('/superadmin/events'); ?>" class='sidebar-link'>
                            <i class="bi bi-balloon-heart-fill"></i>
                            <span>Events</span>
                        </a>
                    </li>
                </ul>
            <?php elseif (session()->get('role_id') == 2) : ?>
                <ul class="menu">
                    <li class="sidebar-item <?= service('uri')->getSegment(2) == 'dashboard' ? 'active' : '' ?>">
                        <a href="<?= base_url('/admin/dashboard'); ?>" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= service('uri')->getSegment(2) == 'events' ? 'active' : '' ?>">
                        <a href="<?= base_url('/admin/mitra'); ?>" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Mitra</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= service('uri')->getSegment(2) == 'tabung' ? 'active' : '' ?>">
                        <a href="<?= base_url('/admin/tabung'); ?>" class='sidebar-link'>
                            <i class="bi bi-database"></i>
                            <span>Tabung</span>
                        </a>
                    </li>
                </ul>
            <?php else : ?>
                <ul class="menu">
                    <li class="sidebar-item">
                        <a href="<?= base_url('/dashboard'); ?>" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= service('uri')->getSegment(1) == 'profile' ? 'active' : '' ?>">
                        <a href="<?= base_url('/profile'); ?>" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <?php if (session()->get('is_event_collaborator')) : ?>
                        <li class="sidebar-item <?= service('uri')->getSegment(2) == 'manage' ? 'active' : '' ?>">
                            <a href="<?= base_url('/events/manage'); ?>" class='sidebar-link'>
                                <i class="bi bi-calendar-event-fill"></i>
                                <span>Manage Events</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="sidebar-item <?= service('uri')->getSegment(1) == 'yourevents' ? 'active' : '' ?>">
                        <a href="<?= base_url('/yourevents'); ?>" class='sidebar-link'>
                            <i class="bi bi-balloon-heart-fill"></i>
                            <span>Your Events</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= service('uri')->getSegment(2) == 'history' ? 'active' : '' ?>">
                        <a href="<?= base_url('/events/history'); ?>" class='sidebar-link'>
                            <i class="bi bi-clock-history"></i>
                            <span>History Events</span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>