<?php
$conn = new mysqli("localhost", "root", "","skinproject");
$status = "";
if(isset($_POST['new']) && $_POST['new']==1)
{
    $username =$_REQUEST['username'];
    $password = $_REQUEST['password'];
    $phone = $_REQUEST['phone'];
    $email = $_REQUEST['email'];
    $ins_query="insert into login
    (`username`,`password`,`phone`,`email`)values
    ('$username','$password','$phone','$email')";
    mysqli_query($conn,$ins_query)or die(mysql_error());
   $status = 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
        body {
            font-family:  Helvetica,Arial,Hiragino Sans GB,STXihei,Microsoft YaHei,WenQuanYi Micro Hei,Hind,MS Gothic,Apple SD Gothic Neo,NanumBarunGothic,sans-serif;;
            background-color: #f0f0f0; /* Light Gray */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('bgimage7.jpg'); /* Specify your background image path */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the background image */
        }

        .signup-container {
            background-color: #ffffff5a;
            padding: 17px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 345px;
            text-align: center;
            font-weight: bold;
        }

        .signup-container h2 {
            margin-bottom: 20px;
            color: #0b381e; 
            font-weight: bold;
        }

        .signup-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #0b381e; 
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            background-color: #7bc99b; 
            color: #0b381e;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .form-group button:hover {
            background-color: #0b381e; /* Darker Pink on hover */
        }

        .back-link {
            margin-top: 15px;
            color: #0b381e; /* Pink */
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Signup</h2>
    <form action="formpage.html" method="GET"> 
    <form class="signup-form">
     
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
        </div>
        <div class="form-group">
            <button type="submit">Signup</button>
        </div>
        <div>
            <!-- Back link to login page -->
            <a href="login.html" class="back-link">Already have an account? Login here.</a><br>
            <a href="mainpage.html" class="back-link">Back to the main page</a>
            
        </div>
       
    </form>


</div>


<?php 
if($status==1){
$status="Successfully Added";
echo "<script type='text/javascript'>alert('$status');</script>";
}
?>
</center>
</body>
</html>
