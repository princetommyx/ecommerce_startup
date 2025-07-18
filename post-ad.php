<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle image uploads (simplified)
    $image1 = uploadImage($_FILES['image1']);

    $stmt = $pdo->prepare("INSERT INTO listings (user_id, title, description, price, category, location, image1) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['title'],
        $_POST['description'],
        $_POST['price'],
        $_POST['category'],
        $_POST['location'],
        $image1
    ]);

    header("Location: index.php");
    exit;
}

function uploadImage($file)
{
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($file['tmp_name'], 'assets/images/' . $filename);
        return $filename;
    }
    return 'default.jpg';
}
?>

<!-- HTML Form -->
<div class="container mt-4">
    <h2>Post Your Ad</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Price (GHS)</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
                <option value="Electronics">Electronics</option>
                <option value="Fashion">Fashion</option>
                <option value="Home">Home</option>
                <option value="Vehicles">Vehicles</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Images (Max 3)</label>
            <input type="file" name="image1" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Post Ad</button>
    </form>
</div>