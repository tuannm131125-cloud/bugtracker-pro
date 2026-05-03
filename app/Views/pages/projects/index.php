<?php
/** @var array  $projects */
/** @var string $title    */
$projects = $projects ?? [];
$canCreate = in_array($_SESSION['user_role'] ?? '', ['admin','manager']);
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Dự án của tôi</h1>
        <p class="page-subtitle">Tất cả dự án bạn đang tham gia · <?= count($projects) ?> dự án</p>
    </div>
    <?php if ($canCreate): ?>
    <a href="<?= APP_URL ?>/projects/new" class="btn btn-primary">
        <i class="fa fa-plus"></i>Tạo dự án mới
    </a>
    <?php endif; ?>
</div>

<?php if (empty($projects)): ?>
<!-- Empty state -->
<div class="card text-center" style="padding:64px 24px;">
    <div style="width:64px;height:64px;border-radius:14px;background:var(--brand-50);color:var(--brand);display:inline-flex;align-items:center;justify-content:center;margin:0 auto 18px;">
        <i class="fa fa-folder-open" style="font-size:24px;"></i>
    </div>
    <h5 style="color:var(--text-primary);font-weight:600;margin-bottom:6px;">Bạn chưa tham gia dự án nào</h5>
    <p style="color:var(--text-secondary);font-size:13.5px;margin-bottom:22px;">Tạo dự án mới hoặc chờ được mời vào dự án của team</p>
    <?php if ($canCreate): ?>
    <a href="<?= APP_URL ?>/projects/new" class="btn btn-primary mx-auto" style="max-width:240px;">
        <i class="fa fa-plus"></i>Tạo dự án đầu tiên
    </a>
    <?php endif; ?>
</div>

<?php else: ?>
<!-- Project grid -->
<div class="row g-3">
    <?php foreach ($projects as $proj): ?>
    <?php
    $statusMap = [
        'active'   => ['var(--success)', 'var(--success-50)', 'Active'],
        'archived' => ['var(--text-muted)', 'var(--bg-subtle)', 'Archived'],
        'closed'   => ['var(--danger)', 'var(--danger-50)', 'Closed'],
    ];
    [$statusColor, $statusBg, $statusLabel] = $statusMap[$proj['status'] ?? 'active'] ?? ['var(--brand)', 'var(--brand-50)', 'Active'];
    $visIcon = match($proj['visibility'] ?? 'private') {
        'public'    => 'fa-globe',
        'team_only' => 'fa-users',
        default     => 'fa-lock',
    };
    $visLabel = match($proj['visibility'] ?? 'private') {
        'public'    => 'Công khai',
        'team_only' => 'Team',
        default     => 'Riêng tư',
    };
    ?>
    <div class="col-md-6 col-lg-4">
        <a href="<?= APP_URL ?>/projects/<?= e(strtolower($proj['key'])) ?>"
           class="card project-card h-100 text-decoration-none">
            <div class="card-body" style="padding:20px;">

                <!-- Card header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-3" style="min-width:0;">
                        <div class="project-avatar" style="background:var(--brand-50);color:var(--brand);">
                            <?= mb_strtoupper(mb_substr($proj['name'], 0, 2)) ?>
                        </div>
                        <div style="min-width:0;">
                            <div style="font-weight:600;font-size:14px;color:var(--text-primary);text-overflow:ellipsis;overflow:hidden;white-space:nowrap;">
                                <?= e($proj['name']) ?>
                            </div>
                            <span class="issue-key-tag" style="margin-top:2px;display:inline-block;">
                                <?= e($proj['key']) ?>
                            </span>
                        </div>
                    </div>
                    <span class="text-muted" title="<?= e($visLabel) ?>" style="font-size:12px;">
                        <i class="fa <?= $visIcon ?>"></i>
                    </span>
                </div>

                <!-- Description -->
                <?php if (!empty($proj['description'])): ?>
                <p style="font-size:13px;color:var(--text-secondary);line-height:1.55;margin-bottom:16px;min-height:40px;">
                    <?= e(truncate($proj['description'], 90)) ?>
                </p>
                <?php else: ?>
                <p style="font-size:13px;color:var(--text-muted);font-style:italic;margin-bottom:16px;min-height:40px;">
                    Chưa có mô tả
                </p>
                <?php endif; ?>

                <!-- Stats row -->
                <div class="d-flex align-items-center gap-3 pt-3" style="border-top:1px solid var(--border-subtle);font-size:12.5px;color:var(--text-secondary);">
                    <span class="d-flex align-items-center gap-1">
                        <i class="fa fa-circle-dot" style="color:var(--brand);font-size:10px;"></i>
                        <strong style="color:var(--text-primary);"><?= $proj['open_bugs'] ?? 0 ?></strong>
                        <span style="color:var(--text-muted);">open</span>
                    </span>
                    <span class="d-flex align-items-center gap-1">
                        <i class="fa fa-users" style="color:var(--text-muted);font-size:10px;"></i>
                        <strong style="color:var(--text-primary);"><?= $proj['member_count'] ?? 0 ?></strong>
                    </span>
                    <span class="ms-auto" style="color:var(--text-muted);font-size:11.5px;">
                        <?= timeAgo($proj['created_at']) ?>
                    </span>
                </div>
            </div>

            <!-- Card footer -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="badge" style="background:<?= $statusBg ?>;color:<?= $statusColor ?>;border-color:<?= $statusColor ?>33;">
                    <?= $statusLabel ?>
                </span>
                <span style="font-size:12px;color:var(--brand);font-weight:500;">
                    Xem issues <i class="fa fa-arrow-right" style="font-size:10px;margin-left:4px;"></i>
                </span>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<style>
.project-card {
    color: inherit;
    transition: all .15s var(--ease);
    cursor: pointer;
}
.project-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--border-strong);
    color: inherit;
}
.project-avatar {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    flex-shrink: 0;
    letter-spacing: -0.01em;
}
</style>
