<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Lost/Found Item</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h2>Submit Lost/Found Item</h2>
  <form action="submit.php" method="POST" enctype="multipart/form-data">
    <label>Title:<input type="text" name="title" required></label><br>
    <label>Description:<textarea name="description" required></textarea></label><br>
    <label>Category:<input type="text" name="category" required></label><br>
    <label>Location:<input type="text" name="location" required></label><br>
    <label>Type:
      <select name="type">
        <option value="Lost">Lost</option>
        <option value="Found">Found</option>
      </select>
    </label><br>
    <label>Contact Email:<input type="email" name="contact" required></label><br>
    <label>Image:<input type="file" name="image"></label><br>
    <button type="submit" name="submit">Submit</button>
  </form>

<?php
if (isset($_POST['submit'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $location = $_POST['location'];
  $type = $_POST['type'];
  $contact = $_POST['contact'];
  $date = date('Y-m-d');

  $image_path = '';
  if ($_FILES['image']['name']) {
    $image_path = 'assets/uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
  }

  $stmt = $conn->prepare("INSERT INTO items (title, description, category, location, type, contact, image_path, status, date) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', ?)");
  $stmt->bind_param("ssssssss", $title, $description, $category, $location, $type, $contact, $image_path, $date);

  if ($stmt->execute()) {
    echo "<p>Item submitted successfully. Awaiting admin approval.</p>";
  } else {
    echo "<p>Error submitting item: " . $conn->error . "</p>";
  }
}
?>
</body>
</html>
