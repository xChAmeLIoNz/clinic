<?php
include('config.php');
?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Elenco prodotti</title>
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
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Carrello
                        </h5>

                        <br>
                        <div class="btn-group" style="margin-bottom: 15px;" role="group" aria-label="Bottoni di filtro">
                            <button type="button" class="btn btn-outline-primary" id="caricoProdotto">Carica prodotto</button>

                            <button type="button" class="btn btn-outline-danger" id="svuotaCarrello">Svuota</button>

                            <button type="button" class="btn btn-outline-secondary" id="refresh" onclick="refreshPage()">Sync</button>

                            <button type="button" class="btn btn-warning" id=""><a style="text-decoration: none;" href="scan.php">Torna allo scan</a></button>
                        </div>


                        <!-- Table with stripped rows -->
                        <table class="table" id="prodotti">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Prezzo</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Qty_Neg</th>
                                    <th scope="col">Qty_Mag</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query per recuperare i dati dalla tabella "products"
                                $sql = "SELECT * FROM export";
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
                                            <td><?php echo $row['qty_mag']; ?></td>

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




    <script>
        $('#caricoProdotto').on('click', () => {
            $.ajax({
                url: 'caricoProdotti.php',
                type: 'post',
                success: (response) => {
                    const obj = JSON.parse(response);
                    if (obj.response == 'carico') {
                        alert("prodotto caricato dal carrello");
                        location.reload();
                    }
                }
            })
        });

        $('#svuotaCarrello').on('click', () => {
            $.ajax({
                url: 'eliminaCarrello.php',
                type: 'post',
                success: (response) => {
                    const obj = JSON.parse(response);
                    if (obj.response == 'empty') {
                        alert("Il carrello è vuoto");
                    } else if (obj.response == 'delete') {
                        alert("Il carrello è stato svuotato");
                        location.reload();
                    }
                }
            })
        });

        function refreshPage() {
            window.location.href = 'cart.php';
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
</body>