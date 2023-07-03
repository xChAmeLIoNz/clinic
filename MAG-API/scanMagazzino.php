<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['role']) && $_SESSION['role'] != 'operatore_magazzino' && $_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
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
            <h1>Scan Magazzino</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Scan Magazzino</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <br>

                            <div id="numprod"></div>


                            <br>

                            <!-- Vertical Form -->
                            <form class="row g-3">
                                <div class="col-12">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" placeholder="SKU" id="sku" name="sku" style="max-width:400px" required autofocus onkeypress="return validate(event);" /><br>
                                </div>
                                <div class="col-12">
                                    <label for="qty_add" class="form-label">QUANTITÀ</label>
                                    <input type="number" id="qty_add" style="max-width:400px" /><br>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary" id="salvadat">Salva</button>
                                    <button class="btn btn-secondary" name="resetcart" id="resetcart" onClick="resetnput();">Reset</button>
                                    <button class="btn btn-info" style="padding: 10 10;" id="refresh" onclick="refreshPage()"><i class="bi bi-arrow-clockwise"></i></button>
                                </div>
                            </form><!-- Vertical Form -->

                        </div>


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

    <script src="userRole.js"></script>

    <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->
    <script src="datatable-categorie.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        const input = document.getElementById("sku");
        input.addEventListener('keydown', updateValue);

        $('#salvadat').on('click', addToCart);

        $(document).ready(() => {
            refreshNumProd();
        });

        function updateValue(e) {

            //ENTER key is pressed (BARCODE Scanner)
            if (event.which === 13) {
                var skuText = e.target.value;
                if (skuText != '') {

                    const arr = [skuText];

                    const jsonString = JSON.stringify(arr);

                    console.log("jsonStrin=:" + jsonString);


                    $.ajax({
                        url: 'getProd.php',
                        type: 'post',
                        data: {
                            skuText: jsonString
                        },
                        success: function(response) {
                            console.log(response);
                            const obj = JSON.parse(response);
                            console.log(obj);
                            var sku = obj.sku;
                            //var qty = obj.qty;
                            var qty = parseInt($('#qty_add').val()) || 0;
                            //var qty_mag = obj.qty_mag;
                            var name = obj.name;
                            var price = obj.price;
                            if (sku == '') {
                                alert("Codice non presente");
                                document.getElementById('sku').value = '';
                                resetnput();
                            } else {
                                document.getElementById('sku').value = skuText;
                                if (qty == 0) {
                                    $('#qty_add').val(qty + 1);
                                } else {
                                    $('#qty_add').val(qty);
                                }
                                //$('#qty_mag').val(qty_mag);
                                //$('#posizione').text('Il prodotto è presente in: ' + obj.pos);

                                if ($('#qty_add').val() > 0) {
                                    const data = [sku, $('#qty_add').val()];
                                    const json = JSON.stringify(data);
                                    console.log(json);

                                    $.ajax({
                                        url: 'addCartMag.php',
                                        type: 'post',
                                        data: {
                                            data: json
                                        },
                                        success: (response) => {
                                            console.log(response);
                                            const obj = JSON.parse(response);
                                            let status = obj.response;
                                            if (status == 'update') {
                                                resetnput();
                                                $('#posizione').text("Il prodotto nel carrello è stato aggiornato");
                                            } else if (status == 'insert') {
                                                resetnput();
                                                $('#posizione').text("Il prodotto è stato aggiunto nel carrello");
                                            } else {
                                                resetnput();
                                                $('#posizione').text("Qualcosa è andato storto");
                                            }
                                            refreshPage();
                                        }
                                    });

                                } else {
                                    alert("Qty non può essere vuoto");
                                }
                                refreshPage();
                                //$('#sku').focus();
                                //$('#sku').select();
                                if (obj.pos == 'export') {
                                    $('#posizione').text('Il prodotto è già presente nel carrello e verrà aggiornato');

                                } else if (obj.pos == 'products') {
                                    $('#posizione').text('Il prodotto non esiste nel carrello e verrà inserito');
                                }

                            }


                        }
                    });
                }



            }

        }

        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9A-Za-z]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        function addToCart(e) {
            e.preventDefault();
            let sku = $('#sku').val();
            let qty = $('#qty_add').val();

            const arr = [sku];

            const jsonString = JSON.stringify(arr);
            $.ajax({
                url: 'getProd.php',
                type: 'post',
                data: {
                    skuText: jsonString
                },
                success: function(response) {

                    const obj = JSON.parse(response);

                    var sku = obj.sku;
                    if (sku != '' && sku != null) {
                        if (qty > 0) {
                            const data = [sku, qty];
                            const json = JSON.stringify(data);
                            console.log(json);

                            $.ajax({
                                url: 'addCartMag.php',
                                type: 'post',
                                data: {
                                    data: json
                                },
                                success: (response) => {
                                    console.log(response);
                                    const obj = JSON.parse(response);
                                    let status = obj.response;
                                    if (status == 'update') {
                                        console.log(status);
                                        resetnput();
                                        $('#posizione').text("Il prodotto nel carrello è stato aggiornato");
                                    } else if (status == 'insert') {
                                        console.log(status);
                                        resetnput();
                                        $('#posizione').text("Il prodotto è stato aggiunto nel carrello");
                                    } else {
                                        resetnput();
                                        $('#posizione').text("Qualcosa è andato storto");
                                    }
                                    refreshPage();
                                }
                            });

                        } else {
                            alert("Qty non può essere vuoto o minore di 1");
                        }

                    } else {
                        alert("SKU vuoto o inesistente");
                        resetnput();
                    }
                }

            });


        }

        function refreshNumProd() {
            $.ajax({
                url: 'numProdottiMag.php',
                success: (response) => {
                    $('#numprod').html(response); // Aggiorna l'elemento HTML con il nuovo numero di prodotti
                }
            });
        }

        function resetnput() {
            document.getElementById('sku').value = '';
            $('#qty').val('');
            $('#qty_mag').val('');
            $('#posizione').text('');
            $('#qty_add').val('');
            $('#qty_add_mag').val('');
            $('#info_sku').val('');
            $('#info_name').val('');
            $('#info_price').val('');
            $('#info_prod').hide();
            document.getElementById("sku").focus();

        }

        function refreshPage() {
            window.location.href = 'scanMagazzino.php';
            document.getElementById("sku").focus();

        }
    </script>

</body>

</html>