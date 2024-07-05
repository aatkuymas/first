<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs (not shown here, ensure you do this)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch hashed password based on username
    $stmt = $conn->prepare("SELECT password FROM login WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the submitted password against the hashed password
        if (password_verify($password, $hashed_password)) {
            // Login successful - set session variables and redirect
            $_SESSION['username'] = $username;
            header("Location: homepagelogin.html");
            exit();
        } else {
            // Login failed - display error message
            $error = "Invalid username or password";
        }
    } else {
        // User not found - display error message
        $error = "Invalid username or password";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Helvetica,Arial,Hiragino Sans GB,STXihei,Microsoft YaHei,WenQuanYi Micro Hei,Hind,MS Gothic,Apple SD Gothic Neo,NanumBarunGothic,sans-serif;
            background-color: #f0f0f0; /* Light Gray */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('bgimage4.jpg'); /* Specify your background image path */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the background image */
        }

        .login-container {
            background-color: #ffffff5a;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #194e2f; 
            font-weight: bold;
        }

        .login-form {
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
            color: #082d18; 
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
            color: #082d18;
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
            background-color: #082d18; 
        }

        .back-link {
            margin-top: 15px;
            color: #082d18; 
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
<?php if (isset($error)): ?>
  <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<div class="login-container">
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
    <form class="login-form">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit">Login</button>
        </div>
        <div>
               <!-- Back link to signup page -->
            <a href="http://localhost/project/signup.php" class="back-link">Don't have an account? Sign up here.</a><br>
            <a href="mainpage.html" class="back-link">Back to the main page</a><br>
            <a href="forgot_password.html" class="back-link">Forgot Password?</a> <!-- Link to password recovery page -->
        </div>
    
        </div>
    </form>

 
</div>

<?php if(isset($error)) { echo "<p>$error</p>"; } ?>

</body>
</html>