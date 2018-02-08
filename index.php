<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Amazon EFT Automation</title>
    <link rel="stylesheet" type="text/css" href="css/teststyle.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <a class="previousPage" href='/'>Previous Page</a><br><br>
        <span class="import" onclick="show_popup('popup_upload')">Import Transaction File</span>
        <a href="export.php" class="export">Export QuickBooks File</a>
        <a href="truncate.php" class="delete">Delete Existing Data</a>
        <h1 class="previousPage">Amazon EFT Automation</h1><br>
    </div>
    <div class="table">
        <table>
            <form>
                <div class="row header green">
                    <div class="cell1">date/time</div>
                    <div class="cell">type</div>
                    <div class="cell">order id</div>
                    <div class="cell">amazon sku</div>
                    <div class="cell">quantity</div>
                    <div class="cell">total</div>
                    <div class="cell">skuConversion</div>
                </div>
            </form>
            <?php
            // including the config file
            include('config.php');
            $pdo = connect();
            // select all members
            $sql = 'SELECT * FROM amazonSales ORDER BY trans_type';
            $query = $pdo->prepare($sql);
            $query->execute();
            if ($query->rowCount()) {
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    //$GET['goalDate']->format('Y/m/d');
                    echo "
                    <div class='row'>
                        <div class='cell'>{$row['date_time']}</div>
                        <div class='cell'>{$row['trans_type']}</div>
                        <div class='cell'>{$row['order_id']}</div>
                        <div class='cell'>{$row['amazon_sku']}</div>
                        <div class='cell'>{$row['quantity']}</div>
                        <div class='cell'>{$row['total']}</div>
                        <div class='cell'>{$row['skuConversion']}</div>
                    </div>";
                }
            }
            else {
                echo '<tr><td colspan="18">No Data Found</td></tr>';
            }
            ?>
        </table>
    </div>
</div>
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
