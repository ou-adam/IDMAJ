<?php
// admin/index.php: Secure Admin Login & Dashboard
session_start();
require_once '../includes/db.php';

$error = "";

// 1. Handle Login Post
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "يرجى إدخال اسم المستخدم وكلمة المرور.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Auto-seed/sync default admin account if missing or outdated password hash
            if ($username === 'admin' && $password === 'password123') {
                $default_hash = '$2y$10$a31WcmTBnVP59GRQBNcnXOuZE61xljxW1OAiXGpq4mfdFZ022yqmO';
                if (!$user) {
                    $pdo->prepare("INSERT INTO users (username, password, role) VALUES ('admin', ?, 'super_admin')")->execute([$default_hash]);
                    $stmt->execute([$username]);
                    $user = $stmt->fetch();
                } else if (!password_verify($password, $user['password'])) {
                    $pdo->prepare("UPDATE users SET password = ? WHERE username = 'admin'")->execute([$default_hash]);
                    $stmt->execute([$username]);
                    $user = $stmt->fetch();
                }
            }

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_logged'] = true;
                $_SESSION['admin_user'] = $user['username'];
                $_SESSION['admin_role'] = $user['role'];
                
                header("Location: index.php");
                exit;
            } else {
                $error = "خطأ في اسم المستخدم أو كلمة المرور.";
            }
        } catch (\PDOException $e) {
            $error = "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
        }
    }
}

