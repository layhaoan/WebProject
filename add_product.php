<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: sans-serif;
        }
        .container{
            position: absolute;
            transform: translate(-50%,-50%);
            top: 50%;
            left: 50%;
            width: 600px;
            height: 830px;
            background: #fff;
            box-shadow: 0 5px 8px 0 rgba(0,0,0,0.2);
        }
        h2{
            text-align: center;
            justify-content: center;
            margin-top: 34px;
            font-size: 2.1rem;
        }
        form{
            margin-left: 100px;
            margin-top: 40px;
        }
        input, textarea{
            width: 80%;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 1rem;
            border: 1px solid #989898;
            outline: none;
  
        }
        textarea{
            width: 80%;
            height: 100px;
            padding: 10px 10px;
            border-radius: 8px;
            font-size: 1rem;
            border: 1px solid #989898;
            font-family: sans-serif;
            outline: none;
            position: relative;
            top: 10px;
        }
        .image{
            width: none;
            padding: none;
            border-radius:none;
            box-shadow: none;
        }
        button{
            width: 100px;
            height: 35px;
            background: #0000ff;
            color: #fff;
            font-size: 0.9rem;
            border: 1px solid #989898;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
        }
        .back{
            width: 100px;
            height: 35px;
            background: none;
            color: #535353;
            font-size: 0.9rem;
            border: 1px solid #989898;
            border-radius: 8px;
            cursor: pointer;
        }
        .back a{
            text-decoration: none;
        }
        #preview {
            margin-top: 5px;
            width: 170px;
            height: 120px;
            border: 2px solid #ccc;
            padding: 5px;
            display: none;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container">
          <h2>Add Product</h2>
            <form action="insert_product.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Product Name" required><br><br>

                <input type="text" name="price" placeholder="Price" required><br><br>

                <input type="text" name="types" placeholder="types" required><br><br> 
                
                <input type="number" name="qaunlity" placeholder="qaunlity" required><br><br> 

                <input type="number" name="discount" placeholder="discount" ><br><br>

                <textarea name="description" placeholder="Description"></textarea><br><br>

                <input type="file" name="image" class="image" accept="image/*" onchange="previewImage(event)"><br><br>
                <img id="preview" src="#" alt="Image Preview">
                
                <button type="submit" name="submit">Save</button>
                <button class="back"><a href="stock-products.php"> back</a></button>
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
