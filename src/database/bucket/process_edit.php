<?php ob_start();
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: /src/user/login.php");
    exit();
}
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

    $stm = $db->prepare("UPDATE Buckets SET TransactionType=?, Company=? WHERE id=?");
    $stm->bindParam(1, $TransactionType);
    $Company = strtoupper($Company);
    $stm->bindParam(2, $Company);
    $stm->bindParam(3, $id);
    $res = $stm->execute();

    if ($res) {
        header('Location: /src/database/bucket/buckets.php');
        exit;
    }
}



include(__DIR__ . "/../../../src/components/footer.php");

?>