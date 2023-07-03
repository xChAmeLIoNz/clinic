<?php
include('config.php');

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user'];
?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Carrello Negozio</title>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
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
    <?php include('aside.php'); ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Carrello Negozio</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Carrello Negozio</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Carrello Negozio
                            </h5>

                            <button class="btn btn-info" style="padding: 10 10;" id="refresh" onclick="refreshPage()"><i class="bi bi-arrow-clockwise"></i></button>
                            <br>

                            <br>
                            <div class="btn-group" style="margin-bottom: 15px;" role="group" aria-label="Bottoni di filtro">
                                <button type="button" class="btn btn-outline-primary" id="scaricoProdotto">Scarico Prodotti</button>

                                <button type="button" class="btn btn-outline-success" id="caricoProdotto">Carico Prodotti</button>

                                <button type="button" class="btn btn-outline-danger" id="svuotaCarrello">Svuota</button>

                                <button type="button" class="btn btn-warning" id=""><a style="text-decoration: none; color: inherit;" href="scanNegozio.php">Torna allo scan</a></button>
                            </div>


                            <!-- Table with stripped rows -->
                            <table class="table" id="prodotti">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Prezzo</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Quantità</th>
                                        <th scope="col">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Query per recuperare i dati dalla tabella "products"
                                    $sql = "SELECT * FROM export WHERE id_user='$id_user' ORDER BY idtable DESC;";
                                    $result = mysqli_query($conn, $sql);

                                    // Creazione di un array per contenere i dati
                                    //$products = array();
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {


                                    ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td><?php echo $row['sku']; ?></td>
                                                <td><?php echo $row['qty_neg']; ?></td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <form action="editCartNeg.php" method="post">
                                                            <input type="hidden" name="sku" value="<?php echo $row['sku']; ?>">
                                                            <button class="btn" type="submit" name="submit"><i class="bi bi-pencil"></i></button>
                                                        </form>
                                                        <form action="eliminaCarrello.php" method="GET" onsubmit="return confermaEliminazione()">
                                                            <input type="hidden" name="item" value="<?php echo $row['sku']; ?>">
                                                            <button type="submit" name="submit" class="btn"><i class="bi bi-dash-circle"></i></button>
                                                        </form>

                                                    </div>
                                                </td>
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

    </main>
    
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <script>
        $(document).ready(() => {
            $.ajax({
                url: 'checkCart.php',
                type: 'post',
                data: {
                    data: 'neg'
                },
                success: (response) => {
                    const obj = JSON.parse(response);
                    if (obj.response == 'empty') {
                        $('#scaricoProdotto').prop('disabled', true);
                        $('#caricoProdotto').prop('disabled', true);
                        $('#svuotaCarrello').prop('disabled', true);
                    } else {
                        $('#scaricoProdotto').prop('disabled', false);
                        $('#caricoProdotto').prop('disabled', false);
                        $('#svuotaCarrello').prop('disabled', false);
                    }
                }
            })
        });

        //scarico prodotti is pressed
        $('#scaricoProdotto').on('click', () => {
            $.ajax({
                url: 'scaricoProdottiNeg.php',
                type: 'post',
                success: (response) => {
                    const obj = JSON.parse(response);
                    if (obj.response == 'carico') {
                        alert("prodotto scaricato dal carrello");
                        location.reload();
                    }
                }
            })
        });

        //carico prodotti is pressed
        $('#caricoProdotto').on('click', () => {
            $.ajax({
                url: 'caricoProdottiNeg.php',
                type: 'post',
                success: (response) => {
                    const obj = JSON.parse(response);
                    console.log(obj);
                    if (obj.response == 'carico') {
                        alert("prodotto caricato dal carrello");
                        location.reload();
                    }
                }
            })
        });

        $('#svuotaCarrello').on('click', () => {
            if (confirm("Sei sicuro di voler svuotare il carrello?")) {
                $.ajax({
                    url: 'eliminaCarrello.php',
                    type: 'post',
                    success: (response) => {
                        const obj = JSON.parse(response);
                        if (obj.response == 'empty') {
                            //alert("Il carrello è vuoto");
                            console.log("carrello vuoto");
                            location.reload();
                        } else if (obj.response == 'delete') {
                            //alert("Il carrello è stato svuotato");
                            console.log("carrello svuotato");
                            location.reload();
                        }
                    }
                })
            }
        });

        function confermaEliminazione() {
            return confirm("Sei sicuro di voler eliminare questo prodotto dal carrello?");
        }


        // $('.delete_item').each(() => {
        //     $(this).on('click', (e) => {
        //         e.preventDefault();
        //         let sku = $(this).closest('tr').find('.sku_delete_item').val();

        //         if (confirm("Sei sicuro di voler togliere questo prodotto dal carrello?")) {
        //             $.ajax({
        //                 url: 'eliminaCarrello.php',
        //                 type: 'get',
        //                 data: {
        //                     item: sku
        //                 },
        //                 success: (response) => {
        //                     const obj = JSON.parse(response);
        //                     console.log(obj.sku);
        //                     if (obj.response == 'empty') {
        //                         //alert("Il carrello è vuoto");
        //                         console.log("prodotto non nel carrello");
        //                         location.reload();
        //                     } else if (obj.response == 'delete') {
        //                         //alert("Il carrello è stato svuotato");
        //                         console.log("prodotto svuotato dal carrello");
        //                         location.reload();
        //                     }
        //                 }
        //             })
        //         }
        //     })

        // });

        function refreshPage() {
            window.location.href = 'cartNeg.php';
        }
    </script>



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
    <script src="userRole.js"></script>
</body>