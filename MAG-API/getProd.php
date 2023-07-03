
<?php
//require_once('protect-this.php');
include('config.php');

session_start();
$id_user = $_SESSION['id_user'];

function getprod_sku($sku, $conn,$id_user)
{
    $arrres = array();
    $arrres['sku'] = '';
    $arrres['qty'] = 0;
    $arrres['qty_mag'];
    $arrres['pos'] = '';
    $arrres['name'] = '';
    $arrres['price'] = '';


    if ($sku != '') {

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            //cerco prima nel cart
            $sql  = "SELECT * FROM export WHERE sku='$sku' AND id_user='$id_user';";

            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $arrres['sku'] = $row['sku'];
                $arrres['qty'] = $row['qty_neg'];
                $arrres['qty_mag'] = $row['qty_mag'];
                $arrres['pos'] = 'export';
                $arrres['name'] = $row['name'];
                $arrres['price'] = $row['price'];
            } else {
                $sql1 = "SELECT * FROM products WHERE sku='$sku';";
                $result1 = $conn->query($sql1);
                if ($result1->num_rows > 0) {
                    $row1 = $result1->fetch_assoc();
                    $arrres['sku'] = $row1['sku'];
                    $arrres['qty'] = $row1['stock_quantity'];
                    $arrres['qty_mag'] = $row1['stock_quantity_2'];
                    $arrres['pos'] = 'products';
                    $arrres['name'] = $row1['name'];
                    $arrres['price'] = $row1['price'];
                }
            }
        }
    }
    return $arrres;
}




if (isset($_POST['skuText'])) {

    $strjs = $_POST['skuText'];

    // echo "<script type='text/javascript'>alert('$strjs');</script>";
    $arrparam = json_decode($strjs, true);
    $arrres = array();
    $sku = $arrparam[0];




    if ($sku != '') {
        $arrres =  getprod_sku($sku, $conn, $id_user);
    }

    //print_r($arrres);
    echo json_encode($arrres);
}

?>