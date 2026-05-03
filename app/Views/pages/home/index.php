<?php
// Landing page — sử dụng layout riêng (không sidebar)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FFFFFF">
    <meta name="description" content="BugTracker Pro — Hệ thống quản lý bug & issue chuyên nghiệp, miễn phí cho team dev. Kanban, sprint, báo cáo, phân quyền.">
    <title>BugTracker Pro — Quản lý bug & issue cho team dev</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/public/css/landing.css" rel="stylesheet">
</head>
<body>

<!-- ════════════════════════════════════
     NAVBAR
════════════════════════════════════ -->
<nav class="lp-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">

            <a href="<?= APP_URL ?>/" class="brand">
                <span class="brand-icon"><i class="fa-solid fa-bug"></i></span>
                BugTracker Pro
            </a>

            <div class="d-none d-lg-flex align-items-center gap-1">
                <a href="#features"     class="nav-link">Tính năng</a>
                <a href="#howitworks"   class="nav-link">Cách hoạt động</a>
                <a href="#pricing"      class="nav-link">Bảng giá</a>
                <a href="#testimonials" class="nav-link">Đánh giá</a>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="<?= APP_URL ?>/login"
                   class="btn btn-outline-light d-none d-md-inline-flex">
                    Đăng nhập
                </a>
                <a href="<?= APP_URL ?>/register" class="btn btn-primary">
                    Bắt đầu miễn phí
                    <i class="fa fa-arrow-right ms-1" style="font-size:11px;"></i>
                </a>
            </div>
        </div>
    </div>
</nav>


<!-- ════════════════════════════════════
     HERO
════════════════════════════════════ -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Miễn phí mãi mãi · Không cần thẻ tín dụng
                </div>

                <h1>
                    Theo dõi bug. <br>
                    Quản lý issue. <br>
                    <span class="accent">Đẹp & nhanh.</span>
                </h1>

                <p class="lead">
                    Bộ công cụ tracking issue đầy đủ cho team dev — kanban, sprint, báo cáo,
                    phân quyền — gói gọn trong giao diện sạch sẽ. Triển khai trong 5 phút.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= APP_URL ?>/register" class="btn-hero-primary">
                        <i class="fa fa-rocket"></i>
                        Dùng ngay miễn phí
                    </a>
                    <a href="#features" class="btn-hero-outline">
                        Xem tính năng
                        <i class="fa fa-arrow-right" style="font-size:12px;"></i>
                    </a>
                </div>

                <div class="hero-stats">
                    <div>
                        <div class="stat-num">500+</div>
                        <div class="stat-label">Người dùng</div>
                    </div>
                    <div>
                        <div class="stat-num">1,200+</div>
                        <div class="stat-label">Dự án</div>
                    </div>
                    <div>
                        <div class="stat-num">48k+</div>
                        <div class="stat-label">Bugs đã giải quyết</div>
                    </div>
                </div>
            </div>

            <!-- App mockup -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-mockup">
                    <div class="mockup-bar">
                        <div class="mockup-dot" style="background:#FF5F57;"></div>
                        <div class="mockup-dot" style="background:#FEBC2E;"></div>
                        <div class="mockup-dot" style="background:#28C840;"></div>
                        <span class="mockup-bar-title">BugTracker Pro · Dashboard</span>
                    </div>

                    <div class="mockup-body">
                    <?php
                    $mockIssues = [
                        ['BUG-042', 'Login form không validate email',     'Cao',     '#EF4444', '#FEF2F2', 'Open',     '#2563EB', '#EFF6FF'],
                        ['BUG-041', 'Kanban card không kéo thả được',      'Cao',     '#EF4444', '#FEF2F2', 'In Progress','#F97316', '#FFF7ED'],
                        ['BUG-040', 'Export CSV bị lỗi encoding UTF-8',    'TB',      '#EAB308', '#FEFCE8', 'Review',   '#8B5CF6', '#F5F3FF'],
                        ['FEA-015', 'Thêm tính năng dark mode',            'Thấp',    '#10B981', '#ECFDF5', 'Open',     '#2563EB', '#EFF6FF'],
                        ['BUG-039', 'Avatar upload > 2MB bị timeout',      'TB',      '#EAB308', '#FEFCE8', 'Resolved', '#10B981', '#ECFDF5'],
                    ];
                    foreach ($mockIssues as [$key, $title, $pri, $priFg, $priBg, $status, $stFg, $stBg]):
                    ?>
                    <div class="mockup-row">
                        <span class="mockup-key"><?= $key ?></span>
                        <span class="mockup-title"><?= $title ?></span>
                        <span class="mockup-badge" style="color:<?= $priFg ?>;background:<?= $priBg ?>;border-color:<?= $priFg ?>22;"><?= $pri ?></span>
                        <span class="mockup-badge" style="color:<?= $stFg ?>;background:<?= $stBg ?>;border-color:<?= $stFg ?>22;"><?= $status ?></span>
                    </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ════════════════════════════════════
     FEATURES
