<?php
// index.php
require 'config.php';

// Fetch latest reviews
$stmt    = $pdo->query("
    SELECT name, message, created_at
    FROM profix_reviews
    ORDER BY created_at DESC
    LIMIT 20
");
$reviews = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <!-- …your head… -->
</head>
<body>
  <!-- …your reviews section markup… -->

  <div id="reviews-list">
    <?php if (count($reviews) === 0): ?>
      <p>No reviews yet. Be the first to leave feedback!</p>
    <?php else: ?>
      <?php foreach ($reviews as $r): ?>
        <div class="single-review">
          <strong><?= htmlspecialchars($r['name']) ?></strong>
          <em><?= date('M j, Y', strtotime($r['created_at'])) ?></em>
          <p><?= nl2br(htmlspecialchars($r['message'])) ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- review form -->
  <form id="review-form" action="submit_review.php" method="post">
    <input type="text"   name="name"    placeholder="Your Name" required>
    <textarea name="message" placeholder="Your Feedback..." required></textarea>
    <button type="submit">Send Review</button>
  </form>

  <!-- …rest of page… -->
</body>
</html>
