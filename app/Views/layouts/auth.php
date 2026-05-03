<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0F1F3D">
    <title><?= htmlspecialchars($title ?? 'BugTracker Pro') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/public/css/auth.css" rel="stylesheet">
</head>
<body>

<div class="auth-page">

    <!-- ═══ LEFT: Form ═══ -->
    <div class="auth-form-side">
        <div class="auth-form-wrapper">

            <!-- Brand -->
            <a href="<?= APP_URL ?>/" class="auth-brand">
                <span class="auth-brand-icon"><i class="fa-solid fa-bug"></i></span>
                BugTracker Pro
            </a>

            <!-- Stepper (only when in registration flow) -->
            <?php if (!empty($step)): ?>
            <?php $steps = ['Tài khoản', 'Hồ sơ', 'Workspace', 'Mời thành viên']; ?>
            <div class="auth-stepper">
                <?php foreach ($steps as $i => $label):
                    $stepNum = $i + 1;
                    $cls = $stepNum < $step ? 'done' : ($stepNum == $step ? 'active' : '');
                ?>
                <div class="auth-step <?= $cls ?>">
                    <span class="auth-step-num">
                        <?php if ($cls === 'done'): ?>
                        <i class="fa fa-check" style="font-size:10px;"></i>
                        <?php else: ?>
                        <?= $stepNum ?>
                        <?php endif; ?>
                    </span>
                    <span class="d-none d-sm-inline"><?= htmlspecialchars($label) ?></span>
                </div>
                <?php if ($i < count($steps) - 1): ?>
                <span class="auth-step-divider"></span>
                <?php endif; endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Form content (slot) -->
            <?= $content ?>

            <p class="auth-footer-note">
                &copy; <?= date('Y') ?> BugTracker Pro · Miễn phí mãi mãi
            </p>
        </div>
    </div>

    <!-- ═══ RIGHT: Marketing aside ═══ -->
    <aside class="auth-aside">
        <div class="auth-aside-content">
            <span class="auth-aside-tag">
                <i class="fa fa-sparkles" style="font-size:11px;"></i>
                Theo dõi bug mượt mà như cách dev nghĩ
            </span>
            <h2>Quản lý issue với<br>tốc độ và sự rõ ràng.</h2>
            <p class="lead">
                BugTracker Pro mang đến bộ công cụ cần thiết cho team dev — kanban, sprint, báo cáo,
                phân quyền — gói gọn trong giao diện sạch và nhanh.
            </p>

            <div class="mt-4">
                <div class="auth-feature">
                    <i class="fa fa-bolt"></i>
                    <div>
                        <p class="auth-feature-title">Realtime activity log</p>
                        <p class="auth-feature-desc">Mọi thay đổi được ghi nhận tức thì, đồng bộ giữa các thành viên.</p>
                    </div>
                </div>
                <div class="auth-feature">
                    <i class="fa fa-table-columns"></i>
                    <div>
                        <p class="auth-feature-title">Kanban kéo thả mượt mà</p>
                        <p class="auth-feature-desc">Cập nhật status không cần reload — tối ưu cho workflow Agile.</p>
                    </div>
                </div>
                <div class="auth-feature">
                    <i class="fa fa-shield-halved"></i>
                    <div>
                        <p class="auth-feature-title">Phân quyền 5 cấp</p>
                        <p class="auth-feature-desc">Admin, Manager, Developer, Reporter, Viewer — kiểm soát tới từng action.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-aside-footer">
            <span>Phát triển bởi team Việt</span>
            <div>
                <a href="<?= APP_URL ?>/">Trang chủ</a>
                <a href="#">Hỗ trợ</a>
            </div>
        </div>
    </aside>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= APP_URL ?>/public/js/auth.js"></script>
</body>
</html>
