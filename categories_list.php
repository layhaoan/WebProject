<?php
$conn = new mysqli("localhost", "root", "", "store_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM categories WHERE id=$id");
    header("Location: categories_list.php");
    exit;
}

// Fetch categories
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Categories List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preload" href="KHKSHSub2.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="css/category_items_list.css">
</head>
<body>

       <div class="header-contain">
        <div class="left-menu">
            <a href="index.php">
                <div class="logo">
                    <i class="fa-solid fa-shop"></i>
                    <h2>SHOES</h2>
                </div>
            </a>
            <div class="menu">
                <li><i class="fa-solid fa-chart-simple"></i><a href="Dashbaord.php">Analytics</a></li>
                <li><i class="fa-solid fa-bag-shopping"></i><a href="stock-products.php">Product</a></li>
                <li><i class="fa-solid fa-users"></i><a href="customer.php">Customer List</a></li>
                <li><i class="fa-solid fa-table-list"></i><a href="categories_list.php">Categories</a></li>
                <li><i class="fa-solid fa-gear"></i><a href="#">Setting</a></li>
            </div>
        </div>

        <h2 class="oderText">Categories</h2>
        <button class="new-categories"><a href="add_category.php">Add New Category</a></button>
        <table>
          <tr>
            <th>Name</th>
            <th>Types</th>
            <th>Status</th>
            <th>Price</th>
            <th style="width: 380px;">Description</th>
            <th class="image">Image</th>
            <th class="action-btn">Actions</th>
          </tr>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['types']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><img class="img-products" src="uploads/<?php echo htmlspecialchars($row['image']); ?>"></td>

                <td>
                  <button type="button" class="btn btn-primary"><a style="color: #fff;  text-decoration: none;" href="edit_category.php?id=<?php echo $row['id']; ?>">Edit</a></button>
                  <button type="button" class="btn btn-danger"><a style="color: #fff;  text-decoration: none;" href="categories_list.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this category?')">Delete</a></button>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4">No categories found.</td></tr>
          <?php endif; ?>
        </table>


    </div>

</body>
</html>

  