// Enhanced JavaScript for form validation and submission
document.addEventListener('DOMContentLoaded', function() {
    // Register service worker for PWA
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sahibalmunsaa/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful');
                })
                .catch(function(err) {
                    console.log('ServiceWorker registration failed');
                });
        });
    }
    const links = document.querySelectorAll('.link-button');
    links.forEach(link => {
        link.addEventListener('click', function() {
            alert('فتح ' + this.textContent + ' في تبويب جديد.');
        });
    });


    const form = document.getElementById('membership-form');
    const submitButton = form.querySelector('button[type="submit"]');

    // Validation functions
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        const re = /^(\+249|0)?[1-9]\d{8}$/;
        return re.test(phone.replace(/\s/g, ''));
    }

    function validateRequired(field) {
        return field.value.trim() !== '';
    }

    function showError(field, message) {
        let error = field.parentNode.querySelector('.error-message');
        if (!error) {
            error = document.createElement('span');
            error.className = 'error-message';
            error.style.color = 'red';
            error.style.fontSize = '0.9em';
            field.parentNode.appendChild(error);
        }
        error.textContent = message;
        field.style.borderColor = 'red';
    }

    function clearError(field) {
        let error = field.parentNode.querySelector('.error-message');
        if (error) {
            error.remove();
        }
        field.style.borderColor = '#ccc';
    }

    // Real-time validation on input
    form.querySelectorAll('input, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            if (field.hasAttribute('required') && !validateRequired(field)) {
                showError(field, 'هذا الحقل مطلوب.');
            } else if (field.type === 'email' && field.value && !validateEmail(field.value)) {
                showError(field, 'يرجى إدخال بريد إلكتروني صحيح.');
            } else if (field.type === 'tel' && field.value && !validatePhone(field.value)) {
                showError(field, 'يرجى إدخال رقم هاتف صحيح (10 أرقام).');
            } else {
                clearError(field);
            }
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let isValid = true;

        // Check all required fields
        form.querySelectorAll('[required]').forEach(field => {
            if (!validateRequired(field)) {
                showError(field, 'هذا الحقل مطلوب.');
                isValid = false;
            } else {
                clearError(field);
            }
        });

        // Check email if filled
        const emailField = form.querySelector('#email');
        if (emailField.value && !validateEmail(emailField.value)) {
            showError(emailField, 'يرجى إدخال بريد إلكتروني صحيح.');
            isValid = false;
        }

        // Check phone
        const phoneField = form.querySelector('#phone');
        if (!validatePhone(phoneField.value)) {
            showError(phoneField, 'يرجى إدخال رقم هاتف صحيح (10 أرقام).');
            isValid = false;
        }

        if (!isValid) {
            alert('يرجى تصحيح الأخطاء في الاستمارة قبل الإرسال.');
            return;
        }

        // Show loading state
        submitButton.disabled = true;
        submitButton.style.display = 'none';
        document.getElementById('loading-spinner').style.display = 'block';

        // Submit via AJAX
        fetch('submit.php', {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
                // Clear any errors
                form.querySelectorAll('.error-message').forEach(error => error.remove());
                form.querySelectorAll('input, textarea').forEach(field => field.style.borderColor = '#ccc');
            } else {
                alert('حدث خطأ: ' + (data.message || 'يرجى المحاولة مرة أخرى.'));
            }
        })
        .catch(error => {
            alert('حدث خطأ في الإرسال. يرجى المحاولة مرة أخرى.');
        })
        .finally(() => {
            // Reset button state
            submitButton.disabled = false;
            submitButton.style.display = 'block';
            submitButton.textContent = 'انضم الآن';
            submitButton.style.backgroundColor = '#28a745';
            document.getElementById('loading-spinner').style.display = 'none';
        });
    });
});