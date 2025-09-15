<?php
session_start();

// Add product to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['id'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If product already in cart → increase quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            "name" => $product_name,
            "price" => $product_price,
            "quantity" => $quantity
        ];
    }
    header("Location: view_cart.php");
    exit();
}

// Delete product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    unset($_SESSION['cart'][$delete_id]);
    header("Location: view_cart.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <style>
        body{
            overflow-x: hidden;
        }
        table { 
            width: 70%; 
            margin: auto; 
            border-collapse: collapse; 
        }
        table, th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: center; 
        }
        th { 
            background: #f4f4f4; 
        }
        button { 
            padding: 5px 10px; 
            cursor: pointer; 
        }
        .view_cart{
            background: #ff0000;
            color: #fff;
            border-radius: 5px;
            padding: 10px 10px;
        }
        .view_cart a{
            color: #fff;
        }
        .qaunlity_add{
          width: 20px;
          border: none;
          background: none;
          position: relative;
          left: 5px;
          outline: none;
        }
        .Mybtn{
          position: relative;
          left: 285px;
          top: 20px
        }
        .Mybtn button{
            width: 120px;
            padding: 8px 25px;
            background: #0000ff;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .Mybtn button:nth-child(2){
            background: none;
            border: 1px solid #ccc
        }
        .Mybtn button:nth-child(2) a{
            color: #555;
        }
        .Mybtn button a{
            color: #fff;
            text-decoration: none;
        }
        .header_arrange_qaunlity{
            width: 120px;
            background: #e7e0e0ad;
            border-radius: 40px;
            height: 28px;
        }
        .header_arrange_qaunlity button{
            background: none;
            border: none;
            outline: none;
            font-size: 1rem;
            
        }
    </style>
    <script>
        function updateQuantity(id, change) {
            let qtyInput = document.getElementById("qty-" + id);
            let newQty = parseInt(qtyInput.value) + change;
            if (newQty < 1) newQty = 1;
            qtyInput.value = newQty;
            document.getElementById("cartForm").submit();
        }
    </script>
</head>
<body>
    <h2 style="text-align:center;">🛒 Your Cart</h2>
    <form id="cartForm" method="post" action="update_cart.php">
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th style="width: 120px;">Quantity</th>
                <th style="width: 120px;">Total</th>
                <th style="width: 90px;">Action</th>
                
            </tr>

            <?php
            $grand_total = 0;
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $id => $item) {
                    $total = $item['price'] * $item['quantity'];
                    $grand_total += $total;
                    echo "
                    <tr>
                        <td>{$item['name']}</td>
                        <td>\${$item['price']}</td>
                        <td>
                            <div class='header_arrange_qaunlity'>
                                <button type='button' onclick='updateQuantity($id, -1)'>-</button>
                                <input type='text' class='qaunlity_add' name='quantities[$id]' id='qty-$id' value='{$item['quantity']}' size='2' readonly>
                                <button type='button' onclick='updateQuantity($id, 1)'>+</button>
                            </div>
                        </td>
                        <td>\$$total</td>
                        <td><a class='view_cart' href='view_cart.php?delete=$id'> <i class='fa-solid fa-trash'></i></a></td>
                    </tr>";
                }
                echo "<tr><td colspan='3'><b>Grand Total</b></td><td colspan='2'><b>\$$grand_total</b></td></tr>";
            } else {
                echo "<tr><td colspan='5'>Your cart is empty</td></tr>";
            }
            ?>
        </table>
        <div class="Mybtn">
            <button><a href="index.php">Shopping</a></button>
            <button><a href="checkout.php">Checkout</a></button>
        </div>
    </form>
</body>
</html>
