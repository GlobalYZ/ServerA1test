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


function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['create'])) {

    extract($_POST);

    $TName = sanitize_input($TName);
    $TAmount = sanitize_input($TAmount);
    $Date = date("m/d/20y");

    $SQL_select_last_net_value = "SELECT NetTotal FROM Transactions WHERE TransactionID = (SELECT MAX(TransactionID) FROM Transactions)";
    $lastNetValue = $db->querySingle($SQL_select_last_net_value);
    
    if ($TType == "Revenue") {        
        $newNetValue = $lastNetValue + $TAmount;

        /* create a prepared statement */
        $SQL_insert_data = "INSERT INTO Transactions (Date, TransactionName, Revenue, TransactionType, NetTotal)
        VALUES ('$Date', '$TName', '$TAmount', '$Category', '$newNetValue')";
    } else {
        $newNetValue = $lastNetValue - $TAmount;

        /* create a prepared statement */
        $SQL_insert_data = "INSERT INTO Transactions (Date, TransactionName, Expense, TransactionType, NetTotal)
        VALUES ('$Date', '$TName', '$TAmount', '$Category', '$newNetValue')";
    }
    
    $db->exec($SQL_insert_data);
    $changes = $db->changes();

    $db->close();

    header('Location: ../index.php');
}

include(__DIR__ . "/../../../src/components/footer.php");
ob_end_flush(); 
?>