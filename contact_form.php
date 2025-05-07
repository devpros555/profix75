<?php
// contact_form.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php');
  exit;
}

$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$message = trim($_POST['msg']     ?? '');

if ($name === '' || $email === '' || $message === '') {
  header('Location: index.php?contact_error=All+fields+required');
  exit;
}

// Basic email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header('Location: index.php?contact_error=Invalid+email+address');
  exit;
}

$to      = 'Profixconstruction405@gmail.com';        // your destination address
$subject = 'New Contact Form Submission';
$body    = "Name: $name\nEmail: $email\n\n$message";
$headers = "From: $email\r\nReply-To: $email\r\n";

if (mail($to, $subject, $body, $headers)) {
  header('Location: index.php?contact_success=Message+sent+successfully');
} else {
  header('Location: index.php?contact_error=Could+not+send+message');
}
exit;
?>
