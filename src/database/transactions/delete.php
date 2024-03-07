<?php
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: /src/user/login.php");
    exit();
}

ob_start();

include('../../include_db.php');
include(__DIR__ . "/../../../src/components/header.php"); ?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php

session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: /src/user/login.php");
    exit();
}

if (isset($_GET['transaction_id'])) {

    $transaction_id = $_GET['transaction_id'];

    $stm = $db->prepare('DELETE FROM Transactions WHERE TransactionID = :transaction_id');
    $stm->bindValue(':transaction_id', "$transaction_id", SQLITE3_TEXT);
    $res = $stm->execute();

    if ($res) {
        header('Location: /src/database/index.php');
        exit;
    }
    
    $db->close();
}

ob_end_flush(); 
?>