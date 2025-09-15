<?php
$conn = new mysqli("localhost", "root", "", "store_db");
$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Product Slider</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://fonts.cdnfonts.com/css/khmer" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    h1 {
      text-align: center;
      margin-top: 30px;
      color: #333;
    }

    .slider-container {
      position: relative;
      width: 80%;
      height: 460px;
      margin: 30px auto;
      overflow: hidden;
    }

    .slider-track {
      display: flex;
      transition: transform 0.5s ease;
    }

    .product-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      width: 350px;
      height: 450px;
      margin: 0 10px;
      text-align: center;
      flex-shrink: 0;
      position: relative;
      left: 10px;

    }

    .product-card img {
      width: 100%;
      height: 82%;
      object-fit: cover;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .product-card h3 {
      margin: 10px 0 5px;
      font-size: 1.2rem;
      position: absolute;
      margin-left: 15px;
    }

    .product-card p {
      color: #666;
      font-size: 14px;
      position: absolute;
      bottom: 5px;
      margin-left: 15px;
    }

    .slider-btn {
      position: absolute;
      top: 40%;
      transform: translateY(-50%);
      background: #444;
      color: #fff;
      border: none;
      font-size: 20px;
      cursor: pointer;
      padding: 10px 10px;
      border-radius: 50%;
    }

    .slider-btn.left {
      left: 10px;
      position: absolute;
      z-index: 100;
    }

    .slider-btn.right {
      right: 10px;
    }
  </style>
</head>
<body>

<h1>Our Products</h1>

<div class="slider-container">
  <button class="slider-btn left" onclick="slide(-1)"><i class="fa-solid fa-chevron-left"></i></button>

  <div class="slider-track" id="sliderTrack">
    <?php while($row = $result->fetch_assoc()) { ?>
      <div class="product-card">
        <a href="products_details.php?id=<?php echo $row['id']; ?>"><img src="uploads/<?php echo $row['image']; ?>" alt=""></a>
        <h3><?php echo $row['name']; ?></h3>
        <p>$<?php echo $row['price']; ?></p>
      </div>
    <?php } ?>
  </div>

  <button class="slider-btn right" onclick="slide(1)"><i class="fa-solid fa-chevron-right"></i></button>
</div>

<script>
  let position = 0;
  const track = document.getElementById('sliderTrack');
  const cardWidth = 240; // 220px card + 20px margin

  function slide(direction) {
    const maxScroll = track.scrollWidth - track.parentElement.clientWidth;
    position += direction * cardWidth;

    if (position < 0) position = 0;
    if (position > maxScroll) position = maxScroll;

    track.style.transform = `translateX(-${position}px)`;
  }
</script>

</body>
</html>
