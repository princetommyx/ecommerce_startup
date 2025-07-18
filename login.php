<?php
include 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT listings.*, users.name as seller_name, users.phone as seller_phone 
                      FROM listings JOIN users ON listings.user_id = users.id 
                      WHERE listings.id = ?");
$stmt->execute([$_GET['id']]);
$listing = $stmt->fetch();

if (!$listing) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($listing['title']); ?> - Jiji Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h1><?php echo htmlspecialchars($listing['title']); ?></h1>
                <div class="mb-4">
                    <img src="assets/images/<?php echo htmlspecialchars($listing['image1']); ?>"
                        class="img-fluid rounded" alt="<?php echo htmlspecialchars($listing['title']); ?>">
                </div>

                <h3>Description</h3>
                <p><?php echo nl2br(htmlspecialchars($listing['description'])); ?></p>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-primary">GHS <?php echo number_format($listing['price'], 2); ?></h2>
                        <p class="card-text">
                            <strong>Category:</strong> <?php echo htmlspecialchars($listing['category']); ?><br>
                            <strong>Location:</strong> <?php echo htmlspecialchars($listing['location']); ?><br>
                            <strong>Posted:</strong> <?php echo date('M j, Y', strtotime($listing['created_at'])); ?>
                        </p>

                        <hr>

                        <h4>Seller Information</h4>
                        <p>
                            <strong>Name:</strong> <?php echo htmlspecialchars($listing['seller_name']); ?><br>
                            <strong>Phone:</strong> <?php echo htmlspecialchars($listing['seller_phone']); ?>
                        </p>

                        <a href="tel:<?php echo htmlspecialchars($listing['seller_phone']); ?>"
                            class="btn btn-success btn-lg w-100 mt-3">
                            <i class="bi bi-telephone"></i> Call Seller
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>