<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أنت صاحب المنصة</title>
    <meta name="description" content="منصة لإدارة مجتمعك وتطوير مهاراتك في السودان">
    <meta name="keywords" content="منصة, مجتمع, تطوير, سودان">
    <meta name="author" content="أنت صاحب المنصة">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#007bff">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "أنت صاحب المنصة",
      "description": "منصة لإدارة مجتمعك وتطوير مهاراتك في السودان",
      "url": "https://sahibalmunsaa.com",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+249-119484931",
        "contactType": "customer service"
      }
    }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">أنت صاحب المنصة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">لوحة الإدارة</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header>
        <h1>أنت صاحب المنصة</h1>
        <p>مرحباً بك في موقع إدارة منصتك.</p>
    </header>

    <section id="about">
        <h2>حول المنصة</h2>
        <p>تم تصميم هذه المنصة لكي تمتلك وتدير وجودك عبر الإنترنت. تواصل مع جمهورك من خلال قنوات متنوعة.</p>
    </section>

    <section id="links">
        <h2>تواصل معنا</h2>
        <div class="link-container">
            <a href="https://cute-faloodeh-4d4226.netlify.app/" target="_blank" class="link-button">زور موقعنا</a>
            <a href="https://www.youtube.com/@OwnThePlatform" target="_blank" class="link-button">قناة يوتيوب</a>
            <a href="https://tiktok.com/@youownerplatform" target="_blank" class="link-button">صفحة تيك توك</a>
            <a href="https://www.facebook.com/share/1CkQRaaNB9/" target="_blank" class="link-button">صفحة فيسبوك</a>
            <a href="https://chat.whatsapp.com/Ifz8Q0Rxpnm0jwbKm9hTTz?mode=wwc" target="_blank" class="link-button">مجتمع واتساب</a>
        </div>
    </section>

    <section id="form">
        <h2>استمارة العضوية</h2>
        <form id="membership-form" action="submit.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <fieldset>
                <legend>المعلومات الشخصية</legend>
                <label for="name">الاسم الكامل:</label>
                <input type="text" id="name" name="name" required aria-describedby="name-help"><br>
                <small id="name-help" class="form-text text-muted">أدخل اسمك الكامل</small>

                <label for="age">العمر:</label>
                <input type="number" id="age" name="age" required aria-describedby="age-help"><br>
                <small id="age-help" class="form-text text-muted">أدخل عمرك بالسنوات</small>

                <label>الجنس:</label>
                <input type="radio" id="male" name="gender" value="ذكر" required aria-describedby="gender-help">
                <label for="male">ذكر</label>
                <input type="radio" id="female" name="gender" value="أنثى" required>
                <label for="female">أنثى</label><br>
                <small id="gender-help" class="form-text text-muted">اختر جنسك</small>

                <label for="city">المدينة / القرية:</label>
                <input type="text" id="city" name="city" required aria-describedby="city-help"><br>
                <small id="city-help" class="form-text text-muted">أدخل مدينتك أو قريتك</small>

                <label for="phone">رقم الهاتف / واتساب:</label>
                <input type="tel" id="phone" name="phone" required aria-describedby="phone-help"><br>
                <small id="phone-help" class="form-text text-muted">أدخل رقم هاتفك</small>

                <label for="email">البريد الإلكتروني (اختياري):</label>
                <input type="email" id="email" name="email" aria-describedby="email-help"><br>
                <small id="email-help" class="form-text text-muted">أدخل بريدك الإلكتروني إذا أردت</small>
            </fieldset>

            <fieldset>
                <legend>المهارات والمجالات التي تهتم بها</legend>
                <input type="checkbox" id="self-dev" name="interests" value="تطوير الذات">
                <label for="self-dev">تطوير الذات</label><br>
                <input type="checkbox" id="teamwork" name="interests" value="العمل الجماعي">
                <label for="teamwork">العمل الجماعي</label><br>
                <input type="checkbox" id="health" name="interests" value="التوعية الصحية">
                <label for="health">التوعية الصحية</label><br>
                <input type="checkbox" id="environment" name="interests" value="المحافظة على البيئة">
                <label for="environment">المحافظة على البيئة</label><br>
                <input type="checkbox" id="media" name="interests" value="الإعلام والميديا">
                <label for="media">الإعلام والميديا</label><br>
                <input type="checkbox" id="tech" name="interests" value="التصميم / البرمجة / التقنية">
                <label for="tech">التصميم / البرمجة / التقنية</label><br>
                <input type="checkbox" id="culture" name="interests" value="الثقافة والفكر">
                <label for="culture">الثقافة والفكر</label><br>
                <label for="other">أخرى:</label>
                <input type="text" id="other" name="other"><br>
            </fieldset>

            <fieldset>
                <legend>دوافعك للانضمام</legend>
                <label for="motivation">لماذا تريد أن تكون جزءاً من مجتمع "أنت صاحب المنصة"؟ ما الذي يلهمك في فكرة المنصة؟</label>
                <textarea id="motivation" name="motivation" required></textarea><br>
            </fieldset>

            <fieldset>
                <legend>التزامك المجتمعي</legend>
                <label>هل تستطيع تأسيس مجتمع محلي في منطقتك؟</label>
                <input type="radio" id="yes-local" name="local" value="نعم" required>
                <label for="yes-local">نعم</label>
                <input type="radio" id="no-local" name="local" value="لا" required>
                <label for="no-local">لا</label><br>
                <label for="area">إذا كانت الإجابة نعم، ما اسم المنطقة؟</label>
                <input type="text" id="area" name="area"><br>

                <label>كم ساعة أسبوعياً يمكنك تخصيصها للمنصة؟</label>
                <input type="radio" id="less5" name="hours" value="أقل من 5 ساعات" required>
                <label for="less5">أقل من 5 ساعات</label>
                <input type="radio" id="5-10" name="hours" value="5–10 ساعات" required>
                <label for="5-10">5–10 ساعات</label>
                <input type="radio" id="more10" name="hours" value="أكثر من 10 ساعات" required>
                <label for="more10">أكثر من 10 ساعات</label><br>
            </fieldset>

            <fieldset>
                <legend>رؤيتك الشخصية</legend>
                <label for="vision">كيف ترى دورك في بناء سودان جديد؟</label>
                <textarea id="vision" name="vision" required></textarea><br>

                <label>هل تلتزم بقيم المنصة: القوة، العزيمة، الإصرار، الإنسانية؟</label>
                <input type="radio" id="commit-yes" name="commit" value="نعم، ألتزم تماماً" required>
                <label for="commit-yes">نعم، ألتزم تماماً</label>
                <input type="radio" id="commit-no" name="commit" value="أحتاج توضيح أكثر" required>
                <label for="commit-no">أحتاج توضيح أكثر</label><br>
            </fieldset>

            <div id="loading-spinner" style="display: none; text-align: center; margin: 20px;">
                <div style="border: 4px solid #f3f3f3; border-top: 4px solid #007bff; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                <p>جاري الإرسال...</p>
            </div>
            <button type="submit">انضم الآن</button>
        </form>
    </section>

    <section id="contact">
        <h2>اتصل بنا</h2>
        <p>البريد الإلكتروني: <a href="mailto:antsahibalmnusaa@gmail.com">antsahibalmnusaa@gmail.com</a></p>
        <p>الهاتف: <a href="tel:0119484931">0119484931</a></p>
    </section>

    <footer>
        <p>&copy; 2023 أنت صاحب المنصة. جميع الحقوق محفوظة.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
        // Dark mode toggle
        const darkModeToggle = document.createElement('button');
        darkModeToggle.innerHTML = '🌙';
        darkModeToggle.className = 'btn btn-outline-secondary position-fixed';
        darkModeToggle.style.cssText = 'top: 10px; left: 10px; z-index: 1000;';
        darkModeToggle.onclick = function() {
            document.body.classList.toggle('dark-mode');
            this.innerHTML = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        };
        document.body.appendChild(darkModeToggle);

        // Load dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '☀️';
        }
    </script>
</body>
</html>