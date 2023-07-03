<?php
session_start();
include('config.php');
include('functions.php');


if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

checkAdminRole();
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
            <i class="bi bi-list toggle-sidebar-btn">
            </i>
        </div><!-- End Logo -->

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
            <h1>Log Modifiche</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Log Modifiche</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Logs
                            </h5>

                            

                            <!--<form action="elencoLog.php" method="get">
                                <label for="category">Categoria:</label>
                                <select name="category" id="category">
                                    <option value="">Tutti</option>
                                    <option value="carico">Carico</option>
                                    <option value="scarico">Scarico</option>
                                </select>
                                <button class="btn btn-secondary" type="submit">Filtra</button>
                            </form> -->

                            <!-- Table with stripped rows -->
                            <table class="table datatable" id="prodotti">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Operatore</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Ora</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Negozio</th>
                                        <th scope="col">Magazzino</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Recupera il valore della categoria selezionata
                                    //$category = isset($_GET['category']) ? $_GET['category'] : '';

                                    // Query per recuperare i dati dalla tabella "logs"
                                    $sql = "SELECT * FROM logs GROUP BY idtable DESC";

                                    // Aggiunge la clausola WHERE alla query in base alla categoria selezionata
                                   /* if ($category !== '') {
                                        $sql .= " WHERE type = '$category'";
                                    }

                                    $sql .= " GROUP BY idtable DESC"; */

                                    $result = mysqli_query($conn, $sql);

                                    // Creazione di un array per contenere i dati
                                    $products = array();
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {


                                    ?>
                                            <tr>
                                                <td><?php echo $row['idtable']; ?></td>
                                                <td><?php echo $row['operator']; ?></td>
                                                <td><?php echo $row['date']; ?></td>
                                                <td><?php echo $row['time']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['sku']; ?></td>
                                                <td><?php echo $row['stock_quantity']; ?></td>
                                                <td><?php echo $row['stock_quantity_2']; ?></td>
                                                <!-- Update modal -->

                                            </tr>
                                    <?php

                                        }
                                    }

                                    // Chiusura della connessione al database
                                    mysqli_close($conn);
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->
    <script src="datatable-categorie.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        $(document).ready(() => {
            $('.datatable-input').focus();
        })
    </script>

</body>

</html>