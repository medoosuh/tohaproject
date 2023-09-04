<!--HTML CODE-->

<!DOCTYPE html>
<html lang="en"> <!--set the language as english-->

<head>
    <meta charset="UTF-8">
    <title>Toha Project</title>
    <meta http-equiv="refresh" content="5"> <!--refresh the page every 5 second-->
    <!--CSS code-->
    <style>
        table { 
        margin: 0 auto;
        font-size: large;
        border: 1px solid black;
        }

        h1 {
        text-align: center;
        font-weight: bold;
        color: #023020;
        font-size: xx-large;
        font-family: "Times New Roman", Times, serif;
        }

        td {
        background-color: #ADD8E6;
        border: 1px solid black;
        }

        th,
        td {
        font-weight: bold;
        border: 1px solid black;
        padding: 10px;
        text-align: center;
        }

        td {
        font-weight: lighter;
        }
    </style> <!--close CSS code-->
</head>

<body>
<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

//phpmyadmin details
$user = 'ucetak';
$password = '!Lavender_4';
$db = 'countertoha';
$host = 'localhost';

//COUNTER X DATA
try {
//connect to phpmyadmin
$con = new mysqli($host, $user, $password, $db);
//it will not connect to phpmyadmin if there is an error
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//if the POST value that was sent from the button/sensor is not empty
if (!empty($_POST['value1'])) {
   $receivedData1 = $_POST['value1'];
   $receivedData2 = $_POST['value2'];
   //create a query to insert the POST value into the database table "tohadata" in column "value1"
    $sql = "INSERT INTO tohadata (value1) VALUES ('" .$receivedData1. "')";
    
    if ($con->query($sql) === TRUE) {
        echo "OK"; //if the query is executed perfectly, the data will be in the table
    } else {
        echo "Error: " . $sql . "<br>" . $con->error; //if the query is not executed, it will return an error
    }
}

//create a query to select only one latest data that will be displayed
$sql = "SELECT value1, reading_time FROM tohadata ORDER BY reading_time DESC LIMIT 1";
$result = $con->query($sql);
}
//create an exception handling to catch and display uncaught exception 
catch (Exception $e) {
echo "An error occured: " .$e->getMessage();
}

//COUNTER Y DATA
try {
//connect to phpmyadmin
$con = new mysqli($host, $user, $password, $db);
//it will not connect to phpmyadmin if there is an error
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//if the POST value that was sent from the button/sensor is not empty
if (!empty($_POST['value_2'])) {
   $receivedData1 = $_POST['value1'];
   $receivedData2 = $_POST['value_2'];
   
   //create a query to insert the POST value into the database table "tohadataY" in column "value_2"
    $sql = "INSERT INTO tohadataY (value_2) VALUES ('" .$receivedData2. "')";

    if ($con->query($sql) === TRUE) {
        echo "OK"; //if the query is executed perfectly, the data will be in the table
    } else {
        echo "Error: " . $sql . "<br>" . $con->error; //if the query is not executed, it will return an error
    }
}
//create a query to select only one latest data that will be displayed 
$sql2 = "SELECT value_2, reading_time2 FROM tohadataY ORDER BY reading_time2 DESC LIMIT 1";
$result2 = $con->query($sql2);
}
//create an exception handling to catch and display uncaught exception
catch (Exception $e) {
echo "An error occured: " .$e->getMessage();
}
?>

    <h1>TOHA "X" COUNTER</h1> <!--shows the latest data of value1 from table "tohadata"-->
    <!--create a table to display data from tohadata table-->
    <table>
        <tr>
            <th>X</th>
            <th>Date</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) { //fetch a result row
            echo "<tr><td>" . $row["value1"] . "</td><td>" . $row["reading_time"] . "</td></tr>"; //display table content
        }
        ?>
    </table> <!--close table-->

    <!--close the connection-->
    <?php $con->close(); ?> 

    <h1>TOHA "Y" COUNTER</h1> <!--shows the latest data of value_2 from table "tohadataY"-->
    <!--create a table to display data from tohadata table-->
    <table>
        <tr>
            <th>Y</th>
            <th>Date</th>
        </tr>
        <?php
        while ($row = $result2->fetch_assoc()) { //fetch a result row
            echo "<tr><td>" . $row["value_2"] . "</td><td>" . $row["reading_time2"] . "</td></tr>"; //display table content
        }
        ?>
    </table> <!--close table-->

    <!--close the connection-->
    <?php $con->close(); ?> 

    <h1>DATA "X" HISTORY</h1> <!--shows the last data from yesterday's input-->
    
    <?php

    //phpmyadmin login details
    $user = 'ucetak';
    $password = '!Lavender_4';
    $db = 'countertoha';
    $host = 'localhost';

    //create connection
    $con = new mysqli($host, $user, $password, $db);
    //check connection
    if ($con->connect_error) {
    die("Connection failed: " .$con->connect_error); //if failed to connect, it will display the error message
    }

    //create a query to select only the last data from yesterday
    $sql = "SELECT value1, reading_time FROM tohadata WHERE DATE(reading_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY reading_time     DESC LIMIT 1";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>X</th><th>Date</th></tr>"; //create table
        while ($row = $result->fetch_assoc()) { //fetch a result row
           echo "<tr><td>" . $row["value1"] . "</td><td>" .$row["reading_time"] . "</td></tr>"; //display the table content
        }
        echo "</table>"; //close table
    } else {
       echo "No data from yesterday :("; //if there is no data from yesterday, it will display this message
    }
    //close database connection
    $con->close();
    ?>

    <h1>DATA "Y" HISTORY</h1> <!--shows the last data from yesterday's input-->

    <?php
    
    //phpmyadmin login details
    $user = 'ucetak';
    $password = '!Lavender_4';
    $db = 'countertoha';
    $host = 'localhost';

    //create connection
    $con = new mysqli($host, $user, $password, $db);
    //check connection
    if ($con->connect_error) {
        die("Connection failed: " .$con->connect_error); //if connection failed, it will display the error message
    }

    //create a query to select only the last data from yesterday
    $sql = "SELECT value_2, reading_time2 FROM tohadataY WHERE DATE(reading_time2) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY reading_time2 DESC LIMIT 1";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Y</th><th>Date</th></tr>"; //create table
        while ($row = $result->fetch_assoc()) { //fetch a result row
           echo "<tr><td>" . $row["value_2"] . "</td><td>" .$row["reading_time2"] . "</td></tr>"; //display the table with result
        }
        echo "</table>"; //close table
    } else {
        echo "No data from yesterday :("; //if there is no data from yesterday, it will display this message
    }
    //close database connection
    $con->close();
    ?>

</body> <!--close the body-->
</html> <!--close html-->
