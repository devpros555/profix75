<?php
header('Content-Type: text/html');

$host = 'localhost';
$db   = 'profix405';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // ✅ Use correct column name: 'review' not 'message'
    $stmt = $pdo->query("SELECT name, review FROM reviews ORDER BY created_at DESC LIMIT 10");
    $reviews = $stmt->fetchAll();

    foreach ($reviews as $r) {
        echo "<div style='margin-bottom:10px; background:#fff; padding:10px; border-radius:5px; box-shadow:0 0 4px rgba(0,0,0,0.1);'>";
        echo "<strong style='color:black'>" . htmlspecialchars($r['name']) . "</strong><br>";
        echo "<p style='margin: 5px 0 0; color:#333'>" . nl2br(htmlspecialchars($r['review'])) . "</p>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>❌ Error loading reviews: " . $e->getMessage() . "</p>";
}
