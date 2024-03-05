<?php
// Include database configuration
include_once("db_config.php");

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $hospital_id = $_POST['hospital'];
    $specialization_id = $_POST['specialization'];
    $doctor_name = $_POST['doctor'];
    $schedule_date = $_POST['schedule'];

    // Check if all required fields are filled
    if (!empty($name) && !empty($email) && !empty($hospital_id) && !empty($specialization_id) && !empty($doctor_name) && !empty($schedule_date)) {
        // Insert data into the appointments table
        $sql = "INSERT INTO appointments (name, email, hospital_id, specialization_id, doctor_name, schedule_date) 
                VALUES ('$name', '$email', '$hospital_id', '$specialization_id', '$doctor_name', '$schedule_date')";

        // Check if the SQL query was executed successfully
        if ($conn->query($sql) === TRUE) {
            echo "Appointment booked successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "All fields are required";
    }

    // Close database connection
    $conn->close();
}
?>
