<?php
    require "connection.php";
 
    $json = array();
    $sqlQuery = "SELECT * FROM schedule ORDER BY Schedule_ID";
 
    $result = mysqli_query($connection, $sqlQuery);
    $alldata = array();
    while ($row = mysqli_fetch_assoc($result)) 
    {
        array_push($alldata, $row);
    }
    mysqli_free_result($result);
 
    mysqli_close($connection);
    echo json_encode($alldata);


$scheduletitle = $_POST['Schedule_Title'];
$schedulestarttime = $_POST['Schedule_StartTime'];
$scheduleendtime = $_POST['Schedule_EndTime'];
 
$sqlInsert = "INSERT INTO schedule (Schedule_Title, Schedule_StartTime, Schedule_EndTime) VALUES ('".$scheduletitle."','".$schedulestarttime."','".$scheduleendtime ."')";
 
$result = mysqli_query($connection, $sqlInsert);
 
if (! $result) {
    $result = mysqli_error($connection);
}


$scheduleid = $_POST['Schedule_ID'];
$sqlDelete = "DELETE from schedule WHERE Schedule_ID=".$scheduleid;
 
mysqli_query($connection, $sqlDelete);
echo mysqli_affected_rows($connection);
 
mysqli_close($connection);


$scheduleid = $_POST['Schedule_ID'];
$scheduletitle = $_POST['Schedule_Title'];
$schedulestarttime = $_POST['Schedule_StartTime'];
$scheduleendtime = $_POST['Schedule_EndTime'];
 
$sqlUpdate = "UPDATE schedule SET Schedule_Title='" . $scheduletitle . "',Schedule_StartTime='" . $schedulestarttime . "',Schedule_EndTime='" . $scheduleendtime . "' WHERE Schedule_ID=" . $scheduleid;
mysqli_query($connection, $sqlUpdate);
mysqli_close($connection);

?>