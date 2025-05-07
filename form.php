<?php
// DB config
$db_host = 'localhost';
$db_name = 'profix405';
$db_user = 'root';
$db_pass = '';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate fields
    if ($name === '' || $message === '') {
        header('Location: index.php?error=Please+fill+in+all+fields');
        exit;
    }

    // Insert into reviews table
    $stmt = $pdo->prepare("
        INSERT INTO reviews (name, message, created_at)
        VALUES (:name, :message, NOW())
    ");
    $stmt->execute([
        ':name'    => $name,
        ':message' => $message,
    ]);

    header('Location: index.php?success=Thank+you+for+your+review');
    exit;
}
?>

<?php
require 'config.php';

