<?php
// Include database configuration
include_once("db_config.php");

// Check if hospital_id and specialization_id are set and not empty
if(isset($_POST['hospital_id']) && !empty($_POST['hospital_id']) &&
   isset($_POST['specialization_id']) && !empty($_POST['specialization_id'])) {

    $hospital_id = $_POST['hospital_id'];
    $specialization_id = $_POST['specialization_id'];

    // Adjust the SQL query to select schedules based on hospital_id and specialization_id
    $sql = "SELECT schedule_date FROM doctors WHERE hospital_id = ? AND specialization_id = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("ii", $hospital_id, $specialization_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch the schedules and construct the options
        $schedule_dates = "";
        while ($row = $result->fetch_assoc()) {
            // Concatenate the schedule dates separated by a comma
            $schedule_dates .= $row['schedule_date'] . ",";
        }
        // Remove the trailing comma
        $schedule_dates = rtrim($schedule_dates, ",");
        echo $schedule_dates;
    } else {
        // No schedules found for the selected hospital and specialization
        echo "No Schedules found";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Invalid or missing parameters
    echo "Error in fetching schedules: Missing parameters";
}
?>
