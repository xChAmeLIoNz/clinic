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


try {
    //STAGE 1: Prepare statement
    $stmt = $mysqli->prepare("DELETE FROM pw_iseppe_animals WHERE id_animal=?");
    //STAGE 2: bind and execute
    $stmt->bind_param("i", $id_animal);
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