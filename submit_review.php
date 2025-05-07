<?php
header('Content-Type: application/json');

// Database connection details
$host = 'localhost';
$db   = 'profix405';  // Change this to your database name
$user = 'root';       // Change this to your database username
$pass = '';           // Change this to your database password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // Create the PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Get form data
    $name = $_POST['name'] ?? '';        // 'name' comes from the form
    $message = $_POST['message'] ?? '';  // 'message' comes from the form

    // Check if 'name' and 'message' fields are filled
    if ($name === '' || $message === '') {
        echo json_encode(['success' => false, 'error' => 'Missing fields']);
        exit;
    }

    // Check if the same review already exists (same name and review content)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE name = :name AND review = :review");
    $stmt->execute(['name' => $name, 'review' => $message]);
    $count = $stmt->fetchColumn();

    // If the review already exists, prevent duplicate and return an error
    if ($count > 0) {
        echo json_encode(['success' => false, 'error' => 'Review already submitted']);
        exit;
    }

    // Insert the new review into the database
    $stmt = $pdo->prepare("INSERT INTO reviews (name, review, created_at) VALUES (:name, :review, NOW())");
    $stmt->execute([
        'name' => $name,
        'review' => $message
    ]);

    // Send a successful response
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Catch any database errors and return the error message
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
