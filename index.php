<?php
    session_start();

    // Database connection
    $servername = "localhost";
    $username   = "root"; 
    $password   = "";     
    $dbname     = "store_db"; 

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    // Handle Add to Cart
    if (isset($_POST['add_to_cart'])) {
        $product_id    = $_POST['id'];
        $product_name  = $_POST['name'];
        $product_price = $_POST['price'];
        $product_image = $_POST['image'];

        $cart_item = [
            'id'    => $product_id,
            'name'  => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'qty'   => 1
        ];

        // If cart session not exists, create it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product already exists in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['qty']++;
                $found = true;
                break;
            }
        }

        // If not found, add new item
        if (!$found) {
            $_SESSION['cart'][] = $cart_item;
        }


    }

    // Fetch products
    $sql = "SELECT id, name, description, price, status, image FROM products ORDER BY id DESC";
    $result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.cdnfonts.com/css/khmer" rel="stylesheet">
    <link rel="preload" href="KHKSHSub2.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="css/index_items_homepage.css">
</head>
<body>
    <main>
        <section>
            <div class="header">
                <img src="My pic/rashid-gW6r194IEQM-unsplash.jpg" alt="" class="image">
                <div class="navbar">
                    <div class="logo"></div>

                    <div class="menu">
                        <li><a href="#">Homepage</a></li>
                        <li><a href="Dashbaord.php">Dashbaord</a></li>
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Collection</a></li>
                    </div>

                    <div class="btn">
                        <button><a class="cart-link" href="view_cart.php"><i class="fa-solid fa-cart-shopping"></i> (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></button>
                        <button><a class="cart-link" href="#"><i class="fa-solid fa-circle-user"></i></a></button>
                    </div>
                </div>
            </div>        
        </section>
        <section>
            <header>
                <div class="productor">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { ?>
                            
                                <div class="product">
                                    <a href="products_details.php?id=<?php echo $row['id']; ?>"><img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"></a>
                                    <h3><?php echo $row['name']; ?></h3>
                                    <div class="price">$ <?php echo $row['price']; ?></div>
                                    <button class="status"><?php echo $row['status']; ?></button>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                        <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                                        <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                                        <div class="btn_add">
                                            <button type="submit" name="add_to_cart" class="add_to_cart"><i class="fa-solid fa-cart-shopping"></i></button>
                                            
                                        </div>

                                    </form>
                                </div>

                        <?php }
                    } else {
                        echo "<p>No products found.</p>";
                    }
                    $conn->close();
                    ?>
                </div>
            </header>
        </section>

        <section>
            <footer>
                <div class="left-footer">
                    <h2>SHOES FASHTION</h2>
                    <P>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus qui praesentium, 
                        quaerat voluptatum voluptas, veniam perferendis aperiam impedit aut quae expedita, 
                        rerum doloribus! Corrupti, ducimus excepturi</P>
                </div>
                <div class="right-footer">
                    <div class="footer-list">
                        <h2>SHOP</h2>
                        <p>All Collections</p>
                        <p>Winter Edition</p>
                        <p>Discount</p>
                    </div>
                    <div class="footer-list">
                        <h2>COMPANY</h2>
                        <p>About Us</p>
                        <p>Contact</p>
                        <p>Affiliates</p>
                    </div>
                    <div class="footer-list">
                        <h2>SUPPORT</h2>
                        <p>FAQs</p>
                        <p>Cookie Polocy</p>
                        <p>Terms of Use</p>
                    </div>
                    <div class="footer-list">
                        <h2>PAYMENT MEHTOD</h2>
                        <a href="#"><i class="fa-brands fa-cc-mastercard"></i></a>
                        <a href="#"><i class="fa-brands fa-cc-paypal"></i></a>
                        <a href="#"><i class="fa-brands fa-cc-visa"></i></a>
                        <a href="#"><i class="fa-brands fa-cc-stripe"></i></a>
                    </div>
                </div>
            </footer>
        </section>
    </main>
</body>
</html>