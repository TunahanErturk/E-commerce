<?php
session_start();
include 'db_conn.php';

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock_quantity = $_POST["stock_quantity"];
    $category_id = $_POST["category_id"];

    // Dosya adı alma
    $file_name = basename($_FILES["picture"]["name"]);

    // Check if fields are not empty
    if (empty($name) || empty($price) || empty($stock_quantity) || empty($description) || empty($category_id) || empty($_FILES["picture"]["name"])) {
        header("Location: add_product.php?message=Please fill in all fields");
        exit();
    }

    // Allow only certain file formats
    $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        header("Location: add_product.php?message=Only JPG, JPEG, PNG & GIF files are allowed.");
        exit();
    }

    // Veritabanına kaydetme
    $sql = "INSERT INTO product_table (name, description, price, stock_quantity, picture, category_id) 
            VALUES ('$name', '$description', '$price', '$stock_quantity', '$file_name', '$category_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: product_list.php?message=Product added successfully");
        exit();
    } else {
        echo "Failed: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color:chocolate;">
        PRODUCT PAGE
    </nav>
    <div class="container">
        <ul class="nav justify-content-left">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: chocolate;">
                    ADMIN MANAGEMENT
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="admin_panel.php">ADMIN PANEL</a></li>
                    <li><a class="dropdown-item" href="admin_list.php">ADMIN LIST</a></li>
                    <li><a class="dropdown-item" href="add_admin.php">ADD ADMIN</a></li>
                    <li><a class="dropdown-item" href="category_list.php">CATEGORY LIST</a></li>
                    <li><a class="dropdown-item" href="add_category.php">ADD CATEGORY</a></li>
                    <li><a class="dropdown-item" href="product_list.php">PRODUCT LIST</a></li>
                    <li><a class="dropdown-item" href="add_product.php">ADD PRODUCT</a></li>
                    <li><a class="dropdown-item" href="order_list.php">ORDER LIST</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="text-center mb-4">
            <h3>ADD NEW PRODUCT</h3>
            <?php
                if (isset($_GET["message"])) { // If message is set
                    $message = $_GET["message"];
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    '.$message.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            ?>
            <p class="text-muted">Please fill in this form to add a new product.</p>
        </div>

        <div class="container d-flex justify-content-center">
            <form action="add_product.php" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="formFile" class="form-label">Product picture:</label>
                        <input class="form-control" type="file" id="formFile" name="picture">
                    </div>
                    <div class="col">
                        <label class="form-label">Price:</label>
                        <input type="number" step="0.01" class="form-control" name="price" placeholder="Price">
                    </div>
                    <div class="col-sm-10">
                        <label for="stock_quantity" class="col-sm-2 col-form-label">Stock Quantity</label>
                        <select class="form-control" id="stock_quantity" name="stock_quantity">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <br>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                    </div>
                    <div class="col">
                        <label class="form-label">Category ID:</label>
                        <input type="text" class="form-control" name="category_id" placeholder="Category ID">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                        <a href="product_list.php" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
