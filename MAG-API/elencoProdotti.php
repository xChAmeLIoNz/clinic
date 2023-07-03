<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}
?>
<?php
// includi il file di configurazione del database
include('config.php');
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
  <!-- Datatables JQuery -->
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">




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
      <i class="bi bi-list toggle-sidebar-btn">
      </i>
    </div><!-- End Logo -->
    <form method="post" action="sync.php">
      <input type="submit" name="sync_prodotti" value="Sincronizza" />
    </form>

    <nav class="header-nav ms-auto">
      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo "" . $_SESSION['username'];  ?></span>
        </a>
        <!-- Profile Dropdown Items -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

          <li>
            <a class="dropdown-item d-flex align-items-center" href="logout.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li>

    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include('aside.php');?>

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
              <br>




              <!-- Table with stripped rows -->
              <table class="table" id="prodottiModifica">
                <thead>
                  <tr><!--
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">EAN</th>
                    <th scope="col">Negozio</th>
                    <th scope="col">Magazzino</th>
                    <th scope="col">Modifica</th>
                    -->
                  </tr>
                </thead>
                <tbody>
                  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editModalLabel">Modifica prodotto</h5>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="editForm">
                            <div class="form-group">
                              <label for="name">ID:</label>
                              <input type="text" class="form-control" id="id" name="id" readonly>
                            </div>
                            <div class="form-group">
                              <label for="name">Nome:</label>
                              <input type="text" class="form-control" id="name" name="name" readonly>
                            </div>
                            <div class="form-group">
                              <label for="price">Prezzo:</label>
                              <input type="number" step="0.01" class="form-control" id="price" name="price" readonly>
                            </div>
                            <div class="form-group">
                              <label for="sku">EAN:</label>
                              <input type="text" class="form-control" id="sku" name="sku" readonly>
                            </div>
                            <div class="form-group admin">
                              <label for="stock_quantity">Qty Negozio:</label>
                              <input type="number" class="form-control" id="stock_quantity" name="stock_quantity">
                            </div>
                            <div class="form-group admin">
                              <label for="stock_quantity_2">Qty Magazzino:</label>
                              <input type="number" class="form-control" id="stock_quantity_2" name="stock_quantity_2">
                            </div>
                            <!-- <input type="hidden" id="id" name="id"> -->
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="$('#prodottiModifica_filter input').focus();">Chiudi</button>
                          <button type="submit" class="btn btn-primary" id="saveBtn">Salva Modifiche</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

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
  <!-- <script src="modal-bs-images.js"></script> -->
  <!-- datatables jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

  <script src="elencoProdotti.js"></script>
  <script src="userRole.js"></script>

  <script>
    function checkCookie() {
      var notificationShown = getCookie("notificationShown");
      if (notificationShown != "") {
        // La notifica è già stata mostrata, non fare nulla
      } else {
        // La notifica non è ancora stata mostrata, mostra la notifica e imposta il cookie
        alert("Ricorda di premere il pulsante sincronizza prima di visualizzare o modificare i prodotti!");
        setCookie("notificationShown", "true", 1);
      }
    }

    function setCookie(cname, cvalue, exhours) {
      var d = new Date();
      d.setTime(d.getTime() + (exhours * 60 * 60 * 1000));
      var expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    if (!(window.location.search.substr(1) == 'sync=true')) {
      window.onload = function() {
        checkCookie();
      }
    }
  </script>

  <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->
  <script src="datatable-categorie.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>