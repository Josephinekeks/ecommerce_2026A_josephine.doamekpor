// Client-side image check.  for USER EXPERIENCE .

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('product-form');
    const fileInput = document.getElementById('product_image');
    const errorBox = document.getElementById('image-error');

    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 2 * 1024 * 1024; 

    form.addEventListener('submit', function (event) {
        errorBox.textContent = '';

        // files[0] is the chosen file; undefined if none 
        const file = fileInput.files[0];
        if (!file) {
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            errorBox.textContent = 'Only JPG, PNG, GIF or WEBP images are allowed.';
            event.preventDefault();
            return;
        }

        if (file.size > maxSize) {
            errorBox.textContent = 'Image must be 2MB or smaller.';
            event.preventDefault();
        }
    });
});