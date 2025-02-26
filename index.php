<?php
// Generate new CAPTCHA numbers on every page load
$firstNum = rand(1, 9);
$secondNum = rand(1, 9);
$captchaResult = $firstNum + $secondNum;

$errorMsg = $successMsg = ""; // Placeholder for messages

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);
    $captchaInput = $_POST["captcha"];
    $captchaCorrect = $_POST["captcha_correct"];

    if ($captchaInput == $captchaCorrect) {
        $successMsg = "Thank you! Your message has been received.";
        $name = $email = $message = ""; // Clear fields on success
    } else {
        $errorMsg = "Incorrect CAPTCHA. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form with CAPTCHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Contact Form</h2>

    <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $successMsg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $errorMsg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post" class="border p-4 rounded shadow bg-light">
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required value="<?= isset($name) ? $name : '' ?>">
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required value="<?= isset($email) ? $email : '' ?>">
        </div>
        <div class="mb-3">
            <textarea name="message" class="form-control" placeholder="Your Message" required><?= isset($message) ? $message : '' ?></textarea>
        </div>
        
        <div class="mb-3 d-flex align-items-center">
            <label class="me-2 fw-bold">Solve: <?= $firstNum . " + " . $secondNum ?> = ?</label>
            <input type="number" name="captcha" class="form-control w-25" required>
        </div>
        <input type="hidden" name="captcha_correct" value="<?= $captchaResult ?>">

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
