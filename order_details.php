<?php
    $conn = new mysqli("localhost", "root", "", "store_db");
    if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);

    // Get order ID from URL: order_details.php?id=1
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Invalid order ID.");
    }
    $order_id = intval($_GET['id']);

    // Get order info
    $order_sql = "SELECT * FROM orders WHERE order_id  = $order_id";
    $order_result = $conn->query($order_sql);

    if (!$order_result || $order_result->num_rows == 0) {
        die("Order not found.");
    }
    $order = $order_result->fetch_assoc();

    // Get order items
    $item_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
    $item_result = $conn->query($item_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <style>
        body { font-family: Arial; }
        .box { width: 80%; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        h2 { text-align: center; margin-top: 50px; }
        .header{ background: #fff; box-shadow:0px 5px 8px 0 rgba(0,0,0,0.1); padding: 15px; width: 600px; border: 1px solid #ccc; }
        .back{padding: 10px 20px; background: #666; position: relative; top: 20px; cursor: pointer; border: none;}
        .btn{width: 70px; height: 36px; background: #666; color: #fff; position: relative; top: 22px; cursor: pointer; border: none; }
        .back a{color: #fff; text-decoration: none; }
        .header_section{ position: relative; margin-top: 110px; }
    </style>
</head>
<body>
<div class="box">
    <h2>🧾 Order Details </h2>

    <div class="header_section">
        <div class="header">
          <h3>Customer Information</h3>
          <p><b>Name:</b> <?= $order['customer_name'] ?></p>
          <p><b>Email:</b> <?= $order['customer_email'] ?></p>
          <p><b>Phone:</b> <?= $order['customer_phone'] ?></p>
          <p><b>Address:</b> <?= $order['customer_address'] ?></p>
          <p><b>Order Date:</b> <?= $order['order_date'] ?></p>
        </div>
        <h3>Products</h3>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php
              $total = 0;
              while ($item = $item_result->fetch_assoc()) {
                  $total += $item['subtotal'];
                  echo "<tr>
                            <td>{$item['product_name']}</td>
                            <td>\${$item['price']}</td>
                            <td>{$item['quantity']}</td>
                            <td>\${$item['subtotal']}</td>
                        </tr>";
              }
              echo "<tr><td colspan='3'><b>Grand Total</b></td><td><b>\${$total}</b></td></tr>";
            ?>
        </table>
        <button class="back"><a href="customer.php">Back</a></button>
    </div>
</div>

</body>
</html>
