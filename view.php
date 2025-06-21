<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Items</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h2>Lost & Found Items</h2>
  <form method="GET">
    <input type="text" name="search" placeholder="Search by keyword...">
    <select name="filter">
      <option value="All">All</option>
      <option value="Lost">Lost</option>
      <option value="Found">Found</option>
    </select>
    <button type="submit">Search</button>
  </form>
  <div class="items">
    <?php
    $filter = $_GET['filter'] ?? 'All';
    $search = $_GET['search'] ?? '';

    $sql = "SELECT * FROM items WHERE status='approved'";
    if ($filter !== 'All') {
      $sql .= " AND type='" . $conn->real_escape_string($filter) . "'";
    }
    if (!empty($search)) {
      $sql .= " AND (title LIKE '%$search%' OR description LIKE '%$search%' OR category LIKE '%$search%')";
    }

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      echo "<div class='item'>";
      echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
      echo "<p><strong>" . $row['type'] . "</strong> | " . $row['location'] . " | " . $row['date'] . "</p>";
      echo "<p>" . htmlspecialchars($row['description']) . "</p>";
      if ($row['image_path']) {
        echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Item image' width='150'>";
      }
      echo "<p>Contact: " . htmlspecialchars($row['contact']) . "</p>";
      echo "</div><hr>";
    }
    ?>
  </div>
</body>
</html>