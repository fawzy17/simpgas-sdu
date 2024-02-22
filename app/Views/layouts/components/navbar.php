<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="ms-auto">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-menu d-flex align-items-center">
                                <div class="user-name text-end me-3">
                                    <h6 class="mb-0 text-gray-600"><?= session()->get('username'); ?></h6>
                                    <p class="mb-0 text-sm text-gray-600 text-capitalize">
                                        <?php
                                        $roles = [
                                            1 => 'superadmin',
                                            2 => 'admin',
                                            3 => 'user',
                                        ];
                                        echo $roles[session()->get('role_id')];
                                        ?>
                                    </p>
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md">
                                        <?php
                                        $imageProfile = base_url('assets/' . session()->get('image'));
                                        if (session()->get('role_id') == 3) $imageProfile = session()->get('image');
                                        ?>
                                        <img src="<?= $imageProfile ?>" alt="profile">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                            <li>
                                <h6 class="dropdown-header">Hello, <?= session()->get('username') ?>!</h6>
                            </li>
                            <li>
                                <?php
                                $profile_routes = [
                                    1 => '/superadmin/profile',
                                    2 => '/admin/profile',
                                    3 => '/profile',
                                ];
                                ?>
                                <a class="dropdown-item" href="<?= base_url($profile_routes[session()->get('role_id')]); ?>"><i class="icon-mid bi bi-person me-2"></i> My
                                    Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?php $logout_routes = [
                                    1 => [
                                        'url' => '/superadmin/logout',
                                        'redirectTo' => '/superadmin/login',
                                    ],
                                    2 => [
                                        'url' => '/admin/logout',
                                        'redirectTo' => '/admin/login',
                                    ],
                                    3 => [
                                        'url' => '/logout',
                                        'redirectTo' => '/login',
                                    ]
                                ];
                                ?>
                                <button type="button" id="logout" class="dropdown-item"><i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                    Logout
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>