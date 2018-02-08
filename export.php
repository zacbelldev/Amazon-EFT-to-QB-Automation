<?php
// including the config file
include('config.php');
$pdo = connect();

// set headers to force download on csv format
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Amazon To QuickBooks.csv');

// we initialize the output with the headers
$output = "bill_name,ship_name,ship_addr1,ship_addr2,ship_city,ship_state,ship_zip,ship_country,cust_po,item_num,quantity,unit_price\n";

// select all members
$sql = 'SELECT a.fulfilled_by, a.skuConversion, sum(a.quantity) as quantity, a.total FROM amazonSales a where a.fulfilled_by = "Amazon" group by a.skuConversion, a.total order BY quantity DESC';
$query = $pdo->prepare($sql);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
    // add new row
    $output .=
        $rs['fulfilled_by'].",".
        " ".",".
        " ".",".
        " ".",".
        " ".",".
        " ".",".
        " ".",".
        " ".",".
        $rs['fulfilled_by'].",".
        $rs['skuConversion'].",".
        $rs['quantity'].",".
        $rs['total'].","."\n";
}
// export the output
echo $output;
exit;



