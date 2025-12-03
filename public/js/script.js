document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('name');
    const nameError = document.getElementById('nameError');
    const registerForm = document.getElementById('registerForm');

    // get validate URL from form data attribute
    const validateUrl = registerForm ? registerForm.dataset.validateUrl : '?c=register&a=validateName';
    console.log('Register validate URL:', validateUrl);

    if (nameInput) {
        nameInput.addEventListener('blur', function () {
            const val = nameInput.value.trim();
            console.log('Validating name via AJAX, val="' + val + '"');
            // send AJAX POST to register.validateName
            fetch(validateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ name: val })
            }).then(res => {
                console.log('Response status:', res.status);
                if (!res.ok) throw new Error('Network response was not ok: ' + res.status);
                return res.json();
            }).then(data => {
                console.log('Validation response data:', data);
                if (!data.valid) {
                    nameError.textContent = data.message || 'Chyba';
                    nameError.style.display = 'block';
                    nameInput.classList.add('is-invalid');
                } else {
                    nameError.textContent = '';
                    nameError.style.display = 'none';
                    nameInput.classList.remove('is-invalid');
                }
            }).catch(err => {
                console.error('Validation request failed', err);
                // fallback client-side check
                if (val === '') {
                    nameError.textContent = 'Meno je povinné.';
                    nameError.style.display = 'block';
                    nameInput.classList.add('is-invalid');
                }
            });
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            // prevent submit if name invalid
            if (nameInput && nameInput.value.trim() === '') {
                e.preventDefault();
                nameError.textContent = 'Meno je povinné.';
                nameError.style.display = 'block';
                nameInput.classList.add('is-invalid');
                nameInput.focus();
            }
        });
    }
});
