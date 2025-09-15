<?php
$conn = new mysqli("localhost", "root", "", "store_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = $conn->query("SELECT * FROM categories WHERE id=$id");
if (!$result || $result->num_rows == 0) die("Category not found.");
$category = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $types = $conn->real_escape_string($_POST['types']);
    $status = $conn->real_escape_string($_POST['status']);
    $price = $conn->real_escape_string($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);
    $image = $category['image']; // default old image

    if (!empty($_FILES['image']['name'])) {
        $types = $_FILES['types']['types'];
        $status = $_FILES['status']['status'];
        $price = $_FILES['price']['price'];
        $image = $_FILES['image']['name'];
        $description = $_FILES['description']['description'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $conn->query("UPDATE categories SET name='$name', types='$types', status='$status',price='$price', description='$description', image='$image' WHERE id=$id");
    header("Location: categories_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Category</title>
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
        left: 30px;
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
        margin: 20px;
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
        <div class="container">
          <h2>Edit Category</h2>
          <form method="post" enctype="multipart/form-data">
              
               <div class="enter-data">  
                    <div class="insertCate">
                        <p>Category Name</p>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                    </div>
                    <div class="insertCate">
                        <p>Category Types</p>
                        <input type="text" name="types" value="<?php echo htmlspecialchars($category['types']); ?>" required>
                    </div>
                    <div class="insertCate">
                        <p>Category Status</p>
                        <input type="text" name="status" value="<?php echo htmlspecialchars($category['status']); ?>" required>
                    </div>
                    <div class="insertCate">
                        <p>Price</p>
                        <input type="number" name="price" value="<?php echo htmlspecialchars($category['price']); ?>" required>
                    </div>
                    <div class="insertCate">
                        <p>Description</p>
                        <textarea name="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
                    </div>

                    <div class="insert_img">
                        <input type="file" name="image"><br><br>
                        <p>Current Image:</p>
                        <img id="preview" src="uploads/<?php echo htmlspecialchars($category['image']); ?>" width="100"><br><br>
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" name="update">Update</button>
                    <button type="button"><a href="categories_list.php">Cancel</a></button>
                </div>
          </form>
        </div>

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
