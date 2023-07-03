<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}

include('config.php');

// Conta il numero di righe nella tabella prodotti
$sql = "SELECT COUNT(*) FROM products";
$result = mysqli_query($conn, $sql);
$count = mysqli_fetch_array($result)[0];

// Conta il numero di righe nella tabella prodotti per le anomalie giacenze 
$sql = "SELECT COUNT(*) FROM products WHERE stock_quantity <= 5";
$resultan = mysqli_query($conn, $sql);
$countan = mysqli_fetch_array($resultan)[0];

$sql = "SELECT COUNT(*) FROM clients";
$customers = mysqli_query($conn, $sql);
$conteggio = mysqli_fetch_array($customers)[0];

$sql = "SELECT COUNT(*) FROM orders";
$orders = mysqli_query($conn, $sql);
$count_orders = mysqli_fetch_array($orders)[0];

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
        <img src="assets/img/logo.png" alt="">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo "" . $_SESSION['username'];  ?></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <!-- <li class="dropdown-header">
        <h6></h6>
      </li>
      <li>
        <hr class="dropdown-divider">
      </li> -->
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
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">



                <div class="card-body">
                  <h5 class="card-title">Prodotti</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-handbag"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $count ?></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">



                <div class="card-body">
                  <h5 class="card-title">Anomalie Giacenze<h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-sliders"></i>
                        </div>
                        <div class="ps-3">
                          <h6><?php echo $countan ?></h6>
                        </div>
                      </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">



                <div class="card-body">
                  <h5 class="card-title">Clienti</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $conteggio ?></h6>


                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12 admin">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title">Attività Recenti</h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <table class="table" id="prodotti">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Operatore</th>
                        <th scope="col">Ora</th>
                        <th scope="col">Nome</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Negozio</th>
                        <th scope="col">Magazzino</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Query per recuperare i dati dalla tabella "logs"
                      $sql = "SELECT * FROM logs GROUP BY idtable DESC LIMIT 6";

                      $result = mysqli_query($conn, $sql);

                      // Creazione di un array per contenere i dati
                      $products = array();
                      if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {


                      ?>
                          <tr>
                            <td><?php echo $row['idtable']; ?></td>
                            <td><?php echo $row['operator']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['sku']; ?></td>
                            <td><?php echo $row['stock_quantity']; ?></td>
                            <td><?php echo $row['stock_quantity_2']; ?></td>
                          </tr>
                      <?php

                        }
                      }

                      // Chiusura della connessione al database

                      ?>






                    </tbody>
                  </table>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12 admin">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <h5 class="card-title">Ordini Recenti</h5>

                  <table id="ordini" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Inserito il</th>
                        <th scope="col">Totale €</th>
                        <th scope="col">Stato ordine</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Query per recuperare i dati dalla tabella "products"
                      $sql = "SELECT * FROM orders GROUP BY id DESC LIMIT 10";
                      $result = mysqli_query($conn, $sql);

                      // Creazione di un array per contenere i dati
                      //$products = array();
                      if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {


                      ?>
                          <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['client']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><?php echo $row['order_status']; ?></td>
                          </tr>

                      <?php

                        }
                      }

                      // Chiusura della connessione al database
                      mysqli_close($conn);
                      ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->



          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">



          <!-- Website Traffic -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Riepilogo</h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  <?php
                    echo "var count = $count;";
                    echo "var countan = $countan;";
                    echo "var conteggio = $conteggio;";
                    echo "var count_orders = $count_orders;";
                  ?>
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Totale',
                      type: 'pie',
                      radius: ['40%', '60%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: count,
                          name: 'Prodotti'
                        },
                        {
                          value: countan,
                          name: 'Anomalie Giacenze'
                        },
                        {
                          value: conteggio,
                          name: 'Clienti'
                        },
                        {
                          value: count_orders,
                          name: 'Ordini'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Website Traffic -->



        </div><!-- End Right side columns -->

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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- custom js -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <script src="userRole.js"></script>


</body>

</html>