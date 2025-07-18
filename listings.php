<?php
include 'config/database.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

$query = "SELECT * FROM listings WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($category)) {
    $query .= " AND category = ?";
    $params[] = $category;
}

if (!empty($location)) {
    $query .= " AND location LIKE ?";
    $params[] = "%$location%";
}

$query .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$listings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Browse Listings - Jiji Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search..."
                            value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="Electronics" <?php echo $category === 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                            <option value="Fashion" <?php echo $category === 'Fashion' ? 'selected' : ''; ?>>Fashion</option>
                            <option value="Home" <?php echo $category === 'Home' ? 'selected' : ''; ?>>Home</option>
                            <option value="Vehicles" <?php echo $category === 'Vehicles' ? 'selected' : ''; ?>>Vehicles</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="location" class="form-control" placeholder="Location"
                            value="<?php echo htmlspecialchars($location); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <?php foreach ($listings as $listing): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="assets/images/<?php echo htmlspecialchars($listing['image1']); ?>"
                            class="card-img-top" alt="<?php echo htmlspecialchars($listing['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($listing['title']); ?></h5>
                            <p class="card-text text-primary fw-bold">GHS <?php echo number_format($listing['price'], 2); ?></p>
                            <p class="card-text text-muted">
                                <small><?php echo htmlspecialchars($listing['location']); ?></small>
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="view-ad.php?id=<?php echo $listing['id']; ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>