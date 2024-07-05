<?php
// Start the session
session_start();

// Database connection settings
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

// Fetch form responses from the database based on the logged-in user's username
$username = $_SESSION['username']; // Assuming username is stored in session

// Use prepared statement to prevent SQL injection
$sql = "SELECT * FROM responses WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Extract responses from the database
    $row = $result->fetch_assoc();
    $responses = [
        $row['question1'],
        $row['question2'],
        $row['question3'],
        $row['question4'],
        $row['question5'],
        $row['question6'],
        $row['question7'],
        $row['question8'],
        $row['question9'],
        $row['question10']
    ];

    // Encode responses to JSON string
    $responsesJson = json_encode($responses);
    $userInputEscaped = escapeshellarg($responsesJson);

    // Adjust Python script path and command for Windows
    $pythonScriptPath = "C:\\xampp\\htdocs\\project\\analyze_skin_type.py"; // Update this with the correct path
    $command = "python " . escapeshellarg($pythonScriptPath) . " " . $userInputEscaped . " " . $username . " 2>&1"; // Pass username as argument

    // Execute the command
    $output = shell_exec($command);
    // Display the analysis result or error messages
    if ($output !== null) {
        // Update responses table with skin type analysis result
        $updateq_sql = "UPDATE responses SET skintype = ? WHERE username = ?";
        $updateq_stmt = $conn->prepare($updateq_sql);
        $updateq_stmt->bind_param("ss", $output, $username);

        $updatel_sql = "UPDATE login SET skintype = ? WHERE username = ?";
        $updatel_stmt = $conn->prepare($updatel_sql);
        $updatel_stmt->bind_param("ss", $output, $username);

        if ($updateq_stmt->execute() && $updatel_stmt->execute()) {
            $status = 1;
        } else {
            echo "Failed to add skintype (" . $conn->errno . ") " . $conn->error;
        }

        $updateq_stmt->close();
        $updatel_stmt->close();

    } else {
        echo "Error executing Python script or no output received.";
    }
} else {
    echo "No responses found in the database for the logged-in user.";
}

// Close connections
$stmt->close();
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
            background-image: url('bgimage23.jpg');
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
        <?php echo '<h1>So, ' . $_SESSION['username'] . '!</h1><br>'; ?>
    </div>
    <div class="container2">
        <?php echo '<h2>Your skin type is, ' . $output . ':)</h2><br>'; ?>
    </div>
    <div class="container">

        <a href="http://localhost/project/products.php">
            <p>Let's recommend you products based on your skintype!</p>
        </a>
    </div>

    <?php
    if ($status == 1) {
        $status = "Skintype Successfully Added";
        echo "<script type='text/javascript'>alert('$status');</script>";
        exit();
    }
    ?>
</body>

</html>