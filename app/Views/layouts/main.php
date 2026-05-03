<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0F1F3D">
    <title><?= htmlspecialchars($title ?? 'BugTracker Pro') ?></title>

    <!-- Preconnect Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Inter — primary UI font; JetBrains Mono — code/key -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- App design system -->
    <link href="<?= APP_URL ?>/public/css/app.css" rel="stylesheet">
</head>
<body>

<!-- ════════════════════════════════════
     NAVBAR
════════════════════════════════════ -->
<nav class="navbar app-navbar navbar-expand-lg sticky-top">
    <div class="container-fluid px-4 d-flex align-items-center" style="height:var(--topbar-h);">

        <!-- Logo -->
        <a class="navbar-brand me-4" href="<?= APP_URL ?>/dashboard">
            <span class="brand-icon"><i class="fa-solid fa-bug"></i></span>
            BugTracker Pro
        </a>

        <!-- Global search (Ctrl+K) -->
        <div class="global-search d-none d-lg-block">
            <i class="fa fa-search search-icon"></i>
            <input type="text"
                   id="globalSearch"
                   class="form-control"
                   placeholder="Tìm kiếm issue, project..."
                   autocomplete="off">
            <span class="kbd">Ctrl K</span>
            <div id="searchResults"
                 class="position-absolute d-none"
                 style="width:380px;z-index:9999;max-height:340px;overflow-y:auto;left:0;">
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">

            <!-- Create button -->
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle d-inline-flex align-items-center gap-2"
                        data-bs-toggle="dropdown">
                    <i class="fa fa-plus"></i>
                    <span class="d-none d-md-inline">Tạo mới</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header">Tạo mới</li>
                    <li>
                        <a class="dropdown-item" href="<?= APP_URL ?>/projects/new">
                            <i class="fa fa-folder-plus"></i>Dự án mới
                        </a>
                    </li>
                    <?php
                    if (!empty($_SESSION['user_id'])) {
                        try {
                            $navProjModel = new ProjectModel();
                            $navProjects  = $navProjModel->getByUser($_SESSION['user_id']);
                            if (!empty($navProjects)) {
                                echo '<li><hr class="dropdown-divider"></li>';
                                echo '<li class="dropdown-header">Issue trong dự án</li>';
                                foreach (array_slice($navProjects, 0, 4) as $np):
                    ?>
                    <li>
                        <a class="dropdown-item"
                           href="<?= APP_URL ?>/projects/<?= htmlspecialchars(strtolower($np['key'])) ?>/issues/new">
                            <i class="fa fa-bug"></i>
                            <span><?= htmlspecialchars($np['name']) ?></span>
                            <span class="ms-auto issue-key-tag" style="font-size:10px;">
                                <?= htmlspecialchars($np['key']) ?>
                            </span>
                        </a>
                    </li>
                    <?php
                                endforeach;
                            }
                        } catch (Exception $e) { /* DB chưa sẵn sàng */ }
                    }
                    ?>
                </ul>
            </div>

            <!-- Notification bell -->
            <div class="dropdown">
                <button class="nav-icon-btn"
                        data-bs-toggle="dropdown"
                        title="Thông báo"
                        aria-label="Thông báo">
                    <i class="fa fa-bell"></i>
                    <?php
                    $navUnread = 0;
                    if (!empty($_SESSION['user_id'])) {
                        try {
                            $navNotifModel = new NotificationModel();
                            $navUnread     = $navNotifModel->countUnread($_SESSION['user_id']);
                        } catch (Exception $e) { /* ignore */ }
                    }
                    if ($navUnread > 0):
                    ?>
                    <span class="nav-badge"><?= $navUnread > 99 ? '99+' : $navUnread ?></span>
                    <?php endif; ?>
                </button>

                <div class="dropdown-menu dropdown-menu-end notif-dropdown">
                    <div class="notif-header">
                        <span><i class="fa fa-bell me-2"></i>Thông báo</span>
                        <?php if ($navUnread > 0): ?>
                        <a href="<?= APP_URL ?>/notifications/read-all"
                           class="text-decoration-none"
                           style="font-size:12px;color:var(--brand);font-weight:500;">
                            Đánh dấu đã đọc
                        </a>
                        <?php endif; ?>
                    </div>

                    <?php
                    if (!empty($_SESSION['user_id'])) {
                        try {
                            $navNotifs = (new NotificationModel())->getLatest($_SESSION['user_id'], 8);
                            if (!empty($navNotifs)):
                                foreach ($navNotifs as $notif):
                                $isUnread = !$notif['is_read'];
                    ?>
                    <a href="<?= $notif['link'] ? APP_URL . htmlspecialchars($notif['link']) : '#' ?>"
                       class="notif-item <?= $isUnread ? 'unread' : '' ?>">
                        <div class="d-flex gap-2 align-items-start">
                            <div style="width:8px;height:8px;border-radius:50%;
                                        background:<?= $isUnread ? 'var(--brand)' : 'transparent' ?>;
                                        margin-top:6px;flex-shrink:0;"></div>
                            <div style="min-width:0;flex:1;">
                                <div style="font-size:13px;font-weight:<?= $isUnread ? '600':'500' ?>;color:var(--text-primary);">
                                    <?= htmlspecialchars($notif['title']) ?>
                                </div>
                                <?php if (!empty($notif['message'])): ?>
                                <div style="font-size:12px;color:var(--text-secondary);margin-top:2px;line-height:1.5;">
                                    <?= htmlspecialchars(mb_substr($notif['message'], 0, 70)) ?>
                                    <?= mb_strlen($notif['message']) > 70 ? '...' : '' ?>
                                </div>
                                <?php endif; ?>
                                <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">
                                    <i class="fa fa-clock me-1"></i>
                                    <?= function_exists('timeAgo') ? timeAgo($notif['created_at']) : $notif['created_at'] ?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                                endforeach;
                            else:
                    ?>
                    <div class="text-center py-5" style="color:var(--text-muted);font-size:13px;">
                        <i class="fa fa-bell-slash d-block mb-2" style="font-size:24px;opacity:.4;"></i>
                        Chưa có thông báo nào
                    </div>
                    <?php
                            endif;
                        } catch (Exception $e) {
                    ?>
                    <div class="text-center py-4" style="color:var(--text-muted);font-size:13px;">
                        Chưa có thông báo
                    </div>
                    <?php } } ?>

                    <div class="notif-footer">
                        <a href="<?= APP_URL ?>/notifications"
                           class="text-decoration-none"
                           style="color:var(--brand);font-weight:500;">
                            Xem tất cả thông báo →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Avatar + user menu -->
            <div class="dropdown">
                <button class="nav-avatar-btn" data-bs-toggle="dropdown" aria-label="User menu">
                    <?php
                    $navAvatar = $_SESSION['user_avatar'] ?? null;
                    $navName   = $_SESSION['user_name']   ?? 'User';
                    $navInitial= mb_strtoupper(mb_substr($navName, 0, 1));
                    if ($navAvatar):
                    ?>
                    <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($navAvatar) ?>"
                         class="avatar"
                         alt="<?= htmlspecialchars($navName) ?>">
                    <?php else: ?>
                    <div class="avatar avatar-fallback"><?= $navInitial ?></div>
                    <?php endif; ?>
                </button>

                <ul class="dropdown-menu dropdown-menu-end" style="min-width:240px;">
                    <li class="px-2 py-2">
                        <div class="d-flex align-items-center gap-2 px-1 py-1">
                            <?php if ($navAvatar): ?>
                            <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($navAvatar) ?>"
                                 class="avatar-md" alt="">
                            <?php else: ?>
                            <div class="avatar-md avatar-fallback"><?= $navInitial ?></div>
                            <?php endif; ?>
                            <div style="min-width:0;flex:1;">
                                <div style="font-weight:600;font-size:13px;color:var(--text-primary);">
                                    <?= htmlspecialchars($navName) ?>
                                </div>
                                <div style="font-size:12px;color:var(--text-muted);text-overflow:ellipsis;overflow:hidden;white-space:nowrap;">
                                    <?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item" href="<?= APP_URL ?>/profile">
                            <i class="fa fa-user"></i>Hồ sơ cá nhân
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= APP_URL ?>/settings">
                            <i class="fa fa-gear"></i>Cài đặt
                        </a>
                    </li>

                    <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?= APP_URL ?>/admin">
                            <i class="fa fa-shield-halved" style="color:var(--warning) !important;"></i>
                            Quản trị hệ thống
                        </a>
                    </li>
                    <?php endif; ?>

                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="<?= APP_URL ?>/logout">
                            <i class="fa fa-right-from-bracket"></i>Đăng xuất
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>

