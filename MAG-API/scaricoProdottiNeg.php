<?php
session_start();
include('config.php');

$id_user = $_SESSION['id_user'];
//log table
$operator = $_SESSION['username'];
$date = date('d-m-Y');
$time = date('H:i');

$info = array(
    'response' => ''
);

if ($result = $conn->query("SELECT * FROM export WHERE id_user='$id_user'")) {
    while ($row = $result->fetch_assoc()) {

        $sku = $row['sku'];
        $qty_neg = $row['qty_neg'];
        if ($result_inner = $conn->query("SELECT id, name, sku, stock_quantity FROM products WHERE sku='$sku'")) {
            if ($result_inner->num_rows > 0) {
                $row = $result_inner->fetch_assoc();
                $id = $row['id'];
                $final_qty_neg = $row['stock_quantity'] - $qty_neg;
                $qty = $row['stock_quantity'];
                $name = $row['name'];
                $diff = $final_qty_neg - $qty;
                $qty_str = "$qty -> $final_qty_neg [$diff]";
                if ($conn->query("UPDATE products SET stock_quantity='$final_qty_neg' WHERE sku='$sku';")) {
                    $info['response'] = 'carico';

                    $conn->query("INSERT INTO logs (operator, date, time, name, sku, stock_quantity) VALUES ('$operator', '$date', '$time', '$name', '$sku', '$qty_str');");

                    $data = array('stock_quantity' => $final_qty_neg);
                    $data_json = json_encode($data);

                    // Crea un'istanza di cURL
                    $ch = curl_init();

                    // Imposta le opzioni di cURL
                    curl_setopt($ch, CURLOPT_URL, WC_API_URL . 'products/' . $id);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
                    curl_setopt($ch, CURLOPT_USERPWD, WC_CONSUMER_KEY . ':' . WC_CONSUMER_SECRET);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // Esegui la chiamata API
                    $response = curl_exec($ch);

                    // Gestisci la risposta dell'API
                    if ($response === false) {
                        $error = curl_error($ch);

                        // Gestisci l'errore
                    } else {

                        //header('Location: ' . $redirect_url);
                    }
                }
            }
        }
    }
    $conn->query("DELETE FROM export WHERE id_user='$id_user'");
}

echo json_encode($info);
