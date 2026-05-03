<?php
$stats             = $stats             ?? [];
$myBugs            = $myBugs            ?? [];
$recentActivity    = $recentActivity    ?? [];
$projects          = $projects          ?? [];
$upcomingDeadlines = $upcomingDeadlines ?? [];

$firstName = explode(' ', $_SESSION['user_name'] ?? 'bạn')[0];
?>

<!-- Page header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Xin chào, <?= e($firstName) ?></h1>
        <p class="page-subtitle">Tổng quan công việc & dự án của bạn hôm nay.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= APP_URL ?>/projects" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-folder"></i>Tất cả dự án
        </a>
    </div>
</div>

<!-- Stats widgets -->
<div class="row g-3 mb-4">
    <?php
    $widgets = [
        ['Bugs được giao',   $stats['assigned_to_me'] ?? 0, 'var(--brand)',   'var(--brand-50)',   'fa-user-check'],
        ['Đang xử lý',       $stats['in_progress']    ?? 0, 'var(--warning)', 'var(--warning-50)', 'fa-spinner'],
        ['Quá hạn',          $stats['overdue']        ?? 0, 'var(--danger)',  'var(--danger-50)',  'fa-clock'],
        ['Resolved hôm nay', $stats['resolved_today'] ?? 0, 'var(--success)', 'var(--success-50)', 'fa-circle-check'],
    ];
    foreach ($widgets as [$label, $count, $color, $bg, $icon]):
    ?>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label"><?= $label ?></div>
                    <div class="stat-value"><?= $count ?></div>
                </div>
                <div class="stat-icon" style="background:<?= $bg ?>;color:<?= $color ?>;">
                    <i class="fa <?= $icon ?>"></i>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <!-- Left column -->
    <div class="col-lg-7">

        <!-- My Bugs -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-bug" style="color:var(--danger);"></i>
                    <span>Bugs được giao cho tôi</span>
                </div>
                <span class="badge bg-secondary"><?= count($myBugs) ?></span>
            </div>
            <?php if (empty($myBugs)): ?>
            <div class="card-body text-center py-5">
                <i class="fa fa-circle-check d-block mb-2" style="font-size:28px;color:var(--success);opacity:.7;"></i>
                <p class="mb-0" style="color:var(--text-secondary);">Không có bug nào đang chờ xử lý!</p>
            </div>
            <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($myBugs as $bug): ?>
                <a href="<?= APP_URL ?>/issues/<?= e($bug['issue_key']) ?>"
                   class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2 flex-grow-1" style="min-width:0;">
                            <span class="issue-key-tag"><?= e($bug['issue_key']) ?></span>
                            <span class="text-truncate" style="font-size:13.5px;color:var(--text-primary);">
                                <?= e(truncate($bug['title'], 60)) ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-1 flex-shrink-0">
                            <?= priorityBadge($bug['priority']) ?>
                            <?= statusBadge($bug['status']) ?>
                            <?php if (isOverdue($bug['due_date'], $bug['status'])): ?>
                            <span class="badge bg-danger">Quá hạn</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Upcoming Deadlines -->
        <?php if (!empty($upcomingDeadlines)): ?>
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fa fa-calendar" style="color:var(--warning);"></i>
                Sắp đến hạn (7 ngày)
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($upcomingDeadlines as $bug): ?>
                <a href="<?= APP_URL ?>/issues/<?= e($bug['issue_key']) ?>"
                   class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <span style="font-size:13px;color:var(--text-primary);" class="text-truncate">
                            <?= e(truncate($bug['title'], 50)) ?>
                        </span>
                        <span class="badge bg-warning"><?= formatDate($bug['due_date']) ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right column -->
    <div class="col-lg-5">

        <!-- Projects -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-folder" style="color:var(--brand);"></i>
                    Dự án của tôi
                </div>
                <a href="<?= APP_URL ?>/projects"
                   class="btn-link" style="font-size:12px;">Xem tất cả →</a>
            </div>
            <?php if (empty($projects)): ?>
            <div class="card-body text-center py-4">
                <p class="mb-2" style="color:var(--text-secondary);font-size:13px;">Chưa có dự án nào</p>
                <a href="<?= APP_URL ?>/projects/new" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i>Tạo dự án mới
                </a>
            </div>
            <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach (array_slice($projects, 0, 5) as $proj): ?>
                <a href="<?= APP_URL ?>/projects/<?= e(strtolower($proj['key'])) ?>"
                   class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div style="min-width:0;">
                            <div style="font-weight:600;font-size:13.5px;color:var(--text-primary);">
                                <?= e($proj['name']) ?>
                            </div>
                            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                                <?= $proj['open_bugs'] ?? 0 ?> open ·
                                <?= $proj['member_count'] ?? 0 ?> thành viên
                            </div>
                        </div>
                        <span class="issue-key-tag"><?= e($proj['key']) ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fa fa-clock-rotate-left" style="color:var(--text-muted);"></i>
                Hoạt động gần đây
            </div>
            <?php if (empty($recentActivity)): ?>
            <div class="card-body text-center py-4">
                <p class="mb-0" style="color:var(--text-muted);font-size:13px;">Chưa có hoạt động nào</p>
            </div>
            <?php else: ?>
            <div class="card-body" style="padding:14px 18px;">
                <?php foreach (array_slice($recentActivity, 0, 10) as $act): ?>
                <div class="d-flex gap-2 py-2" style="font-size:13px;border-bottom:1px solid var(--border-subtle);">
                    <span style="width:7px;height:7px;border-radius:50%;background:var(--brand);margin-top:7px;flex-shrink:0;box-shadow:0 0 0 3px var(--brand-50);"></span>
                    <div style="min-width:0;flex:1;">
                        <span style="color:var(--text-primary);">
                            <strong><?= e(explode(' ', $act['user_name'])[0]) ?></strong>
                            <?= e($act['action']) ?>
                            <?php if (!empty($act['bug_key'])): ?>
                            <a href="<?= APP_URL ?>/issues/<?= e($act['bug_key']) ?>" class="issue-key-tag" style="text-decoration:none;">
                                <?= e($act['bug_key']) ?>
                            </a>
                            <?php endif; ?>
                        </span>
                        <div style="color:var(--text-muted);font-size:11.5px;margin-top:2px;">
                            <?= timeAgo($act['created_at']) ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
