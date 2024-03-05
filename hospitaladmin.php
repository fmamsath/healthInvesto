<?php
session_start();
// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

include_once("db_config.php");

// Fetch specializations from the database
$sql_specializations = "SELECT * FROM specializations";
$result_specializations = $conn->query($sql_specializations);

// Fetch hospitals from the database
$sql_hospitals = "SELECT * FROM hospitals";
$result_hospitals = $conn->query($sql_hospitals);

// Add doctor to the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_doctor'])) {
  $doctor_name = $_POST['doctor_name'];
  $specialization_id = $_POST['specialization_id'];
  $hospital_id = $_POST['hospital_id'];
  $schedule_date = $_POST['schedule_date'];

  $sql = "INSERT INTO doctors (doctor_name, specialization_id, hospital_id, schedule_date) 
          VALUES ('$doctor_name', '$specialization_id', '$hospital_id', '$schedule_date')";

  if ($conn->query($sql) === TRUE) {
    echo "Doctor added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Fetch appointments from the database
$sql_appointments = "SELECT appointments.*, hospitals.hospital_name, specializations.specialization_name
                     FROM appointments
                     INNER JOIN hospitals ON appointments.hospital_id = hospitals.hospital_id
                     INNER JOIN specializations ON appointments.specialization_id = specializations.specialization_id";
$result_appointments = $conn->query($sql_appointments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Doctor</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2>Add New Doctor</h2>
    <form method="post" action="">
      <div class="form-group">
        <label for="doctor_name">Doctor Name:</label>
        <input type="text" class="form-control" id="doctor_name" name="doctor_name" required>
      </div>
      <div class="form-group">
        <label for="specialization_id">Specialization:</label>
        <select class="form-control" id="specialization_id" name="specialization_id" required>
          <option value="">Select Specialization</option>
          <?php
            if ($result_specializations->num_rows > 0) {
              while ($row = $result_specializations->fetch_assoc()) {
                echo "<option value='" . $row['specialization_id'] . "'>" . $row['specialization_name'] . "</option>";
              }
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="hospital_id">Hospital Name:</label>
        <select class="form-control" id="hospital_id" name="hospital_id" required>
          <option value="">Select Hospital</option>
          <?php
            if ($result_hospitals->num_rows > 0) {
              while ($row = $result_hospitals->fetch_assoc()) {
                echo "<option value='" . $row['hospital_id'] . "'>" . $row['hospital_name'] . "</option>";
              }
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="schedule_date">Schedule Date:</label>
        <input type="datetime-local" class="form-control" id="schedule_date" name="schedule_date" required>
      </div>
      <button type="submit" class="btn btn-primary" name="add_doctor">Add Doctor</button>
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </form>

    <hr>

    <h2>Appointment List</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Doctor Name</th>
          <th>Specialization</th>
          <th>Hospital</th>
          <th>Schedule Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if ($result_appointments->num_rows > 0) {
            while ($row = $result_appointments->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['doctor_name'] . "</td>";
              echo "<td>" . $row['specialization_name'] . "</td>";
              echo "<td>" . $row['hospital_name'] . "</td>";
              echo "<td>" . $row['schedule_date'] . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No appointments found</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
