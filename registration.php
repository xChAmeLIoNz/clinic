<?php
session_start();

if (isset($_SESSION['user_id'])) {
    //echo "loggato come: " . $_SESSION['user_id'];
    header("Location: index.php");
    exit;
}

//////////////////////////
//DEBUGGING|ERROR OUTPUT//
//////////////////////////

$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

ini_set("display_errors", TRUE);



//////////////////////////////
//INCLUDE DB CONNECTION FILE//
//////////////////////////////
if (isset($_POST['submit'])) {
    try {
        include_once 'dbconnect.inc.php';
    } catch (Exception $e) {
        echo "Sorry, connection unsuccessful: [ " . $e->getMessage() . " ]";
    }

    ////////////////////////////////////////////////
    //POPULATE VARIABLES WITH SANITIZED USER INPUT//
    ////////////////////////////////////////////////
    $first_name = $mysqli->real_escape_string($_POST['first_name']);
    $last_name = $mysqli->real_escape_string($_POST['last_name']);
    $dob = $mysqli->real_escape_string($_POST['dob']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $number = $mysqli->real_escape_string($_POST['number']);
    $password = password_hash($mysqli->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
    //$password_check = $mysqli->real_escape_string($_POST['password_check']);




    //////////////////////
    //PREPARED STATEMENT// 
    //////////////////////

    try {
        //STAGE 1: Prepare statement
        $stmt = $mysqli->prepare("INSERT INTO pw_iseppe_medics VALUES (DEFAULT,?,?,?,?,?,?)");
        //STAGE 2: bind and execute
        $stmt->bind_param("ssssss", $first_name, $last_name, $dob, $email, $number, $password);
        $stmt->execute();
        //echo "Dati inseriti correttamente";
        //Close statement execution to free server resources
        $stmt->close();
        header("Location: 200.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        $errmsg = $e->getMessage();
        $query_string = http_build_query(array('errmsg' => $errmsg));
        header("Location: 400.php?" . $query_string);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Registration</title>
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

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/fire.png" alt="">
                                    <span class="d-none d-lg-block">Iseppos</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                        <p class="text-center small">Enter your personal details to create account</p>
                                    </div>

                                    <form class="row g-3 needs-validation" action="registration.php" method="post" novalidate>
                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Your First Name</label>
                                            <input type="text" name="first_name" class="form-control" id="yourName" required>
                                            <div class="invalid-feedback">Please, enter your first name!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Your Last Name</label>
                                            <input type="text" name="last_name" class="form-control" id="yourName" required>
                                            <div class="invalid-feedback">Please, enter your last name!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Your Date of Birth</label>
                                            <input type="date" name="dob" class="form-control" id="yourDob" required>
                                            <div class="invalid-feedback">Please, enter your dob!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Your Email</label>
                                            <input type="email" name="email" class="form-control" id="yourEmail" required>
                                            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Telephone</label>
                                            <input type="text" name="number" class="form-control" id="yourTelephone" required>
                                            <div class="invalid-feedback">Please enter your telephone.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password again</label>
                                            <input type="password" name="password_check" class="form-control" id="yourPasswordCheck" required>
                                            <div class="invalid-feedback">Please enter your password again!</div>
                                            <div id="password_match_feedback" class="invalid-feedback" style="display:none;">Passwords do not
                                                match!</div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                                <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and
                                                        conditions</a></label>
                                                <div class="invalid-feedback">You must agree before submitting.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" name="submit" type="submit">Create Account</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', checkPasswordsMatch);


        function checkPasswordsMatch() {
            const passwordField = document.getElementById('yourPassword');
            const passwordCheckField = document.getElementById('yourPasswordCheck');
            const passwordMatchFeedback = document.getElementById('password_match_feedback');

            if (passwordField.value !== passwordCheckField.value) {
                passwordMatchFeedback.style.display = 'block';
                passwordCheckField.setCustomValidity('Passwords do not match!');
            } else {
                passwordMatchFeedback.style.display = 'none';
                passwordCheckField.setCustomValidity('');
            }
        }
    </script>

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