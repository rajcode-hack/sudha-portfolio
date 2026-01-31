<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit;
}

// Sanitize inputs
$name     = strip_tags(trim($_POST["name"] ?? ''));
$email    = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
$phone    = strip_tags(trim($_POST["phone"] ?? ''));
$comments = strip_tags(trim($_POST["comments"] ?? ''));

// Validation
if ($name === '') {
    echo "<div class='alert alert-error'>Name is required.</div>";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-error'>Valid email is required.</div>";
    exit;
}

if ($phone === '') {
    echo "<div class='alert alert-error'>Phone is required.</div>";
    exit;
}

if ($comments === '') {
    echo "<div class='alert alert-error'>Message cannot be empty.</div>";
    exit;
}

// 🔴 IMPORTANT: use your domain email here
$to = "rajshekhard92@gmail.com";
$subject = "New Contact Form Message";

// Email body
$message = "
Name: $name
Email: $email
Phone: $phone

Message:
$comments
";

// Headers (THIS FIXES MAIL DELIVERY)
$headers  = "From: Website Contact <no-reply@yourdomain.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $message, $headers)) {
    echo "<div class='alert alert-success'>
            <h3>Email Sent Successfully</h3>
            <p>Thank you <strong>$name</strong>, we’ll get back to you shortly.</p>
          </div>";
} else {
    echo "<div class='alert alert-error'>Mail server error. Please try again later.</div>";
}
