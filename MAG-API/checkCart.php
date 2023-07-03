<?php
include('config.php');

session_start();
$id_user = $_SESSION['id_user'];

$data = [
    'response' => ''
];

if (isset($_POST['data']) && $_POST['data'] == 'neg') {
    if ($result = $conn->query("SELECT * FROM export WHERE id_user='$id_user';")) {
        if ($result->num_rows < 1) {
            $data['response'] = 'empty';
        } else {
            $data['response'] = 'full';
        }
    }
}

if (isset($_POST['data']) && $_POST['data'] == 'mag') {
    if ($result = $conn->query("SELECT * FROM export_mag WHERE id_user='$id_user';")) {
        if ($result->num_rows < 1) {
            $data['response'] = 'empty';
        } else {
            $data['response'] = 'full';
        }
    }
}


echo json_encode($data);
