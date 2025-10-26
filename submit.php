<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database config
require 'config.php';

// Start session for CSRF
session_start();

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// SQL to create table (run this in phpMyAdmin or MySQL console)
// CREATE TABLE submissions (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(255) NOT NULL,
//     age INT NOT NULL,
//     gender VARCHAR(10) NOT NULL,
//     city VARCHAR(255) NOT NULL,
//     phone VARCHAR(20) NOT NULL,
//     email VARCHAR(255),
//     interests TEXT,
//     motivation TEXT NOT NULL,
//     local VARCHAR(10) NOT NULL,
//     area VARCHAR(255),
//     hours VARCHAR(50) NOT NULL,
//     vision TEXT NOT NULL,
//     commit VARCHAR(50) NOT NULL,
//     timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// );

// Handle AJAX requests
header('Content-Type: application/json');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = trim($_POST['name'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $city = trim($_POST['city'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $interests = $_POST['interests'] ?? [];
    $other = trim($_POST['other'] ?? '');
    $motivation = trim($_POST['motivation'] ?? '');
    $local = $_POST['local'] ?? '';
    $area = trim($_POST['area'] ?? '');
    $hours = $_POST['hours'] ?? '';
    $vision = trim($_POST['vision'] ?? '');
    $commit = $_POST['commit'] ?? '';

    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = 'الاسم الكامل مطلوب.';
    if (empty($age) || !is_numeric($age) || $age < 1 || $age > 120) $errors[] = 'العمر مطلوب ويجب أن يكون رقماً صحيحاً.';
    if (empty($gender)) $errors[] = 'الجنس مطلوب.';
    if (empty($city)) $errors[] = 'المدينة / القرية مطلوبة.';
    if (empty($phone) || !preg_match('/^(\+249|0)?[1-9]\d{8}$/', str_replace(' ', '', $phone))) {
        $errors[] = 'رقم الهاتف مطلوب ويجب أن يكون صحيحاً (10 أرقام).';
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'البريد الإلكتروني غير صحيح.';
    }
    if (empty($motivation)) $errors[] = 'دوافع الانضمام مطلوبة.';
    if (empty($local)) $errors[] = 'الإجابة عن تأسيس مجتمع محلي مطلوبة.';
    if (empty($hours)) $errors[] = 'عدد الساعات الأسبوعية مطلوب.';
    if (empty($vision)) $errors[] = 'الرؤية الشخصية مطلوبة.';
    if (empty($commit)) $errors[] = 'التزام القيم مطلوب.';

    // Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = 'خطأ في التحقق من الأمان.';
    }

    // If no errors, process the data
    if (empty($errors)) {
        // Prepare data for database
        $interests_str = implode(', ', $interests) . ($other ? ', ' . $other : '');

        try {
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO submissions (name, age, gender, city, phone, email, interests, motivation, local, area, hours, vision, commit) VALUES (:name, :age, :gender, :city, :phone, :email, :interests, :motivation, :local, :area, :hours, :vision, :commit)");
            $stmt->execute([
                ':name' => $name,
                ':age' => $age,
                ':gender' => $gender,
                ':city' => $city,
                ':phone' => $phone,
                ':email' => $email,
                ':interests' => $interests_str,
                ':motivation' => $motivation,
                ':local' => $local,
                ':area' => $area,
                ':hours' => $hours,
                ':vision' => $vision,
                ':commit' => $commit
            ]);

            // Send confirmation email using PHPMailer (install via composer: composer require phpmailer/phpmailer)
            require 'vendor/autoload.php'; // If using Composer
            // For now, use basic mail
            $to = 'antsahibalmnusaa@gmail.com';
            $subject = 'طلب عضوية جديد من ' . $name;
            $message = "تم استلام طلب عضوية جديد:\n\nName: $name\nAge: $age\nGender: $gender\nCity: $city\nPhone: $phone\nEmail: $email\nInterests: $interests_str\nMotivation: $motivation\nLocal: $local\nArea: $area\nHours: $hours\nVision: $vision\nCommit: $commit";
            $headers = 'From: noreply@yourplatform.com' . "\r\n" .
                       'Reply-To: ' . $email . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();
            mail($to, $subject, $message, $headers);

            // Return success response
            echo json_encode(['success' => true, 'message' => 'تم إرسال الاستمارة بنجاح! سيتم التواصل معك قريباً.']);
            exit;
        } catch(PDOException $e) {
            $errors[] = 'حدث خطأ في حفظ البيانات: ' . $e->getMessage();
        }
    }
}

// If errors or not POST, redirect back
if (!empty($errors) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error_string = urlencode(implode(', ', $errors));
    header('Location: index.html?error=' . $error_string);
    exit;
}
?>