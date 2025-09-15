<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "store_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $types = $conn->real_escape_string($_POST['types']);
    $status = $conn->real_escape_string($_POST['status']);
    $price = $conn->real_escape_string($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Upload image
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO categories (name, types, status, price, description, image) VALUES ('$name', '$types', '$status', '$price', '$description','$image')";
        if ($conn->query($sql) === TRUE) {
            header("Location: categories_list.php");
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Error uploading image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Category</title>
  <style>
    body { 
        font-family: Arial, sans-serif; 
        padding: 20px; 
        background: #f9f9f9; 
    }
    form { 
        position: absolute;
        transform: translate(-50%,-50%);
        top: 50%;
        left: 50%;
        background: #fff; 
        padding: 20px; 
        border-radius: 8px; 
        width: 580px; 
        height: 780px;
        box-shadow: 0 5px 8px 0 rgba(0,0,0,0.1);
    }
    .enter-data{
        position: absolute;
        top: 90px;
        left: 40px;
    }
    .enter-data input,textarea{
        width: 450px;
        padding: 10px 15px;
        margin: 10px;
        margin-left: 0;
        font-size: 0.9rem;
    }
    .enter-data textarea{
        height: 120px;
    }
    .insertCate {
        width: 510px;
        padding: auto;
        background: none;
        margin: 17px;
        position: relative;
    }
    .insertCate p{
        position: absolute;
        top: -17px;
        font-size: 0.92rem;
        font-weight: 300;
        left: 0;
    }
    .insertCate input, textarea{
        width: 92%;
        position: relative;
        top: 10px;
        outline: none;
        border: 1px solid #ccc
    }
    button { 
        background: #0000ff; 
        color: #fff; 
        border: none; 
        cursor: pointer; 
        border-radius: 5px; 
        padding: 10px 22px;
    }
    button:nth-child(2){
        background: none;
        border: 1px solid #888;
    }
    button:nth-child(2) a{
        color: #888;
        text-decoration: none;
    }
    button:nth-child(2):hover a{
        color: #fff;
    }
    button:hover { 
        background: #0000ff; 
    }
    .btn{
        position: absolute;
        display: flex;
        bottom: 30px;
        right: 60px;
    }
    .btn button{
        margin: 10px;
    }
    .msg { 
        margin: 10px 0; 
        color: blue; 
    }
    #preview {
        bottom: 24px;
        width: 170px;
        height: 120px;
        border: 2px solid #ccc;
        padding: 5px;
        display: none;
        object-fit: cover;
        position: relative;
        left: 15px;
    }
    h2{
        text-align: center;
        font-size: 1.5rem;
        margin-top: 20px;
    }
    .insert_img{
        position: relative;
        bottom: 38px;
        right: -5px;
    }
  </style>
</head>
<body>

    <form method="post" enctype="multipart/form-data">

        <h2>Add Category</h2>

        <?php if ($message): ?>
            <p class="msg"><?php echo $message; ?></p>
        <?php endif; ?>
        <div class="enter-data">  
            <div class="insertCate">
                <p>Category Name</p>
                <input type="text" name="name" required>
            </div>
            <div class="insertCate">
                <p>Category Types</p>
                <input type="text" name="types" required>
            </div>
            <div class="insertCate">
                <p>Category Status</p>
                <input type="text" name="status" required>
            </div>
            <div class="insertCate">
                <p>Price</p>
                <input type="text" name="price" required>
            </div>
            <div class="insertCate">
                <p>Description</p>
                <textarea name="description"></textarea><br><br>
            </div>

            <div class="insert_img">
                <input type="file" name="image" class="image" accept="image/*" onchange="previewImage(event)"><br><br>
                <img id="preview" src="#" alt="Image Preview">
            </div>
        </div>
        <div class="btn">
            <button type="submit">Add</button>
            <button type="button"><a href="categories_list.php">Cancel</a></button>
        </div>
    </form>


    <script>
        function previewImage(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
