<?php

include('config.php');

// Retrieve the data from the database
$query = "SELECT id, name, price, sku, stock_quantity, stock_quantity_2 FROM products";

/*
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query .= " WHERE id=$id";
}
*/

$result = mysqli_query($conn, $query);

// Process the data and return it as JSON
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);