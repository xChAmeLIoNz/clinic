<?php
if (!isset($_POST['submit'])) {
    header("Location: index.php");
    exit;
}

//////////////////////////
//DEBUGGING|ERROR OUTPUT//
//////////////////////////

$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

ini_set("display_errors", TRUE);



//////////////////////////////
//INCLUDE DB CONNECTION FILE//
//////////////////////////////
try {
    include_once 'dbconnect.inc.php';
} catch (Exception $e) {
    echo "Sorry, connection unsuccessful: [ " . $e->getMessage() . " ]";
}

////////////////////////////////////////////////
//POPULATE VARIABLES WITH SANITIZED USER INPUT//
////////////////////////////////////////////////
$first_name = $mysqli->real_escape_string($_POST['first_name']);
$last_name = $mysqli->real_escape_string($_POST['last_name']);
$dob = $mysqli->real_escape_string($_POST['dob']);
$email = $mysqli->real_escape_string($_POST['email']);
$number = $mysqli->real_escape_string($_POST['number']);
//$password = password_hash($mysqli->real_escape_string($_POST['password']), PASSWORD_DEFAULT);



//////////////////////
//PREPARED STATEMENT// 
//////////////////////

try {
    //STAGE 1: Prepare statement
    $stmt = $mysqli->prepare("INSERT INTO pw_iseppe_users VALUES (DEFAULT,?,?,?,?,?)");
    //STAGE 2: bind and execute
    $stmt->bind_param("sssss", $first_name, $last_name, $dob, $email, $number);
    $stmt->execute();
    //echo "Dati inseriti correttamente";
    //Close statement execution to free server resources
    $stmt->close();
    header("Location: 200.php");
    exit;
} catch (mysqli_sql_exception $e) {
    //echo "Ooops, something went wrong: [ " . $e->getMessage() . " ]";
    $errmsg = $e->getMessage();
    $query_string = http_build_query(array('errmsg' => $errmsg));
    header("Location: 400.php?" . $query_string);
    exit;
}
