<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .center {
            width: 300px;
            margin: 100px auto;
            padding: 30px;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 12px #aaa;
            text-align: center;
        }
        .center label {
            display: block;
            margin-top: 15px;
            font-size: 1.1em;
        }
        .center input[type="text"],
        .center input[type="number"] {
            width: 90%;
            padding: 8px;
            margin-top: 5px;
            font-size: 1em;
        }
        .center input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="center">
    <h2>Submit Your Information</h2>
    <form action="index.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required min="0">
        <input type="submit" value="Submit">
    </form>
</div>

<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection credentials
    $servername = "database-1.cxy04meq291h.us-east-2.rds.amazonaws.com";
    $username = "admin";
    $password = "Dbadmin123";
    $dbname = "user_information"; // Replace with your database name

    // Get form data
    $name = $_POST['name'];
    $age = $_POST['age'];

    // Create connection to the RDS MySQL database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("<div class='center'><h2>Connection failed: " . $conn->connect_error . "</h2></div>");
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO user_data (name, age) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $age);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<div class='center'><h2>Thank you, your data has been submitted!</h2>";
        echo "<p>Name: " . htmlspecialchars($name) . "</p>";
        echo "<p>Age: " . htmlspecialchars($age) . "</p></div>";
    } else {
        echo "<div class='center'><h2>Error: " . $stmt->error . "</h2></div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
