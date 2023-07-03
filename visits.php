<?php
session_start();
if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Lista visite</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/fire.png" rel="icon">
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
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="assets/img/fire.png" alt="">
                <span class="d-none d-lg-block">Iseppos</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">



                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <?php
                            $first_name = $_SESSION['first_name'];
                            $last_name = $_SESSION['last_name'];
                            $primaUp = ucfirst($first_name[0]);
                            $name = $primaUp . '.';
                            echo $name . " " . $last_name;
                            ?>
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $first_name . " " . $last_name ?></h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="clients.php">
                    <i class="bi bi-gem"></i><span>Clienti</span><i class="bi ms-auto"></i>
                </a>
            </li><!-- End Icons Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="animals.php">
                    <i class="bi bi-gem"></i><span>Animali</span><i class="bi ms-auto"></i>
                </a>
            </li><!-- End Icons Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="medics.php">
                    <i class="bi bi-gem"></i><span>Medici</span><i class="bi ms-auto"></i>
                </a>
            </li><!-- End Icons Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="visits.php">
                    <i class="bi bi-gem"></i><span>Visite</span><i class="bi ms-auto"></i>
                </a>
            </li><!-- End Icons Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="expired_visits.php">
                    <i class="bi bi-gem"></i><span>Visite Scadute</span><i class="bi ms-auto"></i>
                </a>
            </li><!-- End Icons Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <!-- MAIN CONTENT-->
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Visite</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Lista visite</h5>
                            </div>
                            <!-- Table with hoverable rows -->
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Animale</th>
                                        <th scope="col">Data Visita</th>
                                        <th scope="col">Medico</th>
                                        <th scope="col">Referto</th>
                                        <th scope="col">Modifica</th>
                                        <th scope="col">Elimina</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    //////////////////////////
                                    //DEBUGGING|ERROR OUTPUT//
                                    //////////////////////////
                                    $driver = new mysqli_driver();
                                    $driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

                                    ini_set("display_errors", TRUE);

                                    //////////////////////////////
                                    //INCLUDE DB CONNECTION FILE//
                                    //////////////////////////////
                                    try {
                                        include_once 'dbconnect.inc.php';
                                    } catch (Exception $e) {
                                        echo "Sorry, connection unsuccessful: [ " . $e->getMessage() . " ]";
                                    }

                                    if ($result = $mysqli->query("SELECT pw_iseppe_animals.name AS animal_name, pw_iseppe_animals.id_animal AS animal_id,
                                     pw_iseppe_medics.first_name AS medic_first_name, pw_iseppe_medics.last_name AS medic_last_name, id_visit, date_visit, report FROM pw_iseppe_visits 
                                     JOIN pw_iseppe_animals ON pw_iseppe_visits.id_animal = pw_iseppe_animals.id_animal
                                     JOIN pw_iseppe_medics ON pw_iseppe_visits.id_medic = pw_iseppe_medics.id ORDER BY date_visit DESC, id_visit DESC")) {

                                        while ($row = $result->fetch_assoc()) {
                                            $date = new DateTimeImmutable($row['date_visit']);
                                            $report = $row['report'];
                                            echo "<tr>";
                                            echo "<td>" . $row['id_visit'] . "</td>";
                                            echo "<td>" . $row['animal_name'] . " [#" . $row['animal_id'] . "]" . "</td>";
                                            echo "<td>" . $date->format('d-m-Y') . "</td>";
                                            echo "<td>" . $row['medic_first_name'] . " " . $row['medic_last_name'] . "</td>";
                                            //echo "<td>" . $row['report'] . "</td>";
                                            echo '<td>
                                            <div class="col-md-6">
                                                        <div class="icon">
                                                            <!-- <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"> -->
                                                            <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#verticalycentered_report' . $row['id_visit'] . '"><i class="bi bi-book"></i></button>
                                                            <!-- </span> -->
                                                            <div class="modal fade" id="verticalycentered_report' . $row['id_visit'] . '" tabindex="-1" style="display: none;" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Referto</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                            <div class="modal-body">
                                                                               ' . $report . ' 
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
                                                                            </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </td>';

                                            /*
                      foreach ($row as $key => $value) {

                        echo "<td>" . $value . "</td>";
                      }
                      */
                                    ?>


                                            <td>

                                                <div class="col-md-6">
                                                    <div class="icon">
                                                        <!-- <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"> -->
                                                        <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#verticalycentered<?php echo $row['id_visit'] ?>"><i class="bi bi-pencil"></i></button>
                                                        <!-- </span> -->
                                                        <div class="modal fade" id="verticalycentered<?php echo $row['id_visit'] ?>" tabindex="-1" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Modifica visita</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form class="" action="edit_visits.php" method="post">
                                                                        <div class="modal-body">
                                                                            <!-- 
                                                                                <div class="col-md-12">
                                                                                    <input type="hidden" class="form-control" name="id_animal" value="<?php echo $row['id_animal']; ?>" required>
                                                                                </div>
                                                                                -->
                                                                            <div class="col-md-12">
                                                                                <input type="hidden" class="form-control" name="id_visit" value="<?php echo $row['id_visit']; ?>" required>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <input type="date" class="form-control" name="date" value="<?php echo $row['date_visit'] ?>" required>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label for="select_medic">Seleziona medico:
                                                                                </label>
                                                                                <select class="form-select" aria-label="Default select example" name="medic" required>
                                                                                    <?php
                                                                                    if ($medics = $mysqli->query("SELECT * FROM pw_iseppe_medics")) {
                                                                                        $selected_medic = "";
                                                                                        while ($righez = $medics->fetch_assoc()) {
                                                                                            if ($righez['id'] == $row['id_medic']) {
                                                                                                $selected_owner = 'selected';
                                                                                            }
                                                                                            echo '<option value="' . $righez['id'] . '" ' . $selected_owner . '>' . $righez['first_name'] . " " . $righez['last_name'] . '</option>';
                                                                                            $selected_owner = "";
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label for="report">Modifica il referto:
                                                                                </label>
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" name="report" value="<?php echo $report; ?>">
                                                                                </div>
                                                                                
                                                                                <!--<textarea name="report" class="w-100" style="height: 100px">echo $report</textarea> -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                                                            <button type="submit" name="submit" class="btn btn-primary">Invia</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-3">
                                                    <div class="icon">
                                                        <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#verticalycentered_delete<?php echo $row['id_visit'] ?>"><i class="bi bi-x-circle"></i></button>
                                                        <div class="modal fade" id="verticalycentered_delete<?php echo $row['id_visit'] ?>" tabindex="-1" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Elimina visita</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form class="" action="delete_visits.php" method="post">
                                                                        <div class="modal-body">
                                                                            Vuoi veramente eliminare questa visita? <br>
                                                                            Questa azione è irreversibile.
                                                                        </div>
                                                                        <input type="hidden" name="id_visit" value="<?php echo $row['id_visit'] ?>">
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Indietro</button>
                                                                            <button type="submit" name="submit" class="btn btn-danger">Elimina</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>


                        </div>


                        </tr>





                <?php

                                        }
                                    }


                ?>
                </tbody>
                </table>
                <!-- End Table with hoverable rows -->

                    </div>
                </div>
            </div>
            </div>
        </section>

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; 2023 ISEPPOS - <strong><span>P.IVA: 06089590481</span></strong> - <strong><span>Numero REA: FE-675488</span></strong> - PEC: <a style="text-decoration: none;" href="mailto:iseppos@cgn-legalmail.it">iseppos@cgn-legalmail.it</a> | <a href="#">Cookie</a> e <a href="#">Privacy</a>
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

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>