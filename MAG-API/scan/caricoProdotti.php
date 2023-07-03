<?php
include('config.php');

$data = array(
    'response' => ''
);

if ($result = $conn->query("SELECT * FROM export")) {
    while ($row = $result->fetch_assoc()) {

        $sku = $row['sku'];
        $qty_neg = $row['qty_neg'];
        $qty_mag = $row['qty_mag'];
        if ($result_inner = $conn->query("SELECT sku, stock_quantity, stock_quantity_2 FROM products WHERE sku='$sku'")) {
            if ($result_inner->num_rows > 0) {
                $row = $result_inner->fetch_assoc();
                $final_qty_neg = $row['stock_quantity'] + $qty_neg;
                $final_qty_mag = $row['stock_quantity_2'] + $qty_mag;
                if ($conn->query("UPDATE products SET stock_quantity='$final_qty_neg', stock_quantity_2='$final_qty_mag' WHERE sku='$sku';")) {
                    $data['response'] = 'carico';
                }
            }
        }
    }
    $conn->query("DELETE FROM export WHERE 1");
}

echo json_encode($data);

