<?php
session_start();

if (isset($_SESSION['username'])) {
    $role = $_SESSION['role'];

    switch ($role) {

        case 'admin':
            echo json_encode(array(
                'role' => $role
            ));
            break;
        case 'operatore_negozio':
            echo json_encode(array(
                'role' => $role
            ));
            break;
        case 'operatore_magazzino':
            echo json_encode(array(
                'role' => $role
            ));
            break;
        default:
            echo json_encode(array(
                'role' => ''
            ));
            break;
    }
}