<!-- ════════════════════════════════════
     SIDEBAR + CONTENT
════════════════════════════════════ -->
<div class="d-flex" style="min-height:calc(100vh - var(--topbar-h));">

    <!-- Sidebar -->
    <aside class="app-sidebar d-none d-lg-flex">

        <!-- Main nav -->
        <ul class="nav nav-pills flex-column">
            <?php
            $reqUri = $_SERVER['REQUEST_URI'] ?? '';
            $isDashboard = str_contains($reqUri, '/dashboard');
            $isProjects  = str_contains($reqUri, '/projects') && !str_contains($reqUri, '/issues');
            $isIssues    = str_contains($reqUri, '/issues');
            $isReports   = str_contains($reqUri, '/reports');
            $isNotifs    = str_contains($reqUri, '/notifications');
            ?>
            <li class="nav-item">
                <a href="<?= APP_URL ?>/dashboard" class="nav-link <?= $isDashboard ? 'active' : '' ?>">
                    <i class="fa fa-gauge-high"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= APP_URL ?>/projects" class="nav-link <?= $isProjects ? 'active' : '' ?>">
                    <i class="fa fa-folder"></i>Dự án
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= APP_URL ?>/notifications" class="nav-link <?= $isNotifs ? 'active' : '' ?>">
                    <i class="fa fa-bell"></i>Thông báo
                    <?php if (!empty($navUnread) && $navUnread > 0): ?>
                    <span class="sidebar-pill-count"><?= $navUnread > 99 ? '99+' : $navUnread ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= APP_URL ?>/reports" class="nav-link <?= $isReports ? 'active' : '' ?>">
                    <i class="fa fa-chart-line"></i>Báo cáo
                </a>
            </li>
        </ul>

        <!-- Recent projects -->
        <div class="sidebar-section">Dự án gần đây</div>
        <ul class="nav nav-pills flex-column">
            <?php
            if (!empty($_SESSION['user_id'])) {
                try {
                    $sidebarProjModel = new ProjectModel();
                    $sidebarProjects  = $sidebarProjModel->getByUser($_SESSION['user_id']);

                    if (!empty($sidebarProjects)) {
                        foreach (array_slice($sidebarProjects, 0, 6) as $sp):
                            $spKey      = strtolower($sp['key']);
                            $isActive   = str_contains($reqUri, '/projects/' . $spKey);
                            $openCount  = $sp['open_bugs'] ?? 0;
                ?>
                <li>
                    <a href="<?= APP_URL ?>/projects/<?= htmlspecialchars($spKey) ?>"
                       class="nav-link <?= $isActive ? 'active' : '' ?>"
                       title="<?= htmlspecialchars($sp['name']) ?>">
                        <span class="sidebar-project-dot"></span>
                        <span class="text-truncate" style="flex:1;min-width:0;">
                            <?= htmlspecialchars($sp['name']) ?>
                        </span>
                        <?php if ($openCount > 0): ?>
                        <span class="sidebar-pill-count"><?= $openCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php
                        endforeach;
                    } else {
                ?>
                <li>
                    <a href="<?= APP_URL ?>/projects/new"
                       class="nav-link"
                       style="font-size:12.5px;color:var(--text-muted);">
                        <i class="fa fa-plus"></i>Tạo dự án mới
                    </a>
                </li>
                <?php
                    }
                } catch (Exception $e) {
                ?>
                <li>
                    <span class="nav-link" style="font-size:12px;color:var(--text-muted);">
                        Chưa có dự án
                    </span>
                </li>
                <?php } }  ?>
        </ul>

        <!-- Sidebar footer profile -->
        <div class="sidebar-footer">
            <a href="<?= APP_URL ?>/profile" class="sidebar-profile">
                <?php if (!empty($_SESSION['user_avatar'])): ?>
                <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($_SESSION['user_avatar']) ?>"
                     class="avatar-sm" alt="">
                <?php else: ?>
                <div class="avatar-sm avatar-fallback" style="font-size:10px;">
                    <?= mb_strtoupper(mb_substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <?php endif; ?>
                <div style="min-width:0;flex:1;">
                    <div style="font-size:12.5px;font-weight:600;color:var(--text-primary);line-height:1.2;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;">
                        <?= htmlspecialchars(mb_substr($_SESSION['user_name'] ?? '', 0, 24)) ?>
                    </div>
                    <div style="font-size:11px;color:var(--text-muted);text-transform:capitalize;">
                        <?= htmlspecialchars($_SESSION['user_role'] ?? '') ?>
                    </div>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main content area -->
    <main class="app-main">

        <!-- Flash message -->
        <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>
                    alert-dismissible fade show mb-3"
             role="alert">
            <i class="fa <?= match($_SESSION['flash']['type']) {
                'success' => 'fa-circle-check',
                'danger'  => 'fa-circle-xmark',
                'warning' => 'fa-triangle-exclamation',
                default   => 'fa-circle-info',
            } ?>"></i>
            <span style="flex:1;"><?= $_SESSION['flash']['message'] ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); endif; ?>

        <!-- View content -->
        <?= $content ?? '' ?>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- App JS -->
<script src="<?= APP_URL ?>/public/js/app.js"></script>

<script>
// Global Search Ctrl+K
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const s = document.getElementById('globalSearch');
        if (s) { s.focus(); s.select(); }
    }
});

// Close search dropdown when clicking outside
document.addEventListener('click', function(e) {
    const results = document.getElementById('searchResults');
    if (results && !e.target.closest('#globalSearch') && !e.target.closest('#searchResults')) {
        results.classList.add('d-none');
    }
});

// Auto-hide flash after 4 seconds
document.querySelectorAll('.alert').forEach(function(el) {
    setTimeout(function() {
        el.classList.remove('show');
        setTimeout(() => el.remove(), 300);
    }, 4500);
});
</script>

</body>
</html>
