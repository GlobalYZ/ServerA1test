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


function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['update'])) {
    extract($_POST);
    // print($TransactionType . "<br>");
    // print($Company);
    // print($id);

    $Company = sanitize_input($Company);

    if ($AmountType == "Revenue") {
        $Revenue = $Value;
        $Expense = NULL;
    } else {
        $Expense = $Value;
        $Revenue = NULL;
    }
    $stm = $db->prepare("UPDATE Transactions 
    SET Date=?, TransactionName=?, Expense=?, Revenue=?
    WHERE TransactionID=?");
    $stm->bindParam(1, $Date);
    $stm->bindParam(2, $TransactionName);
    $stm->bindParam(3, $Expense);
    $stm->bindParam(4, $Revenue);
    $stm->bindParam(5, $id);
    $res = $stm->execute();

    // Flawed logic to update NetTotal
    // $stm = $db->prepare("SELECT Revenue, Expense, NetTotal FROM Transactions");

    // $count = 0;

    // while ($row = $res->fetchArray()) {
    //     if ($count == 0){
    //         $netTotal = $row['2'];
    //         $count++;
    //     }
    //     $netTotal = 

    // }

    if ($res) {
        header('Location: /src/database/index.php');
        exit;
    }
}



include(__DIR__ . "/../../../src/components/footer.php");
ob_end_flush(); 
?>