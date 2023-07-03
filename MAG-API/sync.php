<?php
// includi il file di configurazione del database
include('config.php');
include('functions.php');
ini_set("display_errors", true);

if (isset($_POST['sync_prodotti']) || isset($_GET['delete'])) {
    $synced = "true";
    //pulisco il db prima di inserire i prodotti
    if ($conn->query("DELETE FROM products WHERE 1")) {
        //ripristino l'id AI a 1
        $conn->query("ALTER TABLE products AUTO_INCREMENT = 1;");
        // chiamata API per recuperare i dati da WooCommerce
        //$products = chiamaApiproducts(WC_API_URL . 'products?categories=1&per_page=100', WC_CONSUMER_KEY, WC_CONSUMER_SECRET);
        $all_products = array();
        $page = 1;
        $per_page = 80;

        do {
            $products = chiamaApiproducts(WC_API_URL . 'products?per_page=' . $per_page . '&page=' . $page, WC_CONSUMER_KEY, WC_CONSUMER_SECRET);
            $all_products = array_merge($all_products, $products);
            $page++;
        } while (!empty($products));

        //var_dump($products);
        $batch_size = 100;
        $chunks = array_chunk($all_products, $batch_size);

        foreach ($chunks as $chunk) {

            foreach ($chunk as $product) {

                $product_id = $product->id;
                //echo $product_id;
                $product_name = $product->name;


                $product_name = str_replace("'", " ", $product_name);

                $product_price = $product->price;
                $product_sku = $product->sku; // aggiunto il campo sku
                if ($product->stock_quantity == null) {
                    $product_stock_quantity = 0;
                } else {
                    $product_stock_quantity = $product->stock_quantity;
                }

                

                //$product_stock_quantity_2 = 0;

                //BEFORE EDIT
                // foreach ($product->meta_data as $meta_data) {
                //     if ($meta_data->key == '_op_qty_warehouse_13021') {
                //         if ($meta_data->value == null) {
                //             $product_stock_quantity_2 = 0;
                //         }
                //         $product_stock_quantity_2 = $meta_data->value;
                //     } else {
                //         $product_stock_quantity_2 = 0;
                //     }
                // }



                //AFTER EDIT
                // ...

                foreach ($product->meta_data as $meta_data) {
                    if ($meta_data->key == '_op_qty_warehouse_13021') {
                        if ($meta_data->value == null) {
                            $product_stock_quantity_2 = 0;
                        } else {
                            $product_stock_quantity_2 = $meta_data->value;
                        }
                        // Imposta una variabile ausiliaria per indicare che è stato trovato un metadato valido
                        $found_meta_data = true;
                    }
                }

                // Se non è stato trovato un metadato valido, imposta $product_stock_quantity_2 a 0
                if (!isset($found_meta_data)) {
                    $product_stock_quantity_2 = 0;
                }

                // ...


                //dopo aver pulito il db, inserisco i prodotti della chiamata API
                //$sql = "INSERT INTO products (idtable, id, name, price, sku, stock_quantity) VALUES (DEFAULT, '$product_id', '$product_name', '$product_price', '$product_sku', '$product_stock_quantity')"; // Aggiunti i campi SKU e stock_quantity

                try {
                    $stmt = $conn->prepare("INSERT INTO products (idtable, id, name, price, sku, stock_quantity, stock_quantity_2) VALUES (DEFAULT, ?,?,?,?,?,?)");
                    $stmt->bind_param("isssii", $product_id, $product_name, $product_price, $product_sku, $product_stock_quantity, $product_stock_quantity_2);
                    $stmt->execute();
                    $stmt->close();
                } catch (mysqli_sql_exception $e) {

                    echo $e->getMessage();
                }

                /*
                if (mysqli_query($conn, $sql)) {
                    echo "insert va";
                } else {
                    echo $conn->error;
                }
    
                */
                /*
                // Verifica se il prodotto esiste già nel database
                $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
                if (mysqli_num_rows($result) > 0) {
                    // il prodotto esiste già nel database, quindi aggiorna i dati
                    $sql = "UPDATE products SET name = '$product_name', price = '$product_price', sku = '$product_sku', stock_quantity = '$product_stock_quantity' WHERE id = $product_id"; // Aggiunti i campi SKU e stock_quantity
                    mysqli_query($conn, $sql);
                    //echo "qui";
                } else {
                    // il prodotto non esiste nel database, quindi inserisci un nuovo record
                    $sql = "INSERT INTO products (idtable, id, name, price, sku, stock_quantity) VALUES (DEFAULT, '$product_id', '$product_name', '$product_price', '$product_sku', '$product_stock_quantity')"; // Aggiunti i campi SKU e stock_quantity
                    if (mysqli_query($conn, $sql)) {
                        echo "insert va";
                    } else {
                        echo $conn->error;
                    }
                }
                */
            }
        }



        // qui $all_products contiene l'elenco completo di tutti i prodotti

        // per ogni prodotto, inseriscilo o aggiornalo nel database

    }


    // chiudi la connessione al database
    mysqli_close($conn);
    //individuo da quale URL proviene l'utente
    $path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
    $referer = basename($path);

    if ($referer == 'elencoAnomalieGiacenze.php') {
        header("Location: elencoAnomalieGiacenze.php?sync=$synced");
        exit;
    } elseif ($referer == 'elencoProdotti.php') {
        header("Location: elencoProdotti.php?sync=$synced");
        exit;
    } elseif ($referer == 'elencoNegozio.php') {
        header("Location: elencoNegozio.php?sync=$synced");
        exit;
    } elseif ($referer == 'elencoMagazzino.php') {
        header("Location: elencoMagazzino.php?sync=$synced");
        exit;
    } else {
        header("Location: dashboard.php");
        exit;
    }
} elseif (isset($_POST['sync_clienti'])) {

    $synced = "true";

    if ($conn->query("DELETE FROM clients WHERE 1")) {
        $conn->query("ALTER TABLE clients AUTO_INCREMENT = 1;");
        //riciclo la chiamata prodotti per chiamare i customers
        $customers = chiamaApiproducts(WC_API_URL . 'customers?per_page=100', WC_CONSUMER_KEY, WC_CONSUMER_SECRET);

        foreach ($customers as $customer) {
            $customer_id = $customer->id;
            $first_name = $customer->first_name;
            $last_name = $customer->last_name;
            $company = $customer->billing->company;
            $email = $customer->email;
            $phone = $customer->billing->phone;

            if ($conn->query("INSERT INTO clients (idtable, id, first_name, last_name, company, email, phone) 
            VALUES (DEFAULT, '$customer_id', '$first_name', '$last_name', '$company', '$email', '$phone')")) {

                echo "funziona";
            } else {
                echo $conn->error;
            }
        }
    }

    header("Location: elencoClienti.php?sync=$synced");
    exit;
} elseif (isset($_POST['sync_ordini'])) {

    $synced = "true";

    if ($conn->query("DELETE FROM orders WHERE 1")) {
        $conn->query("ALTER TABLE orders AUTO_INCREMENT = 1;");
        //riciclo chiamata api per gli ordini
        $orders = chiamaApiproducts(WC_API_URL . 'orders?per_page=100', WC_CONSUMER_KEY, WC_CONSUMER_SECRET);
        foreach ($orders as $order) {
            // Stampa le informazioni del prodotto
            //crea la tabella HTML
            $id_order = $order->id;
            $total_order = $order->total;
            $data = $order->date_created;
            $timestamp_data = strtotime($data);
            // Formato della data che voglio ottenere in uscita dalla funzione date()
            $formato = 'd/m/Y';
            // Cambio il formato della data
            $dataGirata = date($formato, $timestamp_data);
            $stato = $order->status;
            /* pending, processing, on-hold, completed, cancelled, refunded, failed and trash */
            switch ($stato) {
                case 'completed':
                    $stato = "COMPLETATO";
                    break;
                case 'pending':
                    $stato = "IN ATTESA DI PAGAMENTO";
                    break;
                case 'processing':
                    $stato = "IN ELABORAZIONE";
                    break;
                case 'on-hold':
                    $stato = "IN ATTESA";
                    break;
                case 'cancelled':
                    $stato = "CANCELLATO";
                    break;
                case 'refunded':
                    $stato = "RESTITUZIONE";
                    break;
                case 'failed':
                    $stato = "FALLITO";
                    break;
                case 'trash':
                    $stato = "CESTINO";
                    break;
                case 'scontrino':
                    $stato = "SCONTRINO";
                    break;
                case 'fattura':
                    $stato = "FATTURA";
                    break;
                default:
                    $stato = "---";
                    break;
            }
            $nomeCliente = leggoDatiClienti($order->customer_id);
            try {
                $conn->query("INSERT INTO orders (idtable, id, client, date, total, order_status) VALUES (DEFAULT, '$id_order', '$nomeCliente', '$dataGirata', '$total_order', '$stato');");
            } catch (mysqli_sql_exception $e) {

                echo $e->getMessage();
            }
        }
    }
    header("Location: elencoOrdini.php?sync=$synced");
    exit;
}
