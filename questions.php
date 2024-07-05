<?php
session_start();
$status = "";
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs (not shown here, ensure you do this)
    $question1 = $_POST['question1'];
    $question2 = $_POST['question2'];
    $question3 = $_POST['question3'];
    $question4 = $_POST['question4'];
    $question5 = $_POST['question5'];
    $question6 = $_POST['question6'];
    $question7 = $_POST['question7'];
    $question8 = $_POST['question8'];
    $question9 = $_POST['question9'];
    $question10 = $_POST['question10'];
    // Get username from session
    $username = $_SESSION['username'];

    // Check if user's responses already exist
    $stmt = $conn->prepare("SELECT * FROM responses WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE responses SET question1 = ?, question2 = ?, question3 = ?, question4 = ?, question5 = ?, question6 = ?, question7 = ?, question8 = ?, question9 = ?, question10 = ? WHERE username = ?");
        $stmt->bind_param("sssssssssss", $question1, $question2, $question3, $question4, $question5, $question6, $question7, $question8, $question9, $question10, $username);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $status = 1;
        } else {
            echo "Updation failed: (" . $conn->errno . ") " . $conn->error;
        }
    } else {

        // Prepare and execute SQL statement to insert form responses
        $stmt = $conn->prepare("INSERT INTO responses (username, question1, question2, question3, question4, question5, question6, question7, question8, question9, question10) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $username, $question1, $question2, $question3, $question4, $question5, $question6, $question7, $question8, $question9, $question10);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $status = 1; // Registration successful
        } else {
            echo "Registration failed: (" . $conn->errno . ") " . $conn->error;
        }
    }

    $stmt->close(); // Close the prepared statement

    if ($status == 1) {
        $status = "Successfully Added";
        echo "<script type='text/javascript'>alert('$status');</script>";
        header("Location: analyze_skin_type.php");
        exit();
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
    <title>Multiple Choice Questionnaire1</title>
    <style>
        body {
            font-family: Helvetica, Arial, Hiragino Sans GB, STXihei, Microsoft YaHei, WenQuanYi Micro Hei, Hind, MS Gothic, Apple SD Gothic Neo, NanumBarunGothic, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('bgimage11.jpg');
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #cccccc00;
            border-radius: 5px;
            background-color: #c4e3bca2;
        }

        .question {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .options {
            font-size: medium;
            margin-bottom: 20px;
        }

        .option {
            margin-bottom: 10px;
        }

        label {
            display: block;
            cursor: pointer;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <form action="questions.php" method="POST">
        <div class="container">
            <form id="quizForm">
                <div class="question">1. How does your skin feel right after washing?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option1a" name="question1" value="a" required label for="option1a">Like
                        it needs moisturizer right away</label><br><br>
                        <input type="radio" id="option1b" name="question1" value="b" label for="option1b">Just right-
                        not too dry or too oily</label><br><br>
                        <input type="radio" id="option1c" name="question1" value="c" label for="option1c">Kind of greasy
                        or shiny.</label><br><br>
                    </div>
                </div>

                <div class="question">2. How does your skin react to moisturizers?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option2a" name="question2" value="a" required label for="option2a">They
                        tend to make me break out</label><br><br>
                        <input type="radio" id="option2b" name="question2" value="b" label for="option2b">My skin feels
                        comfortable and hydrated</label><br><br>
                        <input type="radio" id="option2c" name="question2" value="c" label for="option2c">They make my
                        skin feel too oily</label><br><br>
                    </div>
                </div>

                <div class="question">3. What happens to your skin in the sun?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option3a" name="question3" value="a" required label for="option3a">I
                        burn easily and rarely tan</label><br><br>
                        <input type="radio" id="option3b" name="question3" value="b" label for="option3b">I tan
                        gradually</label><br><br>
                        <input type="radio" id="option3c" name="question3" value="c" label for="option3c">I tan easily
                        and rarely burn</label><br><br>
                    </div>
                </div>

                <div class="question">4. How noticeable are your pores?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option4a" name="question4" value="a" required label
                            for="option4a">They're small and hardly noticeable</label><br><br>
                        <input type="radio" id="option4b" name="question4" value="b" label for="option4b">They're a
                        normal size</label><br><br>
                        <input type="radio" id="option4c" name="question4" value="c" label for="option4c">They're
                        enlarged and noticeable</label><br><br>
                    </div>
                </div>

                <div class="question">5. How often do you deal with breakouts?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option5a" name="question5" value="a" required label
                            for="option5a">Rarely or never</label><br><br>
                        <input type="radio" id="option5b" name="question5" value="b" label
                            for="option5b">Occasionally</label><br><br>
                        <input type="radio" id="option5c" name="question5" value="c" label for="option5c">Quite
                        frequently</label><br><br>
                    </div>
                </div>

                <div class="question">6. How does your skin feel by the afternoon?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option6a" name="question6" value="a" required label for="option6a">Tight
                        and dry</label><br><br>
                        <input type="radio" id="option6b" name="question6" value="b" label for="option6b">Pretty
                        normal</label><br><br>
                        <input type="radio" id="option6c" name="question6" value="c" label for="option6c">Oily or
                        Shiny</label><br><br>
                    </div>
                </div>

                <div class="question">7. How does your skin react to new skincare products?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option7a" name="question7" value="a" required label for="option7a">I
                        often get irritated or break out</label><br><br>
                        <input type="radio" id="option7b" name="question7" value="b" label for="option7b">Usually,
                        they're fine</label><br><br>
                        <input type="radio" id="option7c" name="question7" value="c" label for="option7c">Sometimes they
                        cause breakouts</label><br><br>
                    </div>
                </div>

                <div class="question">8. How would you describe the texture of your skin?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option8a" name="question8" value="a" required label for="option8a">Fine
                        and smooth</label><br><br>
                        <input type="radio" id="option8b" name="question8" value="b" label for="option8b">Balanced and
                        even</label><br><br>
                        <input type="radio" id="option8c" name="question8" value="c" label for="option8c">Coarse or
                        rough</label><br><br>
                    </div>
                </div>

                <div class="question">9. How does your skin look by the end of the day?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option9a" name="question9" value="a" required label for="option9a">Dull
                        and flaky</label><br><br>
                        <input type="radio" id="option9b" name="question9" value="b" label for="option9b">Generally
                        good</label><br><br>
                        <input type="radio" id="option9c" name="question9" value="c" label for="option9c">Shiny or
                        Greasy</label><br><br>
                    </div>
                </div>


                <div class="question">10. How does your skin react to changes in the weather?</div>
                <div class="options">
                    <div class="option">
                        <input type="radio" id="option10a" name="question10" value="a" required label for="option10a">It
                        feels tight in cold weather</label><br><br>
                        <input type="radio" id="option10b" name="question10" value="b" label for="option10b">No
                        significant changes</label><br><br>
                        <input type="radio" id="option10c" name="question10" value="c" label for="option10c">It gets
                        oilier in hot weather</label><br><br>
                    </div>
                </div>



                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>

</body>

</html>