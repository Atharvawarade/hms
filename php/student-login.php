<?php
session_start();

$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "hms"; // Replace with your database name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo $password;
    $entered_email =  $_POST['email'];
    $entered_password = $_POST['password'];

    $sql = "SELECT * FROM student WHERE email = '$entered_email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['EN']; // Assuming PRN is the stored password

        // Validate PRN only if the email exists in the database
        if ($entered_password == $stored_password) {
            // Passwords match, login successful
            $_SESSION['loggedin'] = true;
            // $_SESSION['email'] = $entered_email;
            $_SESSION['EN'] = $entered_password;
            header("Location:../studentDashboard.html");
            // header("Location: ../Student_Dash/Dashboard.php");
            exit;
        } else {
            echo "Incorrect password!";
        }
    } else {
        header("Location: ../warden-login.html");
    }

    $conn->close();
}
