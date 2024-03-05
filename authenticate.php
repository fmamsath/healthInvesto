<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practice";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['user_type'] = $row['user_type'];
    
    if ($row['user_type'] === 'hospital_admin') {
        header("Location: hospitaladmin.php"); // Redirect to hospital_admin.php
        exit();
    } elseif ($row['user_type'] === 'superuser') {
        header("Location: dashboard.php"); // Redirect to dashboard.php for superuser
        exit();
    } else {
        echo "Invalid user type";
    }
} else {
    echo "Invalid username or password";
}

$conn->close();
?>

