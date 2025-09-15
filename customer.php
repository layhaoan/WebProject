<?php
$mysqli = new mysqli("localhost", "root", "", "store_db");

// Handle delete action
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: customer.php");
    exit();
}

// Fetch all orders
$result = $mysqli->query("SELECT * FROM orders ORDER BY order_date DESC");
?>

</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preload" href="KHKSHSub2.woff2" as="font" type="font/woff2" crossorigin>
    <style>
       *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "KH KSH text1";
        font-style: normal;
        font-weight: normal;
    }
    body{
        height: 100vh;
        display: flex;
        place-content: center;
        overflow-y: auto;
    }
    .header-contain{
        position: relative;
        width: 100%;
        height: 100vh;
        background: #fff;
    }
    .left-menu{
        position: fixed;
        width: 250px;
        height: 100vh;
        background: #f2f2f2;
        top: 0;
        left: 0;
        border-right: 1px solid #ddd;
    }
    .left-menu .logo{
        padding: 40px 50px;
        display: block;
        position: relative;
        display: flex;
        cursor: pointer;
    }
    .left-menu .logo i{
        font-size: 1.6rem;
    }
    .left-menu .logo h2{
        color: #0000ff;
        font-weight: bolder;
        position: relative;
        padding: 10px 10px;
        bottom: 18px;
    }
    .menu{
        position: relative;
        left: 15px;
        bottom: 40px;
    }
    .menu li{
        height: 50px;
        width: 220px;
        background: none;
        margin: 2px;
        list-style: none;
        cursor: pointer;
        position: relative;
    }
    .menu li:nth-child(3){
        background: #fff;
        border-right: 2px solid #0000ff;
    }
    .menu li::before{
        content: "";
        position: absolute;
        width: 100%;
        height: 1px;
        bottom: 0;
        left: 0;
    }
    .menu li a{
        text-decoration: none;
        font-size: 1rem;
        color: #666;
        padding: 0 50px;
        position: relative;
        top: 15px;
    }
    .menu li i{
        position: absolute;
        left: 16px;
        top: 17px;
    }
    .menu li:hover{
        background: #fff;
        border-right: 2px solid #0000ff;
    }
    .head-menu{
        position: absolute;
        width: 1116px;
        height: 10vh;
        background: none;
        top: 0;
        right: 0;
        border-right: 1px solid #ddd;
    }
    .head-account{
        position: absolute;
        right: 220px;
        top: 15px;
    }

    #MyTable{
        width: 1580px;
        position: absolute;
        right: 40px;
        top: 60px
    }
    .oderText{
        position: absolute;
        top: 30px;
        left: 300px;
        font-size: 1.6rem;
        font-weight: bold;
    }
    table { 
        width: 83%; 
        border-collapse: collapse; 
        background: #fff; 
        position: absolute;
        top: 80px;
        right: 30px;
        padding: 10px;
    }
    th { 
        background: #007bff; 
        color: #fff; 
    }
    th, td { 
        border: 1px solid #ddd; 
        padding: 10px; 
        text-align: left; 
    }
    th { 
        background: #007bff; 
        color: #fff; 
    }
</style>

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


        <h2 class="oderText">All Orders</h2>
        <table>

            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Total</th>
                <th>Date</th>
                <th>Details</th>
            </tr>

            <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>

                <tr>
                    <td><?php echo $row['customer_name'];?></td>
                    <td><?php echo $row['customer_phone'];?></td>
                    <td><?php echo $row['customer_email'];?></td>
                    <td><?php echo $row['customer_address'];?></td>
                    <td>$<?php echo $row['total'];?></td>
                    <td><?php echo $row['order_date'];?></td>
                    <td style="width: 210px;">
                        <button type="button" class="btn btn-secondary">
                            <a style="color: #fff; text-decoration: none;" href="order_details.php?id=<?php echo $row['order_id'];?>">View Items</a>
                        </button>
                        <button type="button" class="btn btn-danger">
                            <a style="color: #fff; text-decoration: none;" href="customer.php?delete=<?php echo $row['order_id']; ?>" onclick="return confirm('Delete this Customer?')">Delete</a>
                        </button>
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