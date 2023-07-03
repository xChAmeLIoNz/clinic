<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>
<?php 
// Specifica i dati dell'API di WooCommerce
$username = 'ck_fe204273ad276fc9c7a5e36ad96765b26bbce88b';
$password = 'cs_1ceae7502d5becd86f21d13c215d97f49d8989ff';
include_once('assets/vendor/phpqrcode/qrlib.php');
$directoryQrcode = "assets/img/qrcode/"; 

// chiamata API per prodotti
function chiamaApiproducts($url, $username, $password) {
  // Crea un'istanza di cURL
  $ch = curl_init();
  // Imposta le opzioni di cURL
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
      $products = json_decode($response);
      curl_close($ch);
      return $products;
  }
}

// chiamata API per variazione con ID
function chiamaApivariations($url, $username, $password) {
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Gestionale Magazzino</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img class="img-fluid" src="assets/img/logo.png" alt="">
        <!--<span class="d-none d-lg-block">Negozio di elettronica</span>-->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <!--<li class="nav-item">
        <a class="nav-link collapsed" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>--><!-- End Dashboard Nav -->

      <li class="nav-heading">WebServices</li>

<li class="nav-item">
        <a class="nav-link collapsed" href="elencoProdotti.php">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Elenco Prodotti</span>
        </a>
      </li><!-- End Elenco Prodotti Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="elencoAnomalieGiacenze.php">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Anomalie Giacenze</span>
        </a>
      </li><!-- End Anomalie Giacenze Nav -->
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="elencoClienti.php">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Elenco Clienti</span>
        </a>
      </li><!-- End Elenco Clienti Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="elencoOrdini.php">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Elenco Ordini</span>
        </a>
      </li><!-- End Elenco Ordini Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Elenco Prodotti</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Elenco Prodotti</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              
              <p></p>

              <!-- Table with stripped rows -->
              <table class="table datatable" id="prodotti">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Codice</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">Taglia</th>
                    <th scope="col">Prezzo €</th>
                    <th scope="col">Giacenza</th>
                    <th scope="col">QRCODE</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
<?php
$url = 'https://servizi.wpschool.it/wp-json/wc/v3/products';
$products = chiamaApiproducts($url, $username, $password);
foreach ($products as $product) {
  // stampo solo i prodotti semplici
  if ($product->type == "variable") {
    $nomeProdotto = $product->name;
    $id = $product->id;
    $url = 'https://servizi.wpschool.it/wp-json/wc/v3/products/'.$id.'/variations';
    $variations = chiamaApivariations($url, $username, $password);
    //print_r($variations);
    foreach ($variations as $variation) {
      $sku = $variation->sku; // remember to sanitize that - it is user input!
      $new_sku = str_replace(' ', '', $sku);
      $paramimg = $paramimgBig = $directoryQrcode . $new_sku . '.png';
      $paramimgBig = $directoryQrcode . $new_sku . 'Big.png';
      QRcode::png($new_sku,$paramimg,1,1);
      QRcode::png($new_sku,$paramimgBig,1,8);
      echo '<tr>';
      echo '<td>' . $variation->id . '</td>';
      echo '<td>' . $product->categories[0]->name . '</td>';
      echo '<td>' . $sku . '</td>';
      echo '<td>' . $nomeProdotto . '</td>'; 
      echo '<td>' . $variation->attributes[0]->option . '</td>';
      echo '<td>' . $variation->price . '</td>';
      echo '<td>' . $variation->stock_quantity . '</td>';
      echo '<td>'; ?>
    <!-- trigger modal -->
    <a data-bs-toggle="modal" data-bs-target="#qrcodeModal" data-bs-imgBig="<?php echo $paramimgBig; ?>" data-bs-imgDescription="<?php echo $product->name; ?>"  href=""><img src="<?php echo $paramimg; ?>"></a></td>
    <!-- Update modal -->
    <td><a data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $variation->id; ?>"    href=""><i class="bi bi-pencil"></i></a>
      <!-- Update Modal -->
      <div class="modal" id="updateModal<?php echo $variation->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h1 class="modal-title fs-5" id="updateModalLabel">Modifica <?php echo $product->name ?></h1>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           <form class="form" action="modificaProdottoVariabile.php" method="post">
             <div class="text-danger font-weight-bold">
               ID : <?php echo $variation->id ?>
               <input type="hidden" name="id" value="<?php echo $variation->id ?>">
               <input type="hidden" name="idProduct" value="<?php echo $id ?>">
             </div>
             <div class="form-group mt-1">
               <label>Sku: </label>
               <input class="form-control" name="sku" value="<?php echo $variation->sku ?>">
             </div>
             <div class="form-group">
               <label>Nome: </label>
               <input class="form-control" name="name" value="<?php echo $product->name ?>">
             </div>
             <div class="form-group">
               <label>Prezzo: </label>
               <input class="form-control" name="price" value="<?php echo $variation->price ?>">
             </div>
             <div class="form-group">
               <label>Giacenza: </label>
               <input class="form-control" name="stock_quantity" value="<?php echo $variation->stock_quantity ?>">
             </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
           <button type="submit" class="btn btn-primary">Aggiorna</button>
         </div>
         </form>
       </div>
     </div>
     </div>
     <!-- Fine update modal -->
    <!-- delete modal -->
    <td><a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $variation->id; ?>"    href=""></i><i class="bi bi-trash3"></a></i>
      <!-- Delete Modal -->
      <div class="modal qrmodal" id="deleteModal<?php echo $variation->id ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Elimina <?php echo $product->name ?> - <?php echo $variation->attributes[0]->option; ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php
            echo 'Sei sicuro di voler cancellare ' . $product->name . ' - '.$variation->attributes[0]->option .'?';
            ?>
          </div>
          <form action="cancellaProdottoVariazione.php" method="post">
            <div class="modal-footer">
              <input type="hidden" name="id" value="<?php echo $variation->id ?>">
              <input type="hidden" name="idProduct" value="<?php echo $id ?>">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
              <button type="submit" class="btn btn-danger">Cancella Variazione</button>
            </div>
          </form>
        </div>
      </div>
            </div>
    </td>
   <?php echo '</tr>';
    }
  } else {
    // Stampa le informazioni del prodotto
    //crea la tabella HTML
    $sku = $product->sku; // remember to sanitize that - it is user input!
    $new_sku = str_replace(' ', '', $sku);
    $paramimg = $directoryQrcode . $new_sku . '.png';
    $paramimgBig = $directoryQrcode . $new_sku . 'Big.png';
    QRcode::png($new_sku,$paramimg,1,1);
    QRcode::png($new_sku,$paramimgBig,1,8);
    echo '<tr>';
    echo '<td>' . $product->id . '</td>';
    echo '<td>' . $product->categories[0]->name . '</td>';
    echo '<td>' . $sku . '</td>';
    echo '<td>' . $product->name . '</td>';
    echo '<td> </td>';
    echo '<td>' . $product->price . '</td>';
    echo '<td>' . $product->stock_quantity . '</td>';
    //echo '<td><img src="'.$paramimg.'"></td>';
    echo '<td>'; ?>
    <!-- trigger modal -->
    <!-- Qrcode modal --> 
    <a data-bs-toggle="modal" data-bs-target="#qrcodeModal" data-bs-imgBig="<?php echo $paramimgBig; ?>" data-bs-imgDescription="<?php echo $product->name; ?>"  href=""><img src="<?php echo $paramimg; ?>"></a></td>
    <!-- Update modal -->
    <td><a data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $product->id; ?>"    href=""><i class="bi bi-pencil"></i></a>
      <!-- Update Modal -->
      <div class="modal" id="updateModal<?php echo $product->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h1 class="modal-title fs-5" id="updateModalLabel">Modifica</h1>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           <form class="form" action="modificaProdotto.php" method="post">
             <div class="text-danger font-weight-bold">
               ID : <?php echo $product->id ?>
               <input type="hidden" name="id" value="<?php echo $product->id ?>">
             </div>
             <div class="form-group mt-1">
               <label>Sku: </label>
               <input class="form-control" name="sku" value="<?php echo $product->sku ?>">
             </div>
             <div class="form-group">
               <label>Nome: </label>
               <input class="form-control" name="name" value="<?php echo $product->name ?>">
             </div>
             <div class="form-group">
               <label>Prezzo: </label>
               <input class="form-control" name="price" value="<?php echo $product->price ?>">
             </div>
             <div class="form-group">
               <label>Giacenza: </label>
               <input class="form-control" name="stock_quantity" value="<?php echo $product->stock_quantity ?>">
             </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
           <button type="submit" class="btn btn-primary">Aggiorna</button>
         </div>
         </form>
       </div>
     </div>
     </div>
     <!-- Fine update modal -->
    </td>
    <!-- delete modal -->
    <td><a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $product->id; ?>"    href=""></i><i class="bi bi-trash3"></a></i>
      <!-- Delete Modal -->
      <div class="modal qrmodal" id="deleteModal<?php echo $product->id ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Elimina <?php echo $product->name ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php
            echo 'Sei sicuro di voler cancellare ' . $product->name . '?';
            ?>
          </div>
          <form action="cancellaProdotto.php" method="post">
            <div class="modal-footer">
              <input type="hidden" name="id" value="<?php echo $product->id ?>">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
              <button type="submit" class="btn btn-danger">Cancella Prodotto</button>
            </div>
          </form>
        </div>
      </div>
            </div>
    </td>
  </tr>
  <!-- Fine delete modal -->
  <?php } ?>
  <!-- QR Modal -->
    <div class="modal fade" id="qrcodeModal" tabindex="-1" aria-labelledby="qrcodeModalLabel" aria-hidden="true" data-bs-backdrop="static">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h1 class="modal-title fs-5" id="qrcodeModalLabel">New message</h1>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <img src="">
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           <!--<button type="button" class="btn btn-primary">Send message</button>-->
         </div>
       </div>
     </div>
   </div>
<?php } 
?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>DigiFe</span></strong>. All Rights Reserved
    </div>
    
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="modal-bs-images.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="datatable-categorie.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>