════════════════════════════════════ -->
<section class="features" id="features">
    <div class="container">
        <div class="text-center">
            <span class="section-label">Tính năng</span>
            <h2 class="section-title">Mọi thứ bạn cần để quản lý bug</h2>
            <p class="section-sub">
                Được thiết kế cho team nhỏ và dự án cá nhân —
                đầy đủ tính năng mà không cần trả phí.
            </p>
        </div>

        <?php
        $features = [
            ['fa-bolt',          '#2563EB', '#EFF6FF', 'Theo dõi realtime',      'Mọi thay đổi trên issue được ghi nhận tức thì vào activity log. Không bao giờ bỏ lỡ cập nhật.'],
            ['fa-table-columns', '#8B5CF6', '#F5F3FF', 'Kanban kéo thả',         'Trực quan hoá workflow với bảng kanban 5 cột. Cập nhật status không cần reload.'],
            ['fa-users-gear',    '#10B981', '#ECFDF5', 'Phân quyền 5 cấp',       'Admin, Manager, Developer, Reporter, Viewer. Kiểm soát ai được xem và làm gì.'],
            ['fa-chart-line',    '#F97316', '#FFF7ED', 'Báo cáo chi tiết',       'Bug trend, phân tích theo priority/status/type. Export CSV để chia sẻ với stakeholder.'],
            ['fa-bell',          '#EF4444', '#FEF2F2', 'Thông báo tức thì',      'Notification khi được giao bug, có comment mới hoặc issue sắp đến hạn.'],
            ['fa-flag-checkered','#0EA5E9', '#F0F9FF', 'Sprint & Milestone',     'Lập kế hoạch sprint, theo dõi burndown chart, quản lý milestone. Đủ dùng cho Agile.'],
        ];
        ?>
        <div class="row g-4">
            <?php foreach ($features as [$icon, $color, $bg, $title, $desc]): ?>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:<?= $bg ?>;color:<?= $color ?>;">
                        <i class="fa <?= $icon ?>"></i>
                    </div>
                    <h5><?= $title ?></h5>
                    <p><?= $desc ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════
     HOW IT WORKS
════════════════════════════════════ -->
<section class="how-it-works" id="howitworks">
    <div class="container">
        <div class="text-center">
            <span class="section-label">Bắt đầu</span>
            <h2 class="section-title">Bắt đầu trong 3 bước đơn giản</h2>
            <p class="section-sub">Không cần cài đặt phức tạp, không cần thẻ tín dụng.</p>
        </div>

        <div class="row align-items-center g-3">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <h5>Tạo tài khoản & workspace</h5>
                    <p>Đăng ký miễn phí trong 30 giây. Tạo workspace cho công ty hoặc team của bạn.</p>
                </div>
            </div>
            <div class="col-md-1 d-none d-md-flex step-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
            <div class="col-md-3">
                <div class="step-card">
                    <div class="step-num">2</div>
                    <h5>Tạo dự án & mời team</h5>
                    <p>Tạo dự án, gán role cho từng thành viên. Mời qua email — họ join trong 1 click.</p>
                </div>
            </div>
            <div class="col-md-1 d-none d-md-flex step-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
            <div class="col-md-3">
                <div class="step-card">
                    <div class="step-num">3</div>
                    <h5>Bắt đầu track bugs</h5>
                    <p>Tạo issue, giao việc, theo dõi trên kanban. Mọi thứ tập trung một chỗ.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════
     PRICING
