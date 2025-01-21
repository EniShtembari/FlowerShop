document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const firstName = document.querySelector('input[name="firstName"]');
    const lastName = document.querySelector('input[name="lastName"]');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    const confirmPassword = document.querySelector('input[name="confirmPassword"]');

    // Function to show error message
    function showError(input, message) {
        const inputGroup = input.parentElement;
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;

        // Remove any existing error message
        const existingError = inputGroup.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        inputGroup.appendChild(errorDiv);
        input.classList.add('error');
    }

    // Funksioni per te hequr errorin
    function removeError(input) {
        const inputGroup = input.parentElement;
        const errorDiv = inputGroup.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
        input.classList.remove('error');
    }

    // Validimi i emrit
    function validateName(input) {
        const nameRegex = /^[A-Za-z\s]{2,30}$/; //vetem shkronja, gjatesia e emrit nga 2-30
        return nameRegex.test(input.value.trim());
    }

    // validimi i email
    function validateEmail(input) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(input.value.trim());
    }

    // validimi i passswordit
    function validatePassword(input) {
        const passwordRegex = /^.{8,}$/; //te pakten 8 karaktere
        return passwordRegex.test(input.value);
    }

    firstName.addEventListener('input', function() {
        if (!validateName(this)) {
            showError(this, 'First name should contain only letters and be 2-30 characters long');
        } else {
            removeError(this);
        }
    });

    lastName.addEventListener('input', function() {
        if (!validateName(this)) {
            showError(this, 'Last name should contain only letters and be 2-30 characters long');
        } else {
            removeError(this);
        }
    });

    email.addEventListener('input', function() {
        if (!validateEmail(this)) {
            showError(this, 'Please enter a valid email address');
        } else {
            removeError(this);
        }
    });

    password.addEventListener('input', function() {
        if (!validatePassword(this)) {
            showError(this, 'Password must be at least 8 characters long');
        } else {
            removeError(this);
        }
    });

    confirmPassword.addEventListener('input', function() {
        if (this.value !== password.value) {
            showError(this, 'Passwords do not match');
        } else {
            removeError(this);
        }
    });

    // shtypja e ikones se syrit te beje passwordin te dukshem
    eyeIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.nextElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });

    // validimi i submit te formes
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // fshin erroret
        document.querySelectorAll('.error-message').forEach(error => error.remove());
        document.querySelectorAll('.error').forEach(input => input.classList.remove('error'));

        // validimi i emrit
        if (!validateName(firstName)) {
            showError(firstName, 'First name should contain only letters and be 2-30 characters long');
            isValid = false;
        }

        // validimi i mbiemrit
        if (!validateName(lastName)) {
            showError(lastName, 'Last name should contain only letters and be 2-30 characters long');
            isValid = false;
        }

        // validimi i email
        if (!validateEmail(email)) {
            showError(email, 'Please enter a valid email address');
            isValid = false;
        }

        // validimi i password
        if (!validatePassword(password)) {
            showError(password, 'Password must be at least 8 characters long');
            isValid = false;
        }

        // validimi i konfirmimit te passwordit
        if (confirmPassword.value !== password.value) {
            showError(confirmPassword, 'Passwords do not match');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});

