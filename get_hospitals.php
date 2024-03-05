<?php
// Include database configuration
include_once("db_config.php");

// Fetch hospitals from the database
$sql = "SELECT * FROM hospitals";
$result = $conn->query($sql);

$options = "<option value=''>Select Hospital</option>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['hospital_id'] . "'>" . $row['hospital_name'] . "</option>";
    }
}

// Return the options as a response
echo $options;
?>
