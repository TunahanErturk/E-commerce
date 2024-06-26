<?php
include "db_conn.php"; 

// Check if an ID is provided in the URL and proceed to delete the record
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM product_table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Product successfully deleted.";
    } else {
        $message = "Error deleting product.";
    }
    $stmt->close();
    header("Location: product_list.php?message=" . urlencode($message));
    exit();
}
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
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
      <?php
      if(isset($_GET["message"])){ //if message is set
        $message = $_GET["message"];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        '.$message.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
      }
      ?>
        <a href="add_product.php" class="btn btn-dark mb-3">Add New Product</a>

        <table class="table table-hover text-center">
          <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Stock Quantity</th>
                <th scope="col">Picture</th>
                <th scope="col">Category ID</th>
                <th scope="col">Action</th>
            </tr>   
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM product_table";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){ 
             ?>
            <tr>
                <th><?php echo $row["id"] ?></th>
                <th><?php echo $row["name"] ?></th>
                <th><?php echo $row["description"] ?></th>
                <th><?php echo $row["price"] ?></th>
                <th><?php echo $row["stock_quantity"] ?></th>
                <td><img src="../admin_template/images/<?= $row['picture'] ?>" alt="<?= $row['name'] ?>" width="100px"></td>
                <th><?php echo $row["category_id"] ?></th>
                <td>
                    <a href="product_edit.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="bi bi-pencil-square"></i></a>
                    <a href="product_list.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
    </div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($conn);
?>
