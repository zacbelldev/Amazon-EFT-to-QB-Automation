<?php
// including the config file
include('config.php');
$pdo = connect();
// select all members
$sql = 'SELECT * FROM amazonSales ORDER BY id';
$query = $pdo->prepare($sql);
$query->execute();
$list = $query->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Import CSV to MySQL and Export from MySQL to CSV in PHP</title>
    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>

<body>
<div class="container">
    <div class="header">
    </div><!-- header -->
    <!--        <h1 class="main_title">Import CSV to MySQL and Export from MySQL to CSV in PHP</h1>-->

    <div class="content">
        <fieldset class="field_container align_right">

            <span class="import" onclick="show_popup('popup_upload')">Import Transaction File</span>

            <a href="export.php" class="export">Export QuickBooks File</a>

            <a href="truncate.php" class="export">Delete Existing Data</a>

        </fieldset>

        <fieldset class="field_container">

            <div id="list_container">
                <table class="table_list" cellspacing="2" cellpadding="0">
                    <tr class="bg_h">
                        <th>date/time</th>
                        <th>settlement id</th>
                        <th>type</th>
                        <th>order id</th>
                        <th>amazon sku</th>
                        <th>description</th>
                        <th>quantity</th>
                        <th>marketplace</th>
                        <th>fulfillment</th>
                        <th>order city</th>
                        <th>order state</th>
                        <th>order postal</th>
                        <th>product sales</th>
                        <th>shipping credits</th>
                        <th>gift wrap credits</th>
                        <th>promotional rebates</th>
                        <th>sales tax collected</th>
                        <th>selling fees</th>
                        <th>fba fees</th>
                        <th>other transaction fees</th>
                        <th>other</th>
                        <th>total</th>
                        <th>skuConversion</th>
                    </tr>
                    <?php
                    $bg = 'bg_1';
                    foreach ($list as $rs) {
                        ?>
                        <tr class="<?php echo $bg; ?>">
                            <td><?php echo $rs['date_time']; ?></td>
                            <td><?php echo $rs['settlement_id']; ?></td>
                            <td><?php echo $rs['trans_type']; ?></td>
                            <td><?php echo $rs['order_id']; ?></td>
                            <td><?php echo $rs['amazon_sku']; ?></td>
                            <td><?php echo $rs['description']; ?></td>
                            <td><?php echo $rs['quantity']; ?></td>
                            <td><?php echo $rs['marketplace']; ?></td>
                            <td><?php echo $rs['fulfilled_by']; ?></td>
                            <td><?php echo $rs['order_city']; ?></td>
                            <td><?php echo $rs['order_state']; ?></td>
                            <td><?php echo $rs['order_postal']; ?></td>
                            <td><?php echo $rs['product_sales']; ?></td>
                            <td><?php echo $rs['shipping_credits']; ?></td>
                            <td><?php echo $rs['gift_wrap_credits']; ?></td>
                            <td><?php echo $rs['promo_rebates']; ?></td>
                            <td><?php echo $rs['sales_tax_collected']; ?></td>
                            <td><?php echo $rs['selling_fees']; ?></td>
                            <td><?php echo $rs['fba_fees']; ?></td>
                            <td><?php echo $rs['other_trans_fees']; ?></td>
                            <td><?php echo $rs['other']; ?></td>
                            <td><?php echo $rs['total']; ?></td>
                            <td><?php echo $rs['skuConversion']; ?></td>
                        </tr>
                        <?php
                        if ($bg == 'bg_1') {
                            $bg = 'bg_2';
                        } else {
                            $bg = 'bg_1';
                        }
                    }
                    ?>
                </table>
            </div><!-- list_container -->
        </fieldset>

    </div><!-- content -->
    <div class="footer">
        <!--            Powered by <a href="http://www.bewebdeveloper.com/">bewebdeveloper.com</a>-->
    </div><!-- footer -->
</div><!-- container -->

<!-- The popup for upload a csv file -->
<div id="popup_upload">
    <div class="form_upload">
        <span class="close" onclick="close_popup('popup_upload')">x</span>
        <h2>Upload CSV file</h2>
        <form action="import.php" method="post" enctype="multipart/form-data">
            <input type="file" name="csv" id="csv_file" class="file_input">
            <input type="submit" value="Upload file" id="upload_btn">
        </form>
    </div>
</div>
</body>
</html>
