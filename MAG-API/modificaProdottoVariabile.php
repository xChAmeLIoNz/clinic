<?php
$redirect_url = 'elencoProdotti.php';

$id = $_POST['id'];
$product_id = $_POST['idProduct'];
$name = $_POST['name'];
$sku = $_POST['sku'];
$price = $_POST['price'];
$stock_quantity = intval($_POST['stock_quantity']);
$option = $_POST['option'];

//$url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/' . $product_id . '/variations/' . $id;
/////////$url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/' . $id;
//$username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
//$password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';

$data = array('name' => $name, 'price' => $price, 'regular_price' => $price, 'sku' => $sku, 'stock_quantity' => $stock_quantity);

$data_json = json_encode($data);

// Crea un'istanza di cURL
$ch = curl_init();

// Imposta le opzioni di cURL
curl_setopt($ch, CURLOPT_URL, $url);
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
} 
curl_close($ch);
// aggiorno nome prodotto 
////////$url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/' . $product_id;
//$username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
//$password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';

$data = array('name' => $name);
$data_json = json_encode($data);

// Crea un'istanza di cURL
$ch = curl_init();

// Imposta le opzioni di cURL
curl_setopt($ch, CURLOPT_URL, $url);
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
  die();
}
curl_close($ch);