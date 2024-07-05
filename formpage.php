<?php
session_start();
$status = "";
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: signup.php");
    exit();
}
$username=$_SESSION['username'];

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
      background-image: url('bgimage15.jpg');
      background-size: cover;
        background-position: center;
        background-attachment: fixed;
      font-family: Helvetica,Arial,Hiragino Sans GB,STXihei,Microsoft YaHei,WenQuanYi Micro Hei,Hind,MS Gothic,Apple SD Gothic Neo,NanumBarunGothic,sans-serif;
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
      font-size:x-large
      font-color: #01372d;
      
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
  <?php echo '<h1>Hello, ' . $_SESSION['username'] . '!</h1><br>'; ?>
    </div>
    <div class="container2"> 
    <h2>Welcome to Skin Solución</h2>
    </div>
    <div class="container">
    
    <a href="http://localhost/project/questions.php"><p>Let's take a quiz to know your skin better</p></a> 
    </div>
</body>
</html>