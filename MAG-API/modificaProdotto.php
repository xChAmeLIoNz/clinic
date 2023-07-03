<?php
session_start();

ini_set("display_errors", true);

include('config.php');



$redirect_url = 'elencoProdotti.php';



//updated data
$id = $_POST['id'];
$sku = $_POST['sku'];
$name = $_POST['name'];
$price = $_POST['price'];
$stock_quantity = intval($_POST['stock_quantity']);
$stock_quantity_2 = intval($_POST['stock_quantity_2']);

//original data
$od_id = $_POST['od_id'];
$od_name = $_POST['od_name'];
$od_price = $_POST['od_price'];
$od_stock_quantity = intval($_POST['od_stock_quantity']);
$od_stock_quantity_2 = intval($_POST['od_stock_quantity_2']);


//log table
$operator = $_SESSION['username'];
$date = date('d-m-Y');
$time = date('H:i');



$type = '';
$stock_status = '';
/*
if ($stock_quantity > $stock_quantity_before) {
  $type = "carico";
} else {
  $type = "scarico";
}
*/
/*
if ($stock_quantity <= 0) {
  $stock_status = "outofstock";
} else {
  $stock_status = "instock";
}
*/
/*
try {

  $stmt = $conn->prepare("INSERT INTO logs VALUES (DEFAULT,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("ssssisssssii", $operator,$date,$time,$type,$id,$sku,$name_before,$name,
  $price_before,$price,$stock_quantity_before,$stock_quantity);
  $stmt->execute();
  $stmt->close();
} catch (mysqli_sql_exception $e) {
  echo "Something wrong: [ " . $e->getMessage() . " ]";
}

*/

//MODIFICA ELENCO NEGOZIO
if (isset($_POST['stock_quantity']) && !isset($_POST['stock_quantity_2'])) {
  $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
  if (mysqli_num_rows($result) > 0) {
    // il prodotto esiste già nel database, quindi aggiorna i dati
    $sql = "UPDATE products SET name = '$name', price = '$price', sku = '$sku', stock_quantity = '$stock_quantity' WHERE id = $id"; // Aggiunti i campi SKU e stock_quantity

    if (mysqli_query($conn, $sql)) {
      //string value for negozio (es. 53 > 56)
      $differenza = strval($stock_quantity - $od_stock_quantity);
      $od_qty_str = strval($od_stock_quantity);
      $qty_str = strval($stock_quantity);
      $qty = "$od_qty_str -> $qty_str [$differenza]";

      $conn->query("INSERT INTO logs (operator, date, time, name, sku, stock_quantity) VALUES ('$operator', '$date', '$time', '$name', '$sku', '$qty');");

      $data = array('stock_quantity' => $stock_quantity);
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
        echo "non va";
        // Gestisci l'errore
      } else {
        echo "va";
        //header('Location: ' . $redirect_url);
      }
    }
  }
}

//MODIFICA ELENCO MAGAZZINO
if (isset($_POST['stock_quantity_2']) && !isset($_POST['stock_quantity'])) {
  $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
  if (mysqli_num_rows($result) > 0) {
    // il prodotto esiste già nel database, quindi aggiorna i dati
    $sql = "UPDATE products SET name = '$name', price = '$price', sku = '$sku', stock_quantity_2 = '$stock_quantity_2' WHERE id = $id"; // Aggiunti i campi SKU e stock_quantity

    if (mysqli_query($conn, $sql)) {
      //string value for magazzino (es. 53 > 56)
      $differenza = strval($stock_quantity_2 - $od_stock_quantity_2);
      $od_qty_str = strval($od_stock_quantity_2);
      $qty_str = strval($stock_quantity_2);
      $qty = "$od_qty_str -> $qty_str [$differenza]";

      $conn->query("INSERT INTO logs (operator, date, time, name, sku, stock_quantity_2) VALUES ('$operator', '$date', '$time', '$name', '$sku', '$qty');");

      $data = [
        'meta_data' => [
          [
            'key' => '_op_qty_warehouse_13021',
            'value' => $stock_quantity_2
          ]
        ]
      ];
      /*
      $data = array(
        'meta_data' => array(
          array(
            'key' => '_op_qty_warehouse_13021',
            'value' => $stock_quantity_2
          )
        )
      );
*/
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
        echo "non va";
        // Gestisci l'errore
      } else {
        echo "va";
        //header('Location: ' . $redirect_url);
      }
    }
  }
}

//MODIFICA NEGOZIO E MAGAZZINO
if (isset($_POST['stock_quantity_2']) && isset($_POST['stock_quantity'])) {
  $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
  if (mysqli_num_rows($result) > 0) {
    // il prodotto esiste già nel database, quindi aggiorna i dati
    $sql = "UPDATE products SET name = '$name', price = '$price', sku = '$sku', stock_quantity = '$stock_quantity', stock_quantity_2 = '$stock_quantity_2' WHERE id = $id"; // Aggiunti i campi SKU e stock_quantity

    if (mysqli_query($conn, $sql)) {

      //string value for negozio (es. 53 > 56)
      $diff_neg = strval($stock_quantity - $od_stock_quantity);
      $od_qty_str = strval($od_stock_quantity);
      $qty_str = strval($stock_quantity);
      $qty = "$od_qty_str -> $qty_str [$diff_neg]";
      if ($diff_neg == "0") {
        $qty = "";
      }

      //string value for magazzino (es. 53 > 56)
      $diff_mag = strval($stock_quantity_2 - $od_stock_quantity_2);
      $od_qty_2_str = strval($od_stock_quantity_2);
      $qty_2_str = strval($stock_quantity_2);
      $qty_2 = "$od_qty_2_str -> $qty_2_str [$diff_mag]";
      if ($diff_mag == "0") {
        $qty_2 = "";
      }

      $conn->query("INSERT INTO logs (operator, date, time, name, sku, stock_quantity, stock_quantity_2) VALUES ('$operator', '$date', '$time', '$name', '$sku', '$qty', '$qty_2');");

      $data = [
        'stock_quantity' => $stock_quantity,
        'meta_data' => [
          [
            'key' => '_op_qty_warehouse_13021',
            'value' => $stock_quantity_2
          ]
        ]
          ];


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

        header('Location: ' . $redirect_url);
      }
    }
  }
}
