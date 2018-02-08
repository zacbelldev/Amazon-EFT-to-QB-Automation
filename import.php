<?php

$csv = array();

$servername = "127.0.0.1";
$username = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$password = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$dbname = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$orderInsert = $conn->prepare("INSERT INTO amazonSales (date_time, settlement_id, trans_type, order_id, amazon_sku, description, quantity, marketplace, fulfilled_by, order_city, order_state, order_postal, product_sales, shipping_credits, gift_wrap_credits, promo_rebates, sales_tax_collected, selling_fees, fba_fees, other_trans_fees, other, total, skuConversion) SELECT :date_time, :settlement_id, :trans_type, :order_id, :amazon_sku , :description, :quantity, :marketplace, :fulfilled_by, :order_city, :order_state, :order_postal, :product_sales, :shipping_credits, :gift_wrap_credits, :promo_rebates, :sales_tax_collected, :selling_fees, :fba_fees, :other_trans_fees, :other, :total, `sku` FROM amazonListings WHERE `amazonSku` = :amazon_sku");

$feesInsert = $conn->prepare("INSERT INTO amazonSales (date_time, settlement_id, trans_type, order_id, amazon_sku, description, quantity, marketplace, fulfilled_by, order_city, order_state, order_postal, product_sales, shipping_credits, gift_wrap_credits, promo_rebates, sales_tax_collected, selling_fees, fba_fees, other_trans_fees, other, total, skuConversion) SELECT :date_time, :settlement_id, :trans_type, :order_id, :amazon_sku , :description, :quantity, :marketplace, :fulfilled_by, :order_city, :order_state, :order_postal, :product_sales, :shipping_credits, :gift_wrap_credits, :promo_rebates, :sales_tax_collected, :selling_fees, :fba_fees, :other_trans_fees, :other, :total, `sku` FROM amazonListings WHERE `amazonSku` = :trans_type");

// check there are no errors
if ($_FILES['csv']['error'] == 0) {
    $name = $_FILES['csv']['name'];
//    $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
    $ext = 'csv';
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];
    ini_set('auto_detect_line_endings', true);

    // check the file is a csv
