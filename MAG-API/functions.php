<?php
require_once('config.php');

function getUsers() {
    if (!file_exists(JSON_FILE)) {
        die("Errore: il file JSON non esiste");
    }

    $json_data = file_get_contents(JSON_FILE);
    $users = json_decode($json_data, true)['users'];

    return $users;
}

function authenticate($username, $password) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            return $user['role'];
        }
    }

    return false;
}

function checkAdminRole() {
    session_start();
    if (isset($_SESSION['username'])) {
        if (!($_SESSION['role'] === 'admin')) {
            header("Location: dashboard.php");
            exit;
        }

    }
}

// chiamata API per prodotti semplici
function chiamaApiproducts($url, $username, $password)
{
    // Crea un'istanza di cURL
    $ch = curl_init();
    // Imposta le opzioni di cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    // Esegui la chiamata API
    $response = curl_exec($ch);

    // Gestisci la risposta dell'API
    if ($response === false) {
        $error = curl_error($ch);
        // Gestisci l'errore
    } else {
        $products = json_decode($response);
        curl_close($ch);
        return $products;
    }
}

// chiamata API per variazione con ID
function chiamaApivariations($url, $username, $password)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Esegui la chiamata API
    $response = curl_exec($ch);

    // Gestisci la risposta dell'API
    if ($response === false) {
        $error = curl_error($ch);
        // Gestisci l'errore
    } else {
        $variations = json_decode($response);
    }
    return $variations;
}

//echo leggoDatiClienti(2408);

function leggoDatiClienti($id) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, WC_API_URL . 'customers/' . $id);
    curl_setopt($ch, CURLOPT_USERPWD, WC_CONSUMER_KEY . ':' . WC_CONSUMER_SECRET);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
    // Esegui la chiamata API
    $response = curl_exec($ch);
  
    // Gestisci la risposta dell'API
    if ($response === false) {
        $error = curl_error($ch);
        // Gestisci l'errore
    } else {
        $clienti = json_decode($response, true);
        (!isset($clienti['first_name'])) ? $clienti['first_name'] = ' ' : $clienti['first_name'] = $clienti['first_name'];
        (!isset($clienti['last_name'])) ? $clienti['last_name'] = ' ' : $clienti['last_name'] = $clienti['last_name'];
      }
    return($clienti['first_name']." ".$clienti['last_name']);
    //return var_dump($clienti);
    
  }

?>
