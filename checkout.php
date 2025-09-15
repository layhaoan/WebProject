
<?php
session_start();

// Connect to DB
$conn = new mysqli("localhost", "root", "", "store_db");
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// Example cart data for testing (remove if you already have a cart)


// When user submits checkout
if (isset($_POST['checkout'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    $grand_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $grand_total += $item['price'] * $item['quantity'];
    }
    
    // ✅ Insert into orders table
    $sql = "INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL prepare failed (orders): " . $conn->error);
    }
    $stmt->bind_param("ssssd", $name, $email, $phone, $address, $grand_total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // ✅ Insert each item into order_items
    $sql2 = "INSERT INTO order_items (order_id, product_name, price, quantity, subtotal)
             VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    if (!$stmt2) {
        die("SQL prepare failed (order_items): " . $conn->error);
    }


    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $stmt2->bind_param("isdis", $order_id, $item['name'], $item['price'], $item['quantity'], $subtotal);
        $stmt2->execute();
    }
    $stmt2->close();

    unset($_SESSION['cart']);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        table { 
            width: 70%; 
            margin: auto; 
            border-collapse: collapse; 
            position: absolute;
            top: 130px;
            left: 40px;
        }

        table, th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: center; 
            text-align: left; 
        }
        th { 
            background: #f4f4f4; 
            
        }
        input, textarea { 
            width: 100%; 
            padding: 8px; 
            margin: 14px 0; 
            border: none;
            border-bottom: 1px solid #555;
            outline: none;
            font-size: 0.95rem;
        }
        .form-box { 
            width: 400px; 
            height: 400px;
            margin: 20px auto; 
            border: 1px solid #ddd; 
            padding: 15px; 
            border-radius: 8px; 
            position: absolute;
            right: 40px;
            box-shadow: 0 5px 8px 0 rgba(0,0,0,0.2)
        }
       
        .checkout_btn{
            position: absolute;
            top: 340px;
            left: 7px;
            width: 120px;
            height: 30px;
        }
        .header{
            width: 300px;
            position: absolute;
            left: 50px;
            top: 80px 
        }
        .checkoutBtn{
            position: absolute;
            bottom: 40px;
            padding: 8px 20px;
            left: 50px;
            cursor: pointer;
            border-radius: 8px;
            background: #0000ff;
            color: #fff;
            border: 1px solid #0000ff;
        }
        .order_summary{
            padding-left: 35px;
        }
        .btn{
            margin-left: 35px;
        }
        .btn button{
            width: 170px;
            height: 32px;
            border-radius: 5px;
            background: #0000ff;
            border: 1px solid #0000ff;
           
            cursor: pointer;
        }
        .btn button a{
            color: #fff;
            text-decoration: none;
        }
        .btn button:nth-child(2){
            background: none;
            border: 1px solid #ccc;
            width: 140px;
        }
        .btn button:nth-child(2) a{
            color: #555;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">🛒 Checkout</h2>

    <div class="btn">
        <button><a href="index.php">⬅ Continue Shopping</a></button>
        <button><a href="customer.php">View All Orders</a></button>
    </div>

    <table>
        <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
        <?php
            $grand_total = 0;

            if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $item) {
                    $total = $item['price'] * $item['quantity'];
                    $grand_total += $total;

                    echo "<tr>
                        <td>{$item['name']}</td>
                        <td>\${$item['price']}</td>
                        <td>{$item['quantity']}</td>
                        <td>\${$total}</td>
                    </tr>";
                }
                echo "<tr><td colspan='3'><b>Grand Total</b></td><td><b>\${$grand_total}</b></td></tr>";
            } else {
                echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
            }

        ?>
    </table>

    <div class="form-box">
        <form method="post">
            <h2 class="order_summary">Order Summary</h2>
            <div class="header">
                <input type="text" name="name" placeholder="Your name" required>
                <input type="number" name="phone" placeholder="Phone number" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="address" placeholder="Current Address">
            </div>
            <button type="submit" name="checkout" class="checkoutBtn">Place Order</button>
        </form>
    </div>
</body>
</html>
