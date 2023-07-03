<?php
$redirect_url = 'elencoProdotti.php';

$id = $_POST['id'];
$product_id = $_POST['idProduct'];

//$url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/' . $product_id . '/variations/' . $id;
//$username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
//$password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';

// Crea un'istanza di cURL
$ch = curl_init();

// Imposta le opzioni di cURL
curl_setopt($ch, CURLOPT_URL, WC_API_URL . 'products/' . $product_id . '/variations/' . $id);
curl_setopt($ch, CURLOPT_USERPWD, WC_CONSUMER_KEY . ':' . WC_CONSUMER_SECRET);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
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