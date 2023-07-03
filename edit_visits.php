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

$id_visit = $_POST['id_visit'];
//$id_animal = $_POST['id_animal'];
$date = $_POST['date'];
$medic = $_POST['medic'];
$report = $_POST['report'];



try {
    //STAGE 1: Prepare statement
    $stmt = $mysqli->prepare("UPDATE pw_iseppe_visits SET date_visit=?, id_medic=?, report=? WHERE id_visit=?");
    //STAGE 2: bind and execute
    $stmt->bind_param("sisi", $date, $medic, $report, $id_visit);
    $stmt->execute();
    //echo "Dati animale inseriti correttamente";
    //Close statement execution to free server resources
    $stmt->close();
    header("Location: visits.php");
    exit;
} catch (mysqli_sql_exception $e) {
    //echo "Ooops, something went wrong: [ " . $e->getMessage() . " ]";
    $errmsg = $e->getMessage();
    $query_string = http_build_query(array('errmsg' => $errmsg));
    header("Location: 400.php?" . $query_string);
    exit;
}


?>