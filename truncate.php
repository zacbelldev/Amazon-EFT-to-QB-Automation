<?php
// including the config file
include('config.php');
$pdo = connect();
$sql = 'Truncate amazonSales';
$query = $pdo->prepare($sql);
$query->execute();

// redirect to the index page
header('location: index.php');

exit;



