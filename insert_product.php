<?php
include "db.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $types = $_POST['types'];
    $qaunlity = $_POST['qaunlity'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];
    
    // Image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, price, types, qaunlity, description, discount, image) VALUES
         ('$name', '$price', '$types', '$qaunlity', '$description', '$discount', '$image')";
        if ($conn->query($sql) === TRUE) {
            header("Location: stock-products.php"); // Redirect after success
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>
