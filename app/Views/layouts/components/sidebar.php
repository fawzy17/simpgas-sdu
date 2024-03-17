<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a class="fs-5 fw-bold d-flex gap-2 align-items-center" href="<?= base_url() ?>">
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
                    <li class="sidebar-item has-sub <?= $title == 'Mitra' ? 'active' : '' ?>">
                        <a href="<?= base_url('/admin/mitra'); ?>" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Mitra</span>
                        </a>
                        <ul class="submenu active">
                            <li class="submenu-item <?= service('uri')->getSegment(3) == 'list-mitra' ? 'active' : '' ?>">
                                <a href="<?= base_url('/admin/mitra/list-mitra'); ?>" class="submenu-link">List</a>
                            </li>
                            <li class="submenu-item <?= service('uri')->getSegment(3) == 'request-mitra' ? 'active' : '' ?>">
                                <a href="<?= base_url('/admin/mitra/request-mitra'); ?>" class="submenu-link">Request</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item  <?= service('uri')->getSegment(2) == 'tabung' ? 'active' : '' ?>">
                        <a href="<?= base_url('/admin/tabung'); ?>" class='sidebar-link'>
                            <i class="bi bi-database"></i>
                            <span>Tabung</span>
                        </a>
                    </li>
                    <li class="sidebar-item has-sub <?= $title == 'Peminjaman' ? 'active' : '' ?>">
                        <a href="<?= base_url('/admin/peminjaman'); ?>" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Peminjaman</span>
                        </a>
                        <ul class="submenu active">
                            <li class="submenu-item <?= service('uri')->getSegment(3) == 'list-peminjaman' ? 'active' : '' ?>">
                                <a href="<?= base_url('/admin/peminjaman/list-peminjaman'); ?>" class="submenu-link">List</a>
                            </li>
                            <li class="submenu-item <?= service('uri')->getSegment(3) == 'list-request-peminjaman' ? 'active' : '' ?>">
                                <a href="<?= base_url('/admin/peminjaman/list-request-peminjaman'); ?>" class="submenu-link">Request</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub <?= $title == 'Pengaturan' ? 'active' : '' ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-gear"></i>
                            <span>Pengaturan</span>
                        </a>
                        <ul class="submenu active">
                            <li class="submenu-item <?= service('uri')->getSegment(3) == 'identitas' ? 'active' : '' ?>">
                                <a href="<?= base_url('/admin/pengaturan/identitas'); ?>" class="submenu-link">Identitas</a>
                            </li>
                            <li class="submenu-item <?= service('uri')->getSegment(3) == 'akun' ? 'active' : '' ?>">
                                <a href="<?= base_url('/admin/pengaturan/akun'); ?>" class="submenu-link">Akun</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php else : ?>
                <ul class="menu">
                    <li class="sidebar-item <?= service('uri')->getSegment(1) == 'dashboard' ? 'active' : '' ?>">
                        <a href="<?= base_url('/dashboard'); ?>" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= service('uri')->getSegment(1) == 'mitra' ? 'active' : '' ?>">
                        <a href="<?= base_url('/mitra'); ?>" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Mitra</span>
                        </a>
                    </li>
                    <li class="sidebar-item  <?= service('uri')->getSegment(2) == 'tabung' ? 'active' : '' ?>">
                        <a href="<?= base_url('/tabung'); ?>" class='sidebar-link'>
                            <i class="bi bi-database"></i>
                            <span>Tabung</span>
                        </a>
                    </li>
                    <li class="sidebar-item has-sub <?= $title == 'Peminjaman' ? 'active' : '' ?>">
                        <a href="<?= base_url('/peminjaman'); ?>" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Peminjaman</span>
                        </a>
                        <ul class="submenu active">
                            <li class="submenu-item <?= service('uri')->getSegment(2) == 'list-peminjaman' ? 'active' : '' ?>">
                                <a href="<?= base_url('/peminjaman/list-peminjaman'); ?>" class="submenu-link">History</a>
                            </li>
                            <li class="submenu-item <?= service('uri')->getSegment(2) == 'list-request-peminjaman' ? 'active' : '' ?>">
                                <a href="<?= base_url('/peminjaman/list-request-peminjaman'); ?>" class="submenu-link">Request</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub <?= $title == 'Pengaturan' ? 'active' : '' ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-gear"></i>
                            <span>Pengaturan</span>
                        </a>
                        <ul class="submenu active">
                            <li class="submenu-item <?= service('uri')->getSegment(2) == 'identitas' ? 'active' : '' ?>">
                                <a href="<?= base_url('/pengaturan/identitas'); ?>" class="submenu-link">Identitas</a>
                            </li>
                            <li class="submenu-item <?= service('uri')->getSegment(2) == 'akun' ? 'active' : '' ?>">
                                <a href="<?= base_url('/pengaturan/akun'); ?>" class="submenu-link">Akun</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>