<?php
include('config.php');
//ini_set("display_errors", true);

function checkProduct($sku, $qty, $qty_mag, $conn)
{

    $data = array(
        'response' => ''
    );
    //$data['response'] = '';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //controllo se il prodotto è gia stato inserito nel carrello
        $sql = "SELECT * FROM export WHERE sku='$sku';";
        $result = $conn->query($sql);
        //se esiste nel cart, allora aggiorno il prodotto
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $final_qty = $qty + $row['qty_neg'];
            $final_qty_mag = $qty_mag + $row['qty_mag'];
            if ($conn->query("UPDATE export SET qty_neg='$final_qty', qty_mag='$final_qty_mag' WHERE sku='$sku';")) {
                $data['response'] = 'update';
                //echo "dentro update";
            }
        } else {
            //per aggiungere il prodotto nel cart devo recuperare prima i dati da products
            $result = $conn->query("SELECT * FROM products WHERE sku='$sku';");

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row['id'];
                $name = str_replace("'", " ", $row['name']);
                $price = $row['price'];
                //$sku
                //$qty = $row['stock_quantity'];

                if ($conn->query("INSERT INTO export VALUES (DEFAULT, '$id', '$name', '$price', '$sku', '$qty', '$qty_mag');")) {
                    $data['response'] = 'insert';
                    //echo "dentro insert";
                }
            }
        }
    }
    return $data;
}

if (isset($_POST['data'])) {
    $json = $_POST['data'];
    $array_params = json_decode($json, true);
    $data_array = array();
    //var_dump($array_params);

    $sku = $array_params[0];
    $qty = $array_params[1] == '' ? 0 : $array_params[1];
    $qty_mag = $array_params[2] == '' ? 0 : $array_params[2];

    if ($sku != '' && $qty != '') {
        $data_array = checkProduct($sku, $qty, $qty_mag, $conn);
    }
    echo json_encode($data_array);
}
