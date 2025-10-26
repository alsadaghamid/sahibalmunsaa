<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database config
require 'config.php';

// Fetch submissions
try {
    $stmt = $conn->query("SELECT * FROM submissions ORDER BY timestamp DESC");
    $submissions = $stmt->fetchAll();
} catch(PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - أنت صاحب المنصة</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .admin-header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .submission-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .submission-table th, .submission-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: right;
        }
        .submission-table th {
            background-color: #007bff;
            color: white;
        }
        .export-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }
        .export-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <nav style="background-color: #007bff; padding: 10px 0;">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <a href="index.php" style="color: white; text-decoration: none; margin: 0 20px; font-weight: bold;">الرئيسية</a>
            <a href="admin.php" style="color: white; text-decoration: none; margin: 0 20px;">لوحة الإدارة</a>
        </div>
    </nav>
    <div class="admin-header">
        <h1>لوحة الإدارة</h1>
        <p>عرض طلبات العضوية</p>
        <button class="export-btn" onclick="exportToCSV()">تصدير إلى CSV</button>
        <a href="index.php" class="export-btn">العودة إلى الموقع</a>
    </div>

    <section style="padding: 20px;">
        <h2>طلبات العضوية (<?php echo count($submissions); ?>)</h2>
        <?php if (count($submissions) > 0): ?>
            <table class="submission-table">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>العمر</th>
                        <th>الجنس</th>
                        <th>المدينة</th>
                        <th>الهاتف</th>
                        <th>البريد الإلكتروني</th>
                        <th>المهارات</th>
                        <th>الدوافع</th>
                        <th>المجتمع المحلي</th>
                        <th>الساعات الأسبوعية</th>
                        <th>الرؤية</th>
                        <th>الالتزام</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($submission['name']); ?></td>
                            <td><?php echo htmlspecialchars($submission['age']); ?></td>
                            <td><?php echo htmlspecialchars($submission['gender']); ?></td>
                            <td><?php echo htmlspecialchars($submission['city']); ?></td>
                            <td><?php echo htmlspecialchars($submission['phone']); ?></td>
                            <td><?php echo htmlspecialchars($submission['email']); ?></td>
                            <td><?php echo htmlspecialchars($submission['interests']); ?></td>
                            <td><?php echo htmlspecialchars($submission['motivation']); ?></td>
                            <td><?php echo htmlspecialchars($submission['local']); ?></td>
                            <td><?php echo htmlspecialchars($submission['hours']); ?></td>
                            <td><?php echo htmlspecialchars($submission['vision']); ?></td>
                            <td><?php echo htmlspecialchars($submission['commit']); ?></td>
                            <td><?php echo htmlspecialchars($submission['timestamp']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>لا توجد طلبات عضوية حتى الآن.</p>
        <?php endif; ?>
    </section>

    <script>
        function exportToCSV() {
            const table = document.querySelector('.submission-table');
            let csv = 'Name,Age,Gender,City,Phone,Email,Interests,Motivation,Local,Hours,Vision,Commit,Timestamp\n';
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = Array.from(cells).map(cell => cell.textContent.replace(/,/g, ';')).join(',');
                csv += rowData + '\n';
            });
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'submissions.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>