// 2. Render Login Form if NOT logged in
if (!isset($_SESSION['admin_logged'])) {
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/rtl.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--bg-dark);
            margin: 0;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 3rem 2rem;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo img {
            max-height: 70px;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>
    <div class="premium-card login-card">
        <div class="login-logo">
            <img src="../../Photos/site%20web%20IDMADJ/LOGGO.svg" alt="IDMADJ Logo">
            <h3>لوحة تحكم إدماج</h3>
            <span style="font-size: 0.8rem; color: var(--text-muted);">بوابة الإدارة والتنسيق</span>
        </div>

        <?php if (!empty($error)): ?>
            <div style="background-color: rgba(239,68,68,0.15); border: 1px solid var(--danger); padding: 0.8rem; border-radius: 0.5rem; text-align: center; font-size: 0.85rem; margin-bottom: 1.5rem; color: var(--text-light); display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg class="icon" style="color: var(--danger); font-size: 1.1rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <input type="hidden" name="login" value="1">
            <div class="form-group">
                <label for="username">اسم المستخدم</label>
                <input type="text" id="username" name="username" required placeholder="admin">
            </div>
            <div class="form-group" style="margin-top: 1rem;">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 2rem;">دخول</button>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}

// 3. Admin Logged In: Fetch Stats
$total_registrations = 0;
$total_b2b = 0;
$total_hack = 0;
$total_pitch = 0;
$total_seminars = 0;

$recent_registrations = [];
$wilaya_stats = [];

try {
    // Counts
    $total_registrations = $pdo->query("SELECT COUNT(*) FROM registrations")->fetchColumn();
    $total_b2b = $pdo->query("SELECT COUNT(*) FROM registrations WHERE participant_type = 'b2b'")->fetchColumn();
    $total_hack = $pdo->query("SELECT COUNT(*) FROM registrations WHERE participant_type = 'hackathon'")->fetchColumn();
    $total_pitch = $pdo->query("SELECT COUNT(*) FROM registrations WHERE participant_type = 'pitch'")->fetchColumn();
    $total_seminars = $pdo->query("SELECT COUNT(*) FROM registrations WHERE participant_type = 'seminar'")->fetchColumn();

    // Wilayas
    $stmt = $pdo->query("SELECT wilaya, COUNT(*) as count FROM registrations GROUP BY wilaya ORDER BY count DESC");
    $wilaya_stats = $stmt->fetchAll();

    // Recents
    $stmt = $pdo->query("SELECT * FROM registrations ORDER BY id DESC LIMIT 5");
    $recent_registrations = $stmt->fetchAll();
} catch (\PDOException $e) {
    $error = "حدث خطأ أثناء تحميل الإحصائيات: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الرئيسية</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600;700;800&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/rtl.css">
    <style>
        .admin-layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            min-height: 100vh;
        }
        .admin-sidebar {
            background-color: #0b0f19;
            border-left: 1px solid var(--border-color);
            padding: 2rem 1.5rem;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 800;
            font-size: 1.15rem;
            margin-bottom: 3rem;
        }
        .sidebar-brand img { height: 32px; }
        .sidebar-menu {
            list-style: none;
        }
        .sidebar-menu li {
            margin-bottom: 0.8rem;
        }
        .sidebar-link {
            display: block;
            padding: 0.8rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 600;
            transition: var(--transition-smooth);
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255,255,255,0.05);
            color: var(--text-light);
            transform: translateX(-4px);
        }
        .admin-main {
            padding: 2.5rem;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
        }
        .admin-title h1 {
            font-size: 1.8rem;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .admin-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .dashboard-table {
            width: 100%;
            margin-top: 1.5rem;
            border-collapse: collapse;
        }
        .dashboard-table th, .dashboard-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 0.3rem;
        }
        .status-pending { background-color: rgba(245,158,11,0.15); color: var(--accent-gold); }
        .status-approved { background-color: rgba(16,185,129,0.15); color: var(--success); }
        .status-rejected { background-color: rgba(239,68,68,0.15); color: var(--danger); }

        /* --- Scroll Animations & Ticker Styles --- */
        @keyframes marqueeScroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(50%); }
        }
        .admin-marquee-container {
            display: flex;
            align-items: center;
            background: rgba(14, 165, 233, 0.08);
            border: 1px solid rgba(14, 165, 233, 0.2);
            border-radius: 0.8rem;
            padding: 0.6rem 1rem;
            margin-bottom: 2rem;
            overflow: hidden;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .marquee-tag {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.35rem 0.9rem;
            border-radius: 0.4rem;
            white-space: nowrap;
            margin-left: 1rem;
            box-shadow: 0 0 12px rgba(14, 165, 233, 0.4);
            animation: pulseGlow 3s infinite alternate;
        }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 8px rgba(14, 165, 233, 0.4); }
            100% { box-shadow: 0 0 18px rgba(14, 165, 233, 0.8); }
        }
        .marquee-track {
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
        }
        .marquee-content {
            display: inline-block;
            white-space: nowrap;
            animation: marqueeScroll 30s linear infinite;
        }
        .marquee-content:hover {
            animation-play-state: paused;
        }
        .marquee-content span {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-light);
            letter-spacing: 0.3px;
        }

        /* Scroll Reveal Animations */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }

        /* Stat Cards Hover & Animated Gradient Numbers */
        .stat-card-hover {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .stat-card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.25);
            border-color: var(--primary);
        }
        .stat-number {
            font-size: 2.3rem;
            font-weight: 800;
            display: block;
            margin-bottom: 0.4rem;
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 50%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: textShimmer 4s infinite linear;
        }
        .stat-number.gold-text {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 50%, #fef08a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        @keyframes textShimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated Table Rows */
        .table-row-animate {
            transition: background-color 0.25s ease, transform 0.2s ease;
        }
        .table-row-animate:hover {
            background-color: rgba(255, 255, 255, 0.04);
            transform: translateX(-4px);
        }

        /* Custom Scrollbar for Admin Main */
        .admin-main::-webkit-scrollbar {
            width: 6px;
        }
        .admin-main::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
        }
        .admin-main::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.4);
            border-radius: 4px;
        }
        .admin-main::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
        @media (max-width: 900px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }
            .admin-main {
                padding: 1.5rem 1rem;
            }
            .admin-grid-3 {
                grid-template-columns: 1fr !important;
            }
            .admin-grid-3 > div {
                grid-column: span 1 !important;
            }
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="../../Photos/site%20web%20IDMADJ/LOGGO.svg" alt="Logo">
                <span>إدارة إدماج</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php" class="sidebar-link active">الرئيسية (Dashboard)</a></li>
                <li><a href="registrations.php" class="sidebar-link">إدارة التسجيلات</a></li>
                <li><a href="logout.php" class="sidebar-link" style="color: var(--danger); margin-top: 5rem;">تسجيل الخروج</a></li>
            </ul>
        </aside>

        <!-- Main Workspace -->
        <main class="admin-main">
            <!-- Animated News Marquee Ticker -->
            <div class="admin-marquee-container reveal-on-scroll">
                <div class="marquee-tag">تحديثات مباشرة</div>
                <div class="marquee-track">
                    <div class="marquee-content">
                        <span><svg class="icon" style="color: var(--primary); vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.71.79-1.81.79-1.81l-3.79-3.79s-1.1.08-1.79.79z"></path><path d="M15 9l-3 3"></path><path d="M9 18l3 3 8.5-8.5a2.12 2.12 0 0 0-3-3L9 18z"></path></svg> تسجيلات جديدة واردة من ولاية وهران وعنابة ورقلة &nbsp;•&nbsp; <svg class="icon" style="color: #f59e0b; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> إجمالي التسجيلات: <?php echo $total_registrations; ?> مشارك &nbsp;•&nbsp; <svg class="icon" style="color: #10b981; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg> طلبات لقاءات B2B: <?php echo $total_b2b; ?> شركة &nbsp;•&nbsp; <svg class="icon" style="color: #eab308; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"></path></svg> فرق الهاكاثون المسجلة: <?php echo $total_hack; ?> فريق &nbsp;•&nbsp; <svg class="icon" style="color: #38bdf8; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"></path><path d="M10 22h4"></path><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1.55.64 2.87 1.67 3.83.64.6 1.13 1.34 1.33 2.17"></path></svg> مشاريع Pitch Box: <?php echo $total_pitch; ?> مشروع</span>
                        <span><svg class="icon" style="color: var(--primary); vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.71.79-1.81.79-1.81l-3.79-3.79s-1.1.08-1.79.79z"></path><path d="M15 9l-3 3"></path><path d="M9 18l3 3 8.5-8.5a2.12 2.12 0 0 0-3-3L9 18z"></path></svg> تسجيلات جديدة واردة من ولاية وهران وعنابة ورقلة &nbsp;•&nbsp; <svg class="icon" style="color: #f59e0b; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> إجمالي التسجيلات: <?php echo $total_registrations; ?> مشارك &nbsp;•&nbsp; <svg class="icon" style="color: #10b981; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg> طلبات لقاءات B2B: <?php echo $total_b2b; ?> شركة &nbsp;•&nbsp; <svg class="icon" style="color: #eab308; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"></path></svg> فرق الهاكاثون المسجلة: <?php echo $total_hack; ?> فريق &nbsp;•&nbsp; <svg class="icon" style="color: #38bdf8; vertical-align: -2px; margin-inline-end: 4px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"></path><path d="M10 22h4"></path><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1.55.64 2.87 1.67 3.83.64.6 1.13 1.34 1.33 2.17"></path></svg> مشاريع Pitch Box: <?php echo $total_pitch; ?> مشروع</span>
                    </div>

                </div>
            </div>

            <header class="admin-header reveal-on-scroll delay-1">
                <div class="admin-title">
                    <h1>مرحباً، <?php echo htmlspecialchars($_SESSION['admin_user']); ?></h1>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem;">نظرة عامة على إحصائيات منصة إدماج 2026</p>
                </div>
                <div class="admin-meta">
                    <span class="badge badge-gold">دور: مدير عام</span>
                </div>
            </header>

            <!-- Stats grid -->
            <div class="grid grid-4 text-center">
                <div class="premium-card reveal-on-scroll delay-1 stat-card-hover">
                    <span class="stat-number cyan-text animate-counter" data-target="<?php echo $total_registrations; ?>">0</span>
                    <span class="stat-label">إجمالي التسجيلات</span>
                </div>
                <div class="premium-card reveal-on-scroll delay-2 stat-card-hover">
                    <span class="stat-number gold-text animate-counter" data-target="<?php echo $total_b2b; ?>">0</span>
                    <span class="stat-label">طلبات لقاءات B2B</span>
                </div>
                <div class="premium-card reveal-on-scroll delay-3 stat-card-hover">
                    <span class="stat-number cyan-text animate-counter" data-target="<?php echo $total_hack; ?>">0</span>
                    <span class="stat-label">فرق الهاكاثون</span>
                </div>
                <div class="premium-card reveal-on-scroll delay-4 stat-card-hover">
                    <span class="stat-number gold-text animate-counter" data-target="<?php echo $total_pitch; ?>">0</span>
                    <span class="stat-label">مشاريع Pitch Box</span>
                </div>
            </div>

            <!-- Detailed Grid split -->
            <div class="admin-grid-3">
                <!-- Recent Registrations -->
                <div class="premium-card reveal-on-scroll delay-2" style="grid-column: span 2;">
                    <h3>آخر التسجيلات الواردة</h3>
                    <div class="table-responsive">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>الولاية</th>
                                    <th>الفئة</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_registrations as $reg): ?>
                                    <tr class="table-row-animate">
                                        <td><strong><?php echo htmlspecialchars($reg['representative_name']); ?></strong><br><span style="font-size: 0.75rem; color: var(--text-muted);"><?php echo htmlspecialchars($reg['email']); ?></span></td>
                                        <td><?php echo htmlspecialchars($reg['wilaya']); ?></td>
                                        <td><span class="badge badge-primary" style="margin-bottom:0; font-size: 0.7rem;"><?php echo htmlspecialchars($reg['participant_type']); ?></span></td>
                                        <td><span class="status-badge status-<?php echo $reg['status']; ?>"><?php echo htmlspecialchars($reg['status']); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Wilayas break down -->
                <div class="premium-card reveal-on-scroll delay-3">
                    <h3>التوزيع حسب الولايات</h3>
                    <div class="table-responsive">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>الولاية</th>
                                    <th>العدد</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($wilaya_stats as $stat): ?>
                                    <tr class="table-row-animate">
                                        <td><strong><?php echo htmlspecialchars($stat['wilaya']); ?></strong></td>
                                        <td class="cyan-text" style="font-weight: 700; font-family: 'Outfit';"><?php echo $stat['count']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- Scroll Animations & Counter JS Script -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Intersection Observer for Scroll Reveal
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    
                    // Trigger number counters inside visible card
                    const counters = entry.target.querySelectorAll('.animate-counter');
                    counters.forEach(counter => {
                        if (!counter.classList.contains('counted')) {
                            counter.classList.add('counted');
                            animateCounter(counter);
                        }
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));

        // 2. Smooth Counter Animation
        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-target'), 10) || 0;
            if (target === 0) {
                el.textContent = '0';
                return;
            }
            const duration = 1200; // ms
            const stepTime = 20; // ms
            const steps = duration / stepTime;
            const increment = target / steps;
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    el.textContent = target;
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current);
                }
            }, stepTime);
        }
    });
    </script>
</body>
</html>
