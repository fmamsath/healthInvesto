<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['user_type'] !== 'superuser') {
    echo "You do not have permission to access this page.";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practice";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add hospital admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_hospital_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (username, password, user_type) VALUES ('$username', '$password', 'hospital_admin')";

    if ($conn->query($sql) === TRUE) {
        echo "Hospital admin added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// View hospital admins
$sql = "SELECT user_id, username, user_type FROM users WHERE user_type='hospital_admin'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button[type="submit"][name="add_hospital_admin"] {
            background-color: #007bff;
        }
        button[type="submit"][name="logout"] {
            background-color: #28a745; /* Green */
        }
        button[type="reset"][name="clear"] {
            background-color: #dc3545; /* Red */
        }
        button {
            padding: 8px 20px;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            opacity: 0.8;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Hospital Admin</h2>
        <form action="" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit" name="add_hospital_admin">Add Hospital Admin</button>
                <button type="submit" name="logout">Logout</button>
                <button type="reset" name="clear">Clear</button>
            </div>
        </form>

        <hr>

        <?php
        if ($result->num_rows > 0) {
            echo "<h2>List of Hospital Admins</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>Username: " . $row["username"] . " | User Type: " . $row["user_type"] . " | <a href='delete_user.php?id=" . $row["user_id"] . "'>Delete</a></li>";
            }
            echo "</ul>";
        } else {
            echo "No hospital admins found";
        }
        ?>

    </div>
</body>
</html>

<?php
$conn->close();
?>