════════════════════════════════════ -->
<section class="pricing" id="pricing">
    <div class="container">
        <div class="text-center">
            <span class="section-label">Bảng giá</span>
            <h2 class="section-title">Minh bạch, không có chi phí ẩn</h2>
            <p class="section-sub">Gói Free đủ dùng cho team nhỏ và dự án cá nhân mãi mãi.</p>
        </div>

        <?php
        $plans = [
            [
                'name'    => 'Free',
                'price'   => '0đ',
                'period'  => '/ mãi mãi',
                'featured'=> false,
                'badge'   => null,
                'btnText' => 'Bắt đầu miễn phí',
                'btnClass'=> 'btn-outline-success',
                'items'   => [
                    [true,  'Tối đa 5 người dùng'],
                    [true,  '3 dự án'],
                    [true,  '500MB storage'],
                    [true,  'Kanban Board'],
                    [true,  'Issue tracking đầy đủ'],
                    [false, 'Sprint management'],
                    [false, 'API access'],
                ],
            ],
            [
                'name'    => 'Pro',
                'price'   => 'Liên hệ',
                'period'  => '',
                'featured'=> true,
                'badge'   => 'Phổ biến nhất',
                'btnText' => 'Liên hệ tư vấn',
                'btnClass'=> 'btn-primary',
                'items'   => [
                    [true, 'Tối đa 25 người dùng'],
                    [true, 'Không giới hạn dự án'],
                    [true, '10GB storage'],
                    [true, 'Sprint & Milestone'],
                    [true, 'Báo cáo nâng cao'],
                    [true, 'API access'],
                    [true, 'Webhook integrations'],
                ],
            ],
            [
                'name'    => 'Enterprise',
                'price'   => 'Liên hệ',
                'period'  => '',
                'featured'=> false,
                'badge'   => null,
                'btnText' => 'Liên hệ tư vấn',
                'btnClass'=> 'btn-outline-secondary',
                'items'   => [
                    [true, 'Không giới hạn người dùng'],
                    [true, 'Không giới hạn dự án'],
                    [true, '100GB storage'],
                    [true, 'Custom workflow'],
                    [true, 'SSO / LDAP'],
                    [true, 'Dedicated support'],
                    [true, 'SLA 99.9% uptime'],
                ],
            ],
        ];
        ?>

        <div class="row g-4 justify-content-center">
            <?php foreach ($plans as $plan): ?>
            <div class="col-md-6 col-lg-4">
                <div class="pricing-card <?= $plan['featured'] ? 'featured' : '' ?>">
                    <?php if ($plan['badge']): ?>
                    <div class="pricing-badge"><?= $plan['badge'] ?></div>
                    <?php endif; ?>

                    <div class="pricing-name"><?= $plan['name'] ?></div>
                    <div class="pricing-price">
                        <?= $plan['price'] ?>
                        <span><?= $plan['period'] ?></span>
                    </div>

                    <ul class="pricing-list">
                        <?php foreach ($plan['items'] as [$enabled, $text]): ?>
                        <li class="<?= $enabled ? '' : 'disabled' ?>">
                            <?php if ($enabled): ?>
                            <i class="fa fa-check" style="color:#10B981;"></i>
                            <?php else: ?>
                            <i class="fa fa-xmark"></i>
                            <?php endif; ?>
                            <?= $text ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <a href="<?= APP_URL ?>/register" class="btn <?= $plan['btnClass'] ?>">
                        <?= $plan['btnText'] ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════
     TESTIMONIALS
