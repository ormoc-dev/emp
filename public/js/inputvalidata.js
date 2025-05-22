document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('rateForm');
    const rateInputs = document.querySelectorAll('.rate-input');

    function showError(input, message) {
        let errorSpan = input.nextElementSibling;

        if (!errorSpan || !errorSpan.classList.contains('error-message')) {
            errorSpan = document.createElement('span');
            errorSpan.className = 'error-message text-red-500 text-sm mt-1';
            input.parentNode.appendChild(errorSpan);
        }

        errorSpan.textContent = message;
        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500', 'text-red-500');
    }

    function clearError(input) {
        const errorSpan = input.nextElementSibling;

        if (errorSpan && errorSpan.classList.contains('error-message')) {
            input.parentNode.removeChild(errorSpan);
        }

        input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500', 'text-red-500');
    }

    function debounce(fn, delay) {
        let timeoutID;
        return function (...args) {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    function validateInput(input) {
        const minRate = parseFloat(input.getAttribute('min'));
        const maxRate = parseFloat(input.getAttribute('max'));
        const value = parseFloat(input.value);

        if (isNaN(value) || value < minRate || value > maxRate) {
            if (isNaN(value)) {
                showError(input, 'Please enter a valid number.');
            } else if (value < minRate) {
                showError(input, `Value cannot be less than ${minRate}.`);
            } else if (value > maxRate) {
                showError(input, `Value cannot be greater than ${maxRate}.`);
            }
        } else {
            clearError(input);
        }
    }

    rateInputs.forEach(function (input) {
        input.addEventListener('input', debounce(function () {
            validateInput(input);
        }, 300));  // 300ms debounce delay
    });

    form.addEventListener('submit', function (event) {
        let formIsValid = true;

        rateInputs.forEach(function (input) {
            validateInput(input);
            if (input.classList.contains('border-red-500')) {
                formIsValid = false;
            }
        });

        if (!formIsValid) {
            event.preventDefault();
            alert('Please correct the errors before submitting.');
        }
    });
});