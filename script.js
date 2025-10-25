// Simple JavaScript for interactivity
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.link-button');
    links.forEach(link => {
        link.addEventListener('click', function() {
            alert('فتح ' + this.textContent + ' في تبويب جديد.');
        });
    });

    const form = document.getElementById('membership-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Submit the form to Formspree
        fetch('https://formspree.io/f/alsadaghamid@gmail.com', {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                alert('تم إرسال الاستمارة بنجاح! سيتم التواصل معك قريباً.');
                form.reset();
            } else {
                alert('حدث خطأ في الإرسال. يرجى المحاولة مرة أخرى.');
            }
        }).catch(error => {
            alert('حدث خطأ في الإرسال. يرجى المحاولة مرة أخرى.');
        });
    });
});