//    if ($ext === 'csv') {
        if (($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);
            $row = 0;

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {


//                THE LINE BELOW IS CAUSING THE ISSUE OF not ADDING CERTAIN ROWS

                //tomorrow try if (count($data) == 12){}

                if(isset($data[0]) && isset($data[1]) && isset($data[2]) && isset($data[3]) && isset($data[4]) && isset($data[5]) && isset($data[6])) {


                    if ($row <= 1) {
                        $row++;
                        continue;
                    }
                    // get the values from the csv
                    $csv[$row]['date_time'] = $data[0];
                    $csv[$row]['settlement_id'] = $data[1];
                    if ($data[2] == "Transfer") {
                        $data[8] = "Seller";
                    }
                    $csv[$row]['trans_type'] = $data[2];
                    $csv[$row]['order_id'] = $data[3];
                    $csv[$row]['amazon_sku'] = $data[4];
                    $csv[$row]['description'] = $data[5];
//                    if (empty($data[6])) {
                        $data[6] = "1";
//                    }
                    $csv[$row]['quantity'] = $data[6];
                    $csv[$row]['marketplace'] = $data[7];
                    if (empty($data[8])) {
                        $data[8] = "Amazon";
                    }
                    $csv[$row]['fulfilled_by'] = $data[8];
                    $csv[$row]['order_city'] = $data[9];
                    $csv[$row]['order_state'] = $data[10];
                    $csv[$row]['order_postal'] = $data[11];
                    $csv[$row]['product_sales'] = $data[12];
                    $csv[$row]['shipping_credits'] = $data[13];
                    $csv[$row]['gift_wrap_credits'] = $data[14];
                    $csv[$row]['promo_rebates'] = $data[15];
                    $csv[$row]['sales_tax_collected'] = $data[16];
                    $csv[$row]['selling_fees'] = $data[17];
                    $csv[$row]['fba_fees'] = $data[18];
                    $csv[$row]['other_trans_fees'] = $data[19];
                    $csv[$row]['other'] = $data[20];
                    $csv[$row]['total'] = $data[21];

//                    echo "<pre>";
//                    var_dump($data);
//                    echo "</pre>";
//                    echo "<br><br>";

                    if ($csv[$row]['trans_type'] == "Order") {
                        if (!$orderInsert->execute(array(
                            ':date_time' => "{$csv[$row]['date_time']}",
                            ':settlement_id' => "{$csv[$row]['settlement_id']}",
                            ':trans_type' => "{$csv[$row]['trans_type']}",
                            ':order_id' => "{$csv[$row]['order_id']}",
                            ':amazon_sku' => "{$csv[$row]['amazon_sku']}",
                            ':description' => "{$csv[$row]['description']}",
                            ':quantity' => "{$csv[$row]['quantity']}",
                            ':marketplace' => "{$csv[$row]['marketplace']}",
                            ':fulfilled_by' => "{$csv[$row]['fulfilled_by']}",
                            ':order_city' => "{$csv[$row]['order_city']}",
                            ':order_state' => "{$csv[$row]['order_state']}",
                            ':order_postal' => "{$csv[$row]['order_postal']}",
                            ':product_sales' => "{$csv[$row]['product_sales']}",
                            ':shipping_credits' => "{$csv[$row]['shipping_credits']}",
                            ':gift_wrap_credits' => "{$csv[$row]['gift_wrap_credits']}",
                            ':promo_rebates' => "{$csv[$row]['promo_rebates']}",
                            ':sales_tax_collected' => "{$csv[$row]['sales_tax_collected']}",
                            ':selling_fees' => "{$csv[$row]['selling_fees']}",
                            ':fba_fees' => "{$csv[$row]['fba_fees']}",
                            ':other_trans_fees' => "{$csv[$row]['other_trans_fees']}",
                            ':other' => "{$csv[$row]['other']}",
                            ':total' => "{$csv[$row]['total']}"
                        ))
                        ) {
                            print_r($orderInsert->errorInfo());
                        }

                    } else {
                        if (!$feesInsert->execute(array(
                            ':date_time' => "{$csv[$row]['date_time']}",
                            ':settlement_id' => "{$csv[$row]['settlement_id']}",
                            ':trans_type' => "{$csv[$row]['trans_type']}",
                            ':order_id' => "{$csv[$row]['order_id']}",
                            ':amazon_sku' => "{$csv[$row]['amazon_sku']}",
                            ':description' => "{$csv[$row]['description']}",
                            ':quantity' => "{$csv[$row]['quantity']}",
                            ':marketplace' => "{$csv[$row]['marketplace']}",
                            ':fulfilled_by' => "{$csv[$row]['fulfilled_by']}",
                            ':order_city' => "{$csv[$row]['order_city']}",
                            ':order_state' => "{$csv[$row]['order_state']}",
                            ':order_postal' => "{$csv[$row]['order_postal']}",
                            ':product_sales' => "{$csv[$row]['product_sales']}",
                            ':shipping_credits' => "{$csv[$row]['shipping_credits']}",
                            ':gift_wrap_credits' => "{$csv[$row]['gift_wrap_credits']}",
                            ':promo_rebates' => "{$csv[$row]['promo_rebates']}",
                            ':sales_tax_collected' => "{$csv[$row]['sales_tax_collected']}",
                            ':selling_fees' => "{$csv[$row]['selling_fees']}",
                            ':fba_fees' => "{$csv[$row]['fba_fees']}",
                            ':other_trans_fees' => "{$csv[$row]['other_trans_fees']}",
                            ':other' => "{$csv[$row]['other']}",
                            ':total' => "{$csv[$row]['total']}"
                        ))
                        ) {
                            print_r($feesInsert->errorInfo());
                        }
                    }
                }

                // inc the row
                $row++;
            }

            fclose($handle);
        }
//    }
}

// redirect to the index page
header('location: index.php');