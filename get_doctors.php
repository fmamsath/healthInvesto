<?php
// Include database configuration
include_once("db_config.php");

if(isset($_POST['hospital_id'], $_POST['specialization_id'])) {
    $hospitalId = $_POST['hospital_id'];
    $specializationId = $_POST['specialization_id'];

    // Query to fetch doctors based on hospital_id and specialization_id
    $sql = "SELECT doctor_name FROM doctors WHERE hospital_id = $hospitalId AND specialization_id = $specializationId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $doctorNames = [];
        while ($row = $result->fetch_assoc()) {
            $doctorNames[] = $row['doctor_name'];
        }
        // Output the comma-separated list of doctor names
        echo implode(',', $doctorNames);
    } else {
        // No doctors found
        echo "No Doctors found";
    }
} else {
    // Invalid request
    echo "Invalid request";
}
?>
