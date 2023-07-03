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

$id_animal = $mysqli->real_escape_string($_POST['id_animal']);
$owner_name = $mysqli->real_escape_string($_POST['owner_name']);
$animal_name = $mysqli->real_escape_string($_POST['name']);
$breed = $mysqli->real_escape_string($_POST['breed']);
$dob = $mysqli->real_escape_string($_POST['dob']);


//retrieve owner id from users table
try {
    //STAGE 1: Prepare statement
    $stmt = $mysqli->prepare("SELECT id FROM pw_iseppe_users WHERE first_name=?");
    //STAGE 2: bind and execute
    $stmt->bind_param("s", $owner_name);
    $stmt->execute();
    //Close statement execution to free server resources
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    echo "Ooops, something went wrong: [ " . $e->getMessage() . " ]";
}

//finally update animal using owner id

try {
    //STAGE 1: Prepare statement
    $stmt = $mysqli->prepare("UPDATE pw_iseppe_animals SET id_owner=?, name=?, breed=?, dob=? WHERE id_animal = ?");
    //STAGE 2: bind and execute
    $stmt->bind_param("ssssi", $row['id'], $animal_name, $breed, $dob, $id_animal);
    $stmt->execute();
    //echo "Dati animale aggiornati correttamente";
    //Close statement execution to free server resources
    $stmt->close();
    header("Location: animals.php");
    exit;
} catch (mysqli_sql_exception $e) {
    //echo "Ooops, something went wrong: [ " . $e->getMessage() . " ]";
    $errmsg = $e->getMessage();
    $query_string = http_build_query(array('errmsg' => $errmsg));
    header("Location: 400.php?" . $query_string);
    exit;
}


?>