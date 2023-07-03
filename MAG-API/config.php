<?php
define('JSON_FILE', 'users.json');

define('WC_API_URL', '/wp-json/wc/v3/');
define('WC_CONSUMER_KEY', '');
define('WC_CONSUMER_SECRET', '');



// Definisci le informazioni di accesso al database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

// Connessione al database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verifica la connessione
if($conn === false){
    die("Errore nella connessione al database. " . mysqli_connect_error());
}





?>