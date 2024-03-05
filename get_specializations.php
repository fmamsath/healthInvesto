<?php
// Include database configuration
include_once("db_config.php");

// Fetch all specializations from the database
$sql = "SELECT * FROM specializations";
$result = $conn->query($sql);

// Generate options for the specialization dropdown
$options = "<option value=''>Select Specialization</option>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Concatenate options string with each specialization
        $options .= "<option value='". $row['specialization_id'] . "'>". $row['specialization_name'] . "</option>";
    }
}

// Return the options as a response
echo $options;
?>
