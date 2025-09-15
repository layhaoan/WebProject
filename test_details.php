<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("No product ID given.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}
?>


<!DOCTYPE html>
<html>
<head>
  <title><?php echo $product['name']; ?> - Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding: 30px;
    }
    .product-box {
      display: flex;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .product-box img {
      width: 300px;
      height: 300px;
      object-fit: cover;
      border-radius: 10px;
      margin-right: 30px;
    }
    .info h2 {
      margin-top: 0;
    }
    .tabs {
      margin-top: 20px;
    }
    .tab-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }
    .tab-buttons button {
      padding: 10px 15px;
      border: none;
      background: #ddd;
      border-radius: 5px;
      cursor: pointer;
    }
    .tab-buttons button.active {
      background: #28a745;
      color: #fff;
    }
    .tab-content {
      display: none;
      background: #fff;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .tab-content.active {
      display: block;
    }
    .review {
      border-bottom: 1px solid #eee;
      padding: 5px 0;
    }
    form textarea, form input {
      width: 100%;
      margin-top: 5px;
      padding: 8px;
    }
    form button {
      background: #28a745;
      border: none;
      padding: 8px 15px;
      margin-top: 5px;
      color: #fff;
      cursor: pointer;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<div class="product-box">
  <img src="uploads/<?php echo $product['image']; ?>" alt="">
  <div class="info">
    <h2><?php echo $product['name']; ?></h2>
    <p>Price: $<?php echo $product['price']; ?></p>
    <form method="post" action="add_to_cart.php">
      <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
      <input type="number" name="quantity" value="1" min="1" style="width:70px;">
      <button type="submit">Add to Cart</button>
    </form>
  </div>
</div>

<div class="tabs">
  <div class="tab-buttons">
    <button class="active" onclick="openTab('infoTab')">Additional Information</button>
    <button onclick="openTab('reviewsTab')">Reviews</button>
  </div>

  <div id="infoTab" class="tab-content active">
    <h3>Description</h3>
    <p><?php echo $product['description']; ?></p>
    <p><b>Category:</b> <?php echo $product['category']; ?></p>
    <p><b>Stock:</b> <?php echo $product['stock']; ?></p>
  </div>

  <div id="reviewsTab" class="tab-content">
    <h3>Customer Reviews</h3>
    <?php while($r = $reviews->fetch_assoc()) { ?>
      <div class="review">
        <strong><?php echo $r['name']; ?>:</strong>
        <p><?php echo $r['comment']; ?></p>
      </div>
    <?php } ?>

    <h4>Leave a review</h4>
    <form method="post" action="add_review.php">
      <input type="hidden" name="product_id" value="<?php echo $id; ?>">
      <input type="text" name="name" placeholder="Your name" required>
      <textarea name="comment" placeholder="Your review" required></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
</div>

<script>
  function openTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    document.querySelectorAll('.tab-buttons button').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
  }
</script>

</body>
</html>
