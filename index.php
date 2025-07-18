<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Ecommerce - Buy and Sell in Ghana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <h2>Recent Listings</h2>
        <div class="row">
            <?php
            $stmt = $pdo->query("SELECT * FROM listings ORDER BY created_at DESC LIMIT 8");
            while ($row = $stmt->fetch()) {
                echo '<div class="col-md-3 mb-4">';
                echo '  <div class="card">';
                echo '    <img src="assets/images/' . $row['image1'] . '" class="card-img-top" alt="' . $row['title'] . '">';
                echo '    <div class="card-body">';
                echo '      <h5 class="card-title">' . $row['title'] . '</h5>';
                echo '      <p class="card-text">GHS ' . number_format($row['price'], 2) . '</p>';
                echo '      <a href="view-ad.php?id=' . $row['id'] . '" class="btn btn-primary">View</a>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>