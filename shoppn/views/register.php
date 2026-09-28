<?php 
require_once __DIR__ . '/../core/core.php';

require_once __DIR__ . '/layout/header.php';
?>

<main>
    <section>
        <h1>Create an Account</h1>

        <?php
        // Check if an error was stored from a previous failed attempt
       
        if (isset($_SESSION['error'])) {
          
            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';

            
            unset($_SESSION['error']);
        }
        ?>

        <form id="register-form" method="POST" action="../actions/register_action.php">

            <label for="name">Full Name</label><br>
            <input type="text" id="name" name="name" required><br>
            <span class="error-message" id="name-error"></span>

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required><br>
            <span class="error-message" id="email-error"></span>

            <label for="pass">Password</label><br>
            <input type="password" id="pass" name="pass" required><br>
            <span class="error-message" id="pass-error"></span>

            <label for="country">Country</label><br>
            <select id="country" name="country" required>
                <option value="">-- Select Country --</option>
                <option value="Ghana">Ghana</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Kenya">Kenya</option>
                <option value="South Africa">South Africa</option>
                <option value="Other">Other</option>
            </select><br>
            <span class="error-message" id="country-error"></span>

            <label for="city">City</label><br>
            <input type="text" id="city" name="city" required><br>
            <span class="error-message" id="city-error"></span>

            <label for="contact">Contact Number</label><br>
            <input type="text" id="contact" name="contact" required><br>
            <span class="error-message" id="contact-error"></span>

            <label for="address">Address</label><br>
            <input type="text" id="address" name="address"><br>
            <span class="error-message" id="address-error"></span>

          

            <button type="submit" id="submit-btn">Register</button>
        </form>
    </section>
</main>

<!-- Pulls in client-side validation script 
<

<?php require_once __DIR__ . '/layout/footer.php'; ?>