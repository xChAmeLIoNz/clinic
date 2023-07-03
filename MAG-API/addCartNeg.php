<?php
include('config.php');
//ini_set("display_errors", true);

session_start();

function checkProduct($sku, $qty, $conn, $id_user)
{

    $data = array(
        'response' => ''
    );
    //$data['response'] = '';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //controllo se il prodotto è gia stato inserito nel carrello
        $sql = "SELECT * FROM export WHERE sku='$sku' AND id_user='$id_user';";
        $result = $conn->query($sql);
        //se esiste nel cart, allora aggiorno il prodotto
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $final_qty = $qty + $row['qty_neg'];
           
            if ($conn->query("UPDATE export SET qty_neg='$final_qty' WHERE sku='$sku' AND id_user='$id_user';")) {
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

                if ($conn->query("INSERT INTO export VALUES (DEFAULT, '$id', '$name', '$price', '$sku', '$qty', '$id_user');")) {
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
    
    if ($sku != '' && $qty != '') {
        $data_array = checkProduct($sku, $qty, $conn, $_SESSION['id_user']);
    }
    echo json_encode($data_array);
}


//CODE FOR editCartNeg.php
if (isset($_POST['sku'], $_POST['qty'])) {
    $sku = $_POST['sku'];
    $qty = $_POST['qty'];
    $id_user = $_SESSION['id_user'];
    //controllo se il prodotto è gia stato inserito nel carrello
    $sql = "SELECT * FROM export WHERE sku='$sku' AND id_user='$id_user';";
    $result = $conn->query($sql);
    //se esiste nel cart, allora aggiorno il prodotto
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        //$final_qty = $qty + $row['qty_neg'];
        if ($conn->query("UPDATE export SET qty_neg='$qty' WHERE sku='$sku' AND id_user='$id_user';")) {
            header("Location: cartNeg.php");
            //echo "dentro update";
        }
    }
}
