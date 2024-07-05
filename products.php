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

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $skintype = $row['skintype']; // Store skin type in a variable
} else {
    $skintype = ""; // Set to empty string if no skin type found
}

// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM toner WHERE skintype=?");
$stmt->bind_param("s", $skintype);
$stmt->execute();
$result = $stmt->get_result();
$tonerRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($tonerRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM spf WHERE skintype=?");
$stmt->bind_param("s", $skintype);
$stmt->execute();
$result = $stmt->get_result();
$spfRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($spfRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM masks WHERE skintype=?");
$stmt->bind_param("s", $skintype);
$stmt->execute();
$result = $stmt->get_result();
$masksRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($masksRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM eyecream WHERE skintype=?");
$stmt->bind_param("s", $skintype);
$stmt->execute();
$result = $stmt->get_result();
$eyecreamRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($eyecreamRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM moisturizer WHERE skintype=?");
$stmt->bind_param("s", $skintype);
$stmt->execute();
$result = $stmt->get_result();
$moisturizerRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($moisturizerRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM cleanser WHERE skintype=?");
$stmt->bind_param("s", $skintype);
$stmt->execute();
$result = $stmt->get_result();
$cleanserRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($cleanserRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM serum WHERE skintype=?");
$stmt->bind_param("s", $skintype);
$stmt->execute();
$result = $stmt->get_result();
$serumRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($serumRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$stmt = $conn->prepare("SELECT pname FROM lipcare");
$stmt->execute();
$result = $stmt->get_result();
$lipcareRecommendations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['pname'];
        array_push($lipcareRecommendations, $productName); // Add toner names to array using array_push
    }
}
// Close the connection used for toner recommendations
// Close connection used for getting skin type
$stmt->close();

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Recommendations</title>
    <style>
        body {
            background-color: rgb(155, 226, 185);
            background-image: url('bgimage25.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Helvetica, Arial, Hiragino Sans GB, STXihei, Microsoft YaHei, WenQuanYi Micro Hei, Hind, MS Gothic, Apple SD Gothic Neo, NanumBarunGothic, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Style for the content */
        .container {
            max-width: 800px;
            /* Adjust the maximum width of your content */
            margin: 0 auto;
            /* Center the content horizontally */
            padding: 20px;
            /* Add some padding */
            background-color: rgba(255, 255, 255, 0.7);
            /* Add a semi-transparent white background to improve readability */
            border-radius: 10px;
            /* Add some border radius to round the corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            /* Add a subtle shadow effect */
        }

        h1 {

            margin-left: 50px;
            color: #194e2f;
            font-size: xx-large;
            /* Align the title to the right */
        }

        ul {
            color: #193e2f;
            list-style-type: square;
            text-align: left;
            font-size: x-large;

        }
        .form-group2 {
            margin-right: 50px;
            color: #333b32; /* Pink */
            text-decoration: none;
            font-size: 30px;
            font-weight: bold;
            text-align: right;
        }

        .account-link {
            position: absolute;
            top: 32px; /* Adjusted top margin */
            right: 0;
            font-size: x-large;

        }
    </style>

</head>

<body>
    <div class="account-link">
        <a href="http://localhost/project/homepagelogin.html" class="form-group2">go back to home♡</a><br>
    </div>
    <?php
    // Display message if no skin type found
    if (empty($skintype)) {
        echo "<h1>We couldn't find your skin type yet. Please complete the skin assessment quiz for personalized recommendations.</h1>";
    } else {
        echo "<h1>Recommended toners for $skintype skin:</h1>";
        // Display recommended toners list (if any)
        if (!empty($tonerRecommendations)) {
            echo "<ul>";
            foreach ($tonerRecommendations as $toner) {
                echo "<li>$toner</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No toner recommendations found for this skin type yet.</p>";
        }

        echo "<h1>Recommended spf for $skintype skin:</h1>";
        // Display recommended toners list (if any)
        if (!empty($spfRecommendations)) {
            echo "<ul>";
            foreach ($spfRecommendations as $spf) {
                echo "<li>$spf</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No spf recommendations found for this skin type yet.</p>";
        }

        echo "<h1>Recommended masks for $skintype skin:</h1>";
        // Display recommended toners list (if any)
        if (!empty($masksRecommendations)) {
            echo "<ul>";
            foreach ($masksRecommendations as $masks) {
                echo "<li>$masks</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No masks recommendations found for this skin type yet.</p>";
        }

        echo "<h1>Recommended eyecreams for $skintype skin:</h1>";
        // Display recommended toners list (if any)
        if (!empty($eyecreamRecommendations)) {
            echo "<ul>";
            foreach ($eyecreamRecommendations as $eyecream) {
                echo "<li>$eyecream</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No eyecream recommendations found for this skin type yet.</p>";
        }

        echo "<h1>Recommended moisturizer for $skintype skin:</h1>";
        // Display recommended toners list (if any)
        if (!empty($moisturizerRecommendations)) {
            echo "<ul>";
            foreach ($moisturizerRecommendations as $moisturizer) {
                echo "<li>$moisturizer</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No moisturizer recommendations found for this skin type yet.</p>";
        }

        echo "<h1>Recommended cleanser for $skintype skin:</h1>";
        // Display recommended toners list (if any)
        if (!empty($cleanserRecommendations)) {
            echo "<ul>";
            foreach ($cleanserRecommendations as $cleanser) {
                echo "<li>$cleanser</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No cleanser recommendations found for this skin type yet.</p>";
        }

        echo "<h1>Recommended serum for $skintype skin:</h1>";
        // Display recommended toners list (if any)
        if (!empty($serumRecommendations)) {
            echo "<ul>";
            foreach ($serumRecommendations as $serum) {
                echo "<li>$serum</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No serum recommendations found for this skin type yet.</p>";
        }

        echo "<h1>Recommended lipcare:</h1>";
        // Display recommended toners list (if any)
        if (!empty($lipcareRecommendations)) {
            echo "<ul>";
            foreach ($lipcareRecommendations as $lipcare) {
                echo "<li>$lipcare</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No lipcare recommendations found for this skin type yet.</p>";
        }

    }
    ?>
</body>

</html>