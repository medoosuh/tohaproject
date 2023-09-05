<?php
// phpmyadmin details
$user = 'ucetak';
$password = '!Lavender_4';
$db = 'countertoha';
$host = 'localhost';

$data = array();

try {
    $con = new mysqli($host, $user, $password, $db);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Fetch X Counter data
    $sql = "SELECT value1, reading_time FROM tohadata ORDER BY reading_time DESC LIMIT 1";
    $result = $con->query($sql);
    $data['xCounter'] = $result->fetch_assoc();

    // Fetch Y Counter data
    $sql2 = "SELECT value_2, reading_time2 FROM tohadataY ORDER BY reading_time2 DESC LIMIT 1";
    $result2 = $con->query($sql2);
    $data['yCounter'] = $result2->fetch_assoc();

    // Fetch X History data from yesterday
    $sql3 = "SELECT value1, reading_time FROM tohadata WHERE DATE(reading_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY reading_time DESC LIMIT 1";
    $result3 = $con->query($sql3);
    $data['xHistory'] = ($result3->num_rows > 0) ? $result3->fetch_assoc() : null;

    // Fetch Y History data from yesterday
    $sql4 = "SELECT value_2, reading_time2 FROM tohadataY WHERE DATE(reading_time2) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY reading_time2 DESC LIMIT 1";
    $result4 = $con->query($sql4);
    $data['yHistory'] = ($result4->num_rows > 0) ? $result4->fetch_assoc() : null;

    // Close the database connection
    $con->close();
} catch (Exception $e) {
    $data['error'] = "An error occurred: " . $e->getMessage();
}

header("Content-type: application/json");
echo json_encode($data);
?>
