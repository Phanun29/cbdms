function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.getElementById('togglePasswordIcon');
    var showPasswordButton = document.getElementById('showPasswordButton');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

function checkPasswordInput() {
    var passwordInput = document.getElementById('password');
    var showPasswordButton = document.getElementById('showPasswordButton');

    // Show/hide the button based on the input field's value
    if (passwordInput.value.length > 0) {
        showPasswordButton.classList.remove('hidden');
    } else {
        showPasswordButton.classList.add('hidden');
    }
}

// Attach the input event listener to the password field
document.getElementById('password').addEventListener('input', checkPasswordInput);

// Initialize button visibility based on current input value
checkPasswordInput();