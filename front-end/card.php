<?php
session_start();
include("../admin_template/db_conn.php");

$card = isset($_SESSION["card"]) ? $_SESSION["card"] : array();

$products = [];
if(!empty($card)) {
    $product_ids = implode(",", array_keys($card));
    $sql = "SELECT * FROM product_table WHERE id IN ($product_ids)";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

if(isset($_POST["proceed"])) {
    header("Location: shipping.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">E-commerce Platform</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Anasayfa.php">Home</a>
                    <li class="nav-item">
                        <a class="nav-link" href="payment.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Add Category</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav>
    <!-- Navbar end -->

    <div class="container">
        <div class="text-center mb-4">
            <h3>Card</h3>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product) { ?>
                    <tr>
                        <td><?php echo $product["name"]; ?></td>
                        <td><?php echo $card[$product["id"]]; ?></td>
                        <td><?php echo $product["price"]; ?> USD</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <form method="post" action="card.php">
            <button type="submit" name="proceed" class="btn btn-success">Proceed</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

