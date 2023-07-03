<?php
include('config.php');

session_start();
$id_user = $_SESSION['id_user'];

$data = [
    'response' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($result = $conn->query("SELECT * FROM export WHERE id_user='$id_user';")) {
        if ($result->num_rows < 1) {
            $data['response'] = 'empty';
        } else {
            if ($conn->query("DELETE FROM export WHERE id_user='$id_user';")) {
                if ($conn->query("ALTER TABLE export AUTO_INCREMENT = 1;")) {
                    $data['response'] = 'delete';
                }
            }
        }
    }
}

if (isset($_GET['item'])) {

    $sku = $_GET['item'];
    

    if ($result = $conn->query("SELECT * FROM export WHERE sku='$sku' AND id_user='$id_user';")) {
        if ($result->num_rows < 1) {
            $data['response'] = 'empty';
        } else {
            if ($conn->query("DELETE FROM export WHERE sku='$sku' AND id_user='$id_user';")) {

                $data['response'] = 'delete';
            }
        }
    }

    header('Location: cartNeg.php');
}


echo json_encode($data);
