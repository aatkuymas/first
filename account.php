<?php
session_start();
$status = "";
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: signup.php");
    exit();
}

// Database connection settings (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skinproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = $_SESSION['username'];
// Get user's skin type
$stmt = $conn->prepare("SELECT skintype FROM login WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$sql = "SELECT skintype FROM login WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $skintype = $row['skintype'];  // Store skin type in a variable
} else {
    $skintype = "";  // Set to empty string if no skin type found
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skin Solución</title>
    <style>
        body {
            background-color: rgb(155, 226, 185);
            background-image: url('bgimage24.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Helvetica, Arial, Hiragino Sans GB, STXihei, Microsoft YaHei, WenQuanYi Micro Hei, Hind, MS Gothic, Apple SD Gothic Neo, NanumBarunGothic, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container1 {
            max-width: 800px;
            margin: 50px;
            text-align: left;
            font-size: xx-large
        }

        .container2 {
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
            font-size: x-large font-color: #01372d;

        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
            font-weight: bold;
            font-size: x-large;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #01372d;

        }

        h2 {
            font-size: 2em;
            line-height: 1.5;
            color: #01372d;

        }

        a {
            color: #01372d;
            text-decoration: none;

        }
    </style>
</head>

<body>
    <div class="container1">
        <?php echo '<h1>Welcome back, ' . $_SESSION['username'] . '!</h1><br>'; ?>
    </div>
    <div class="container2">
    <a href="http://localhost/project/products.php">
        <?php echo '<h2>Your skin type is, ' . $skintype . '!</h2><br>'; ?>
    </div>
    <div class="container">

        <a href="http://localhost/project/questions.php">
            <p>Do you wish to retake the quiz?</p>
        </a>
    </div>

</body>

</html>