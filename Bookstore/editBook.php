<html>
<head>
    <title>Edit Book</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
if (isset($_SESSION['id'])) {
    echo '<header>';
    echo '<blockquote>';
    echo '<a href="index.php"><img src="image/logo1.png"></a>';
    echo '<form class="hf" action="logout.php"><input class="hi" type="submit" name="submitButton" value="Logout"></form>';
    echo '</blockquote>';
    echo '</header>';
} else {
    echo '<header>';
    echo '<blockquote>';
    echo '<a href="index.php"><img src="image/logo1.png"></a>';
    echo '<form class="hf" action="login.php"><input class="hi" type="submit" name="submitButton" value="Login"></form>';
    echo '</blockquote>';
    echo '</header>';
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookID = $_POST['BookID'];
    $bookTitle = $_POST['BookTitle'];
    $isbn = $_POST['ISBN'];
    $price = $_POST['Price'];
    $author = $_POST['Author'];
    $type = $_POST['Type'];
    
    // Handling image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);  // Create the directory if it doesn't exist
    }
    
    // Check if the image is valid
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert book into the database
        $sql = "INSERT INTO book (BookID, BookTitle, ISBN, Price, Author, Type, Image)
                VALUES ('$bookID', '$bookTitle', '$isbn', '$price', '$author', '$type', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New book inserted successfully!</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<p>Sorry, there was an error uploading your image.</p>";
    }
}
$conn->close();
?>

<blockquote>
<div class="container">
<h2>Add New Book</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label for="BookID">Book ID:</label><br>
    <input type="text" id="BookID" name="BookID"  placeholder="B-001"required><br><br>
    
    <label for="BookTitle">Book Title:</label><br>
    <input type="text" id="BookTitle" name="BookTitle" placeholder="Book Title" required><br><br>
    
    <label for="ISBN">ISBN:</label><br>
    <input type="text" id="ISBN" name="ISBN"  placeholder="123-456-789-1" required><br><br>
    
    <label for="Price">Price:</label><br>
    <input type="text" id="Price" name="Price" placeholder="00.00" required><br><br>
    
    <label for="Author">Author:</label><br>
    <input type="text" id="Author" name="Author" placeholder="Author Name" required><br><br>
    
    <label for="Type">Type:</label><br>
    <input type="text" id="Type" name="Type" placeholder="Book Type: Travel,Technology,food....." required><br><br>
    
    <label for="image">Upload Image:</label><br>
    <input type="file" id="image" name="image" required><br><br>
    
    <input class="button" type="submit" value="Insert Book">
</form>
</div>
</blockquote>
</body>
</html>
