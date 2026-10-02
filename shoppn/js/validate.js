// validation of forms client-side form validation with regex 

document.addEventListener('DOMContentLoaded', function () {

    // Grab the form itself by its id
    const form = document.getElementById('register-form');

  
    // ^ = start of string, $ = end of string 
    // "the input must match this shape," not just part of it.
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9+\-\s]{7,15}$/;

    // Runs every time the form is about to be submitted.
    form.addEventListener('submit', function (event) {

        // Tracks whether ANY field failed, across all checks below.
        let isValid = true;

        //  Clear old error messages first 
    
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        // --- Name check ---
        const name = document.getElementById('name').value.trim();
        if (name === '') {
            document.getElementById('name-error').textContent = 'Name is required.';
            isValid = false;
        }

        // --- Email check ---
        const email = document.getElementById('email').value.trim();
        if (!emailRegex.test(email)) {
            // .test() returns true/false — checks if string match the pattern
            document.getElementById('email-error').textContent = 'Enter a valid email address.';
            isValid = false;
        }

        // --- Password check ---
        // Password must be at least 8 characters, and include at least one
           // lowercase letter, one uppercase letter, one number, and one symbol.
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/;

        const pass = document.getElementById('pass').value;
        if (!passwordRegex.test(pass)) {
            document.getElementById('pass-error').textContent =
                'Password must be at least 8 characters and include an uppercase letter, a lowercase letter, a number, and a symbol.';
            isValid = false;
        }

        // --- Country check ---
        const country = document.getElementById('country').value;
        if (country === '') {
            document.getElementById('country-error').textContent = 'Please select a country.';
            isValid = false;
        }

        // --- City check ---
        const city = document.getElementById('city').value.trim();
        if (city === '') {
            document.getElementById('city-error').textContent = 'City is required.';
            isValid = false;
        }

        // --- Contact number check ---
        const contact = document.getElementById('contact').value.trim();
        if (!phoneRegex.test(contact)) {
            document.getElementById('contact-error').textContent = 'Enter a valid phone number.';
            isValid = false;
        }

        // --- If anything failed, STOP the form from submitting ---
        if (!isValid) {
        
            event.preventDefault();
        } else {
            // Everything passed — show a loading state on the button
            // so the user gets feedback while the server processes
            //  submission
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.textContent = 'Registering...';
            submitBtn.disabled = true;
            
        }
    });
});