════════════════════════════════════ -->
<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="text-center">
            <span class="section-label">Đánh giá</span>
            <h2 class="section-title">Người dùng nói gì về chúng tôi</h2>
            <p class="section-sub">Hơn 500 team đang dùng BugTracker Pro mỗi ngày.</p>
        </div>

        <?php
        $testimonials = [
            [
                'content' => 'BugTracker Pro giúp team mình quản lý bug rõ ràng hơn hẳn. Kanban board trực quan, dễ dùng. Quan trọng nhất là miễn phí và không bị giới hạn tính năng cơ bản.',
                'author'  => 'Nguyễn Văn Minh',
                'role'    => 'Tech Lead · Startup FinTech',
                'stars'   => 5,
            ],
            [
                'content' => 'Mình đã thử nhiều tool nhưng cái này phù hợp nhất cho team 5 người. Setup nhanh, giao diện Tiếng Việt, không mất thời gian training cho thành viên mới.',
                'author'  => 'Trần Thị Lan',
                'role'    => 'Project Manager · Agency',
                'stars'   => 5,
            ],
            [
                'content' => 'Phần phân quyền theo role rất hay — reporter chỉ tạo bug được, developer mới được sửa. Không còn tình trạng ai cũng vào xóa issue của nhau nữa.',
                'author'  => 'Lê Quốc Hùng',
                'role'    => 'Senior Developer · Outsource',
                'stars'   => 4,
            ],
        ];
        ?>

        <div class="row g-4">
            <?php foreach ($testimonials as $t): ?>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa fa-star <?= $i > $t['stars'] ? 'muted' : '' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p>&ldquo;<?= $t['content'] ?>&rdquo;</p>
                    <div class="author"><?= $t['author'] ?></div>
                    <div class="role"><?= $t['role'] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════
     CTA BANNER
════════════════════════════════════ -->
<section class="cta-banner">
    <div class="container">
        <h2>Sẵn sàng bắt đầu chưa?</h2>
        <p>Tạo tài khoản miễn phí ngay hôm nay. Không cần thẻ tín dụng, không có khoản phí ẩn.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?= APP_URL ?>/register" class="btn-hero-primary">
                <i class="fa fa-rocket"></i>
                Tạo tài khoản miễn phí
            </a>
            <a href="<?= APP_URL ?>/login" class="btn-hero-outline">
                Đăng nhập
            </a>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════
     FOOTER
════════════════════════════════════ -->
<footer class="lp-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a href="<?= APP_URL ?>/" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-3">
                    <span style="width:30px;height:30px;border-radius:8px;background:#2563EB;color:#fff;display:inline-flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-bug" style="font-size:13px;"></i>
                    </span>
                    <span style="color:#0F172A;font-size:16px;font-weight:700;">BugTracker Pro</span>
                </a>
                <p style="color:var(--lp-text-secondary);line-height:1.7;max-width:320px;">
                    Hệ thống quản lý bug & issue chuyên nghiệp, miễn phí mãi mãi.
                    Xây dựng bằng PHP 8.3, tối ưu cho hosting nhỏ.
                </p>
                <div class="mt-3">
                    <a href="#" class="social-icon"><i class="fab fa-github"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <h6>Sản phẩm</h6>
                <a href="#features">Tính năng</a>
                <a href="#pricing">Bảng giá</a>
                <a href="#howitworks">Cách hoạt động</a>
                <a href="<?= APP_URL ?>/register">Đăng ký</a>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <h6>Tài nguyên</h6>
                <a href="#">Tài liệu</a>
                <a href="#">Hướng dẫn</a>
                <a href="#">API Docs</a>
                <a href="#">Changelog</a>
            </div>

            <div class="col-lg-4 col-md-6">
                <h6>Liên hệ</h6>
                <a href="mailto:support@bugtracker.pro" style="margin-bottom:6px;">
                    <i class="fa fa-envelope me-2" style="color:#2563EB;"></i>support@bugtracker.pro
                </a>
                <a href="#"><i class="fa fa-globe me-2" style="color:#2563EB;"></i>bugtracker.pro</a>
            </div>
        </div>

        <hr class="divider">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2" style="font-size:12.5px;color:var(--lp-text-muted);">
            <div>&copy; <?= date('Y') ?> BugTracker Pro. Built with PHP 8.3 · Miễn phí mãi mãi</div>
            <div class="d-flex gap-3">
                <a href="#" style="display:inline;margin:0;">Chính sách bảo mật</a>
                <a href="#" style="display:inline;margin:0;">Điều khoản dịch vụ</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Subtle navbar shadow on scroll
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.lp-navbar');
    if (!navbar) return;
    if (window.scrollY > 8) {
        navbar.style.boxShadow = '0 1px 3px rgba(15,23,42,.06)';
    } else {
        navbar.style.boxShadow = 'none';
    }
});
</script>
</body>
</html>
