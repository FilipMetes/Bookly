document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('.form-signin');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    const usernameError = document.createElement('div');
    usernameError.style.color = 'red';
    usernameError.style.fontSize = '0.875rem';
    usernameInput.parentNode.appendChild(usernameError);

    const passwordError = document.createElement('div');
    passwordError.style.color = 'red';
    passwordError.style.fontSize = '0.875rem';
    passwordInput.parentNode.appendChild(passwordError);

    loginForm.addEventListener('submit', function (e) {
        let valid = true;

        if (usernameInput.value.trim() === '') {
            usernameError.textContent = 'E-mail je povinný.';
            valid = false;
        } else {
            usernameError.textContent = '';
        }

        if (passwordInput.value.trim() === '') {
            passwordError.textContent = 'Heslo je povinné.';
            valid = false;
        } else {
            passwordError.textContent = '';
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});