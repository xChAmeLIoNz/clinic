<?php
include('config.php');

session_start();

$id_user = $_SESSION['id_user'];

echo numProdottiMag($conn, $id_user);


function numProdottiMag($conn, $id_user)
{

    $notice = '';
    if ($conn->connect_error) {

        $connect = false;
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql0 = "SELECT count(sku) AS sku FROM export_mag WHERE id_user='$id_user';";


        $result = mysqli_query($conn, $sql0);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $nbrresult = $row['sku'];
        //$nbrresult=count($row);
        $strss = 'articoli nel carrello';
        if ($nbrresult == 1) {
            $strss = 'articolo nel carrello';
        }
        if ($nbrresult == '') {
            $nbrresult = 0;
        }

        $url = '<a href="cartMag.php"> --> Apri</a>';
        $notice = '  ' . $nbrresult . '  ' . $strss . ' ' . $url;
    }
    return $notice;
}
