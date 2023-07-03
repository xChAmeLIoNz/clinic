<?php
session_start();
if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {

    echo "id not set";
} else {
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

    $id_animal = $_GET['id'];

    //animal info
    try {
        //STAGE 1: Prepare statement
        $stmt = $mysqli->prepare("SELECT * FROM pw_iseppe_animals WHERE id_animal=?");
        //STAGE 2: bind and execute
        $stmt->bind_param("i", $id_animal);
        $stmt->execute();
        //Close statement execution to free server resources
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo "Ooops, something went wrong: [ " . $e->getMessage() . " ]";
    }
    //animal variables
    $id_owner = $row['id_owner'];
    $name = $row['name'];
    $breed = $row['breed'];
    //$dob = $row['dob'];
    $dob = $row['dob'];
    $dob = DateTime::createFromFormat('Y-m-d', $dob)->format('d-m-Y');



    //owner info
    try {
        //STAGE 1: Prepare statement
        $stmt = $mysqli->prepare("SELECT * FROM pw_iseppe_users WHERE id=?");
        //STAGE 2: bind and execute
        $stmt->bind_param("i", $id_owner);
        $stmt->execute();
        //Close statement execution to free server resources
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo "Ooops, something went wrong: [ " . $e->getMessage() . " ]";
    }

    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    //$owner_dob = $user['dob'];
    $owner_dob = $user['dob'];
    $owner_dob = DateTime::createFromFormat('Y-m-d', $owner_dob)->format('d-m-Y');

    $email = $user['email'];
    $telephone = $user['telephone'];

    //visit info
    try {
        //STAGE 1: Prepare statement
        //$sql = "SELECT MAX(date_visit) as last_visit, MAX(report) as last_report FROM pw_iseppe_visits WHERE id_animal=? ORDER BY id_animal";
        //$sql = "SELECT date_visit as last_visit, report as last_report FROM pw_iseppe_visits WHERE id_animal=? ORDER BY date_visit DESC LIMIT 1;";
        $sql = "SELECT date_visit as last_visit, report as last_report FROM pw_iseppe_visits WHERE id_animal=? ORDER BY date_visit DESC, id_visit DESC LIMIT 1;";
        
        $stmt = $mysqli->prepare($sql);
        //STAGE 2: bind and execute
        $stmt->bind_param("i", $id_animal);
        $stmt->execute();
        //Close statement execution to free server resources
        $result = $stmt->get_result();
        $visit = $result->fetch_assoc();
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo "Ooops, something went wrong: [ " . $e->getMessage() . " ]";
    }


    if (isset($visit['last_visit']) && isset($visit['last_report'])) {
        $date_visit = $visit['last_visit'];
        $date_visit = DateTime::createFromFormat('Y-m-d', $date_visit)->format('d-m-Y');
        $report = $visit['last_report'];
    } else {
        $date_visit = "N/A";
        $report = "N/A";
    }


    require('fpdf185/fpdf.php');
    require_once('phpqrcode/qrlib.php');

    // Generate QR code
    $data = "Animal Name: $name\nBreed: $breed\nDate of Birth: $dob\nLast visit: $date_visit\nLast Report: $report\nOwner Name: $first_name $last_name\nEmail: $email\nTelephone: $telephone";
    $filename = "qrgen/qrcode.png";
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 6;
    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize);


    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Clinica ISEPPOS', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 5, 'P.IVA: 06089590481', 0, 1, 'C');
    $pdf->Cell(0, 5, 'Numero REA: FE-675488 - PEC: iseppos@cgn-legalmail.it', 0, 1, 'C');


    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Info Animale', 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Nome: ');
    $pdf->Cell(0, 10, $name, 0, 1);
    $pdf->Cell(50, 10, 'Razza: ');
    $pdf->Cell(0, 10, $breed, 0, 1);
    $pdf->Cell(50, 10, 'Data di nascita: ');
    $pdf->Cell(0, 10, $dob, 0, 1);
    $pdf->Cell(50, 10, 'Ultima visita: ');
    $pdf->Cell(0, 10, $date_visit, 0, 1);
    $pdf->Cell(50, 10, 'Ultimo referto: ');
    $pdf->Cell(0, 10, $report, 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Info Proprietario', 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Nome: ');
    $pdf->Cell(0, 10, $first_name, 0, 1);
    $pdf->Cell(50, 10, 'Cognome: ');
    $pdf->Cell(0, 10, $last_name, 0, 1);
    $pdf->Cell(50, 10, 'Data di nascita: ');
    $pdf->Cell(0, 10, $owner_dob, 0, 1);
    $pdf->Cell(50, 10, 'Email: ');
    $pdf->Cell(0, 10, $email, 0, 1);
    $pdf->Cell(50, 10, 'Telefono: ');
    $pdf->Cell(0, 10, $telephone, 0, 1);

    $pdf->Image('qrgen/qrcode.png', 160, 35, 30, 30, 'PNG');

    $pdf->Output('Dati_animali.pdf', 'I');
}
