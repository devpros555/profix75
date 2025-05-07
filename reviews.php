<?php
$host = 'localhost';      // or 127.0.0.1
$db   = 'mywebsite';
$user = 'root';           // your MySQL username
$pass = '';               // your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = htmlspecialchars($_POST['name']);
  $message = htmlspecialchars($_POST['message']);

  $stmt = $pdo->prepare("INSERT INTO reviews (name, message) VALUES (?, ?)");
  $stmt->execute([$name, $message]);

  echo "Success";
} else {
  echo "Invalid request.";
}
?>
