<?php
// admin/registrations.php: View, Filter, Update, and Export Registrations
session_start();
require_once '../includes/db.php';

// 1. Enforce Admin Session
if (!isset($_SESSION['admin_logged'])) {
    header("Location: index.php");
    exit;
}

// 2. Handle Export to CSV Action
if (isset($_GET['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=idmadj_registrations_' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    // Send BOM for Excel compatibility with Arabic characters
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Headers
    fputcsv($output, ['معرف التسجيل', 'فئة المشارك', 'الاسم بالكامل', 'المنصب', 'اسم المؤسسة', 'الولاية', 'الهاتف', 'البريد الإلكتروني', 'الندوة الولائية', 'الحالة', 'تاريخ التسجيل']);
    
    $stmt = $pdo->query("SELECT reg_id, participant_type, representative_name, representative_title, organization_name, wilaya, phone, email, selected_seminar, status, created_at FROM registrations ORDER BY id DESC");
    while ($row = $stmt->fetch()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// 3. Handle Status Updates
$action_success = false;
$action_error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $reg_db_id = intval($_POST['reg_db_id']);
    $new_status = trim($_POST['new_status']);
    
    if ($reg_db_id > 0 && in_array($new_status, ['pending', 'approved', 'rejected', 'info_needed'])) {
        try {
            $stmt = $pdo->prepare("UPDATE registrations SET status = ? WHERE id = ?");
            $stmt->execute([$new_status, $reg_db_id]);
            $action_success = true;
        } catch (\PDOException $e) {
            $action_error = "حدث خطأ أثناء تعديل الحالة: " . $e->getMessage();
        }
    }
}

// 4. Handle Filters and Queries
$filter_type = $_GET['filter_type'] ?? '';
$filter_status = $_GET['filter_status'] ?? '';
$search_query = $_GET['search_query'] ?? '';

$sql = "SELECT * FROM registrations WHERE 1=1";
$params = [];

if (!empty($filter_type)) {
    $sql .= " AND participant_type = ?";
    $params[] = $filter_type;
}
if (!empty($filter_status)) {
    $sql .= " AND status = ?";
    $params[] = $filter_status;
}
if (!empty($search_query)) {
    $sql .= " AND (representative_name LIKE ? OR organization_name LIKE ? OR email LIKE ? OR phone LIKE ? OR reg_id LIKE ?)";
    $search_param = "%$search_query%";
    $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param, $search_param]);
}

$sql .= " ORDER BY id DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $registrations = $stmt->fetchAll();
} catch (\PDOException $e) {
    $action_error = "حدث خطأ في قاعدة البيانات: " . $e->getMessage();
    $registrations = [];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة التسجيلات</title>
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
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255,255,255,0.05);
            color: var(--text-light);
        }
        .admin-main {
            padding: 3rem;
            overflow-y: auto;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
        }
        .admin-title h1 { font-size: 1.8rem; }
        
        /* Filters style */
        .filters-panel {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .filters-form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .filters-form .form-group {
            margin-bottom: 0;
            flex-grow: 1;
            min-width: 150px;
        }
        .filters-form select, .filters-form input {
            background-color: rgba(15,23,42,0.8);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            padding: 0.6rem 0.8rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            width: 100%;
        }

        /* Table styles */
        .registrations-table-wrapper {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            overflow: hidden;
            margin-top: 1.5rem;
        }
        .registrations-table {
            width: 100%;
            border-collapse: collapse;
        }
        .registrations-table th, .registrations-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
            vertical-align: middle;
        }
        .registrations-table th {
            background-color: rgba(255,255,255,0.02);
            color: var(--primary);
            font-weight: 700;
        }
        .registrations-table tr:hover td {
            background-color: rgba(255,255,255,0.01);
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
        .status-info_needed { background-color: rgba(99,102,241,0.15); color: var(--secondary); }

        .reg-actions-form {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .reg-actions-form select {
            background-color: #0f172a;
            border: 1px solid var(--border-color);
            color: var(--text-light);
            padding: 0.3rem 0.5rem;
            border-radius: 0.3rem;
            font-size: 0.75rem;
        }
        .action-btn-sm {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
            border-radius: 0.3rem;
        }
        .file-link {
            display: inline-block;
            font-size: 0.75rem;
            color: var(--primary);
            margin-left: 0.5rem;
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }
            .admin-main {
                padding: 1.5rem 1rem;
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
                <li><a href="index.php" class="sidebar-link">الرئيسية (Dashboard)</a></li>
                <li><a href="registrations.php" class="sidebar-link active">إدارة التسجيلات</a></li>
                <li><a href="logout.php" class="sidebar-link" style="color: var(--danger); margin-top: 5rem;">تسجيل الخروج</a></li>
            </ul>
        </aside>

        <!-- Main Workspace -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="admin-title">
                    <h1>إدارة طلبات التسجيل</h1>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem;">مراجعة، تصفية، وقبول المشاركين في الفعاليات والندوات الجهوية</p>
                </div>
                <div class="admin-actions">
                    <a href="registrations.php?export=1" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.85rem;">تصدير القائمة إلى CSV</a>
                </div>
            </header>

            <?php if ($action_success): ?>
                <div style="background-color: rgba(16,185,129,0.15); border: 1px solid var(--success); padding: 0.8rem; border-radius: 0.5rem; font-size: 0.85rem; margin-bottom: 1.5rem; color: var(--text-light); text-align: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -3px; margin-left: 6px; color: var(--success);"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> تم تحديث حالة الطلب بنجاح!
                </div>
            <?php endif; ?>

            <!-- Filter Panel -->
            <div class="filters-panel">
                <form action="registrations.php" method="GET" class="filters-form">
                    <div class="form-group">
                        <label for="filter_type" style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 0.3rem;">حسب الفئة</label>
                        <select id="filter_type" name="filter_type">
                            <option value="">-- كل الفئات --</option>
                            <option value="corporate" <?php echo ($filter_type == 'corporate') ? 'selected' : ''; ?>>فرصة مناولة</option>
                            <option value="seminar" <?php echo ($filter_type == 'seminar') ? 'selected' : ''; ?>>الندوات الجهوية</option>
                            <option value="expert" <?php echo ($filter_type == 'expert') ? 'selected' : ''; ?>>خبير / محاضر</option>
                            <option value="media" <?php echo ($filter_type == 'media') ? 'selected' : ''; ?>>إعلامي</option>
                            <option value="sponsor" <?php echo ($filter_type == 'sponsor') ? 'selected' : ''; ?>>راعٍ وممول</option>
                            <option value="b2b" <?php echo ($filter_type == 'b2b') ? 'selected' : ''; ?>>جلسات B2B</option>
                            <option value="hackathon" <?php echo ($filter_type == 'hackathon') ? 'selected' : ''; ?>>الهاكاثون</option>
                            <option value="pitch" <?php echo ($filter_type == 'pitch') ? 'selected' : ''; ?>>مسابقة Pitch Box</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="filter_status" style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 0.3rem;">حسب الحالة</label>
                        <select id="filter_status" name="filter_status">
                            <option value="">-- كل الحالات --</option>
                            <option value="pending" <?php echo ($filter_status == 'pending') ? 'selected' : ''; ?>>قيد الانتظار (Pending)</option>
                            <option value="approved" <?php echo ($filter_status == 'approved') ? 'selected' : ''; ?>>مقبول (Approved)</option>
                            <option value="rejected" <?php echo ($filter_status == 'rejected') ? 'selected' : ''; ?>>مرفوض (Rejected)</option>
                            <option value="info_needed" <?php echo ($filter_status == 'info_needed') ? 'selected' : ''; ?>>ناقص المعلومات</option>
                        </select>
                    </div>

                    <div class="form-group" style="flex-grow: 2;">
                        <label for="search_query" style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 0.3rem;">بحث سريع (اسم، بريد، هاتف، رمز)</label>
                        <input type="text" id="search_query" name="search_query" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="مثال: أحمد، IDMAJ-2026...">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-secondary" style="padding: 0.6rem 1.5rem; font-size: 0.85rem;">تصفية وبحث</button>
                    </div>
                </form>
            </div>

            <!-- Registrations Table -->
            <div class="registrations-table-wrapper table-responsive">
                <table class="registrations-table">
                    <thead>
                        <tr>
                            <th>الرمز</th>
                            <th>المشارك / الكيان</th>
                            <th>معلومات الاتصال</th>
                            <th>الفئة</th>
                            <th>الملفات</th>
                            <th>الحالة</th>
                            <th>تعديل الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($registrations)): ?>
                            <tr>
                                <td colspan="7" class="text-center" style="padding: 3rem; color: var(--text-muted);">
                                    لا توجد تسجيلات مطابقة لمعايير البحث الحالية.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($registrations as $reg): ?>
                                <tr>
                                    <td><strong class="cyan-text" style="font-family: 'Outfit';"><?php echo htmlspecialchars($reg['reg_id']); ?></strong></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($reg['representative_name']); ?></strong><br>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">
                                            <?php echo htmlspecialchars($reg['organization_name'] ?: 'مشارك فردي'); ?> 
                                            <?php echo htmlspecialchars($reg['representative_title'] ? '('.$reg['representative_title'].')' : ''); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <svg class="icon" style="color: var(--primary);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?php echo htmlspecialchars($reg['wilaya']); ?><br>
                                        <svg class="icon" style="color: var(--primary);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> <?php echo htmlspecialchars($reg['email']); ?><br>
                                        <svg class="icon" style="color: var(--primary);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> <?php echo htmlspecialchars($reg['phone']); ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary" style="margin-bottom:0; font-size: 0.7rem;">
                                            <?php echo htmlspecialchars($reg['participant_type']); ?>
                                        </span>
                                        <?php if (!empty($reg['selected_seminar'])): ?>
                                            <br>
                                            <span style="font-size: 0.75rem; color: var(--accent-gold); font-weight: 600; display: inline-block; margin-top: 0.3rem;">
                                                <?php echo htmlspecialchars($reg['selected_seminar']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($reg['personal_photo'])): ?>
                                            <a href="../<?php echo htmlspecialchars($reg['personal_photo']); ?>" target="_blank" class="file-link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> صورة</a>
                                        <?php endif; ?>
                                        <?php if (!empty($reg['company_logo'])): ?>
                                            <a href="../<?php echo htmlspecialchars($reg['company_logo']); ?>" target="_blank" class="file-link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.18 21.18l-18-18A2 2 0 0 0 2 4.58V19a2 2 0 0 0 2 2h14.42a2 2 0 0 0 1.76-1.82z"></path><line x1="7" y1="21" x2="7" y2="18"></line><line x1="12" y1="21" x2="12" y2="15"></line><line x1="17" y1="21" x2="17" y2="12"></line><line x1="2" y1="14" x2="5" y2="14"></line><line x1="2" y1="9" x2="8" y2="9"></line></svg> شعار</a>
                                        <?php endif; ?>
                                        <?php if (!empty($reg['company_profile_pdf'])): ?>
                                            <a href="../<?php echo htmlspecialchars($reg['company_profile_pdf']); ?>" target="_blank" class="file-link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> ملف PDF</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $reg['status']; ?>">
                                            <?php echo htmlspecialchars($reg['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="registrations.php?filter_type=<?php echo urlencode($filter_type); ?>&filter_status=<?php echo urlencode($filter_status); ?>&search_query=<?php echo urlencode($search_query); ?>" method="POST" class="reg-actions-form">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="reg_db_id" value="<?php echo $reg['id']; ?>">
                                            <select name="new_status" aria-label="Status">
                                                <option value="pending" <?php echo ($reg['status'] == 'pending') ? 'selected' : ''; ?>>انتظار</option>
                                                <option value="approved" <?php echo ($reg['status'] == 'approved') ? 'selected' : ''; ?>>قبول</option>
                                                <option value="rejected" <?php echo ($reg['status'] == 'rejected') ? 'selected' : ''; ?>>رفض</option>
                                                <option value="info_needed" <?php echo ($reg['status'] == 'info_needed') ? 'selected' : ''; ?>>نواقص</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary action-btn-sm">حفظ</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</body>
</html>
