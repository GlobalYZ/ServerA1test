<?php ob_start();
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: /src/user/login.php");
    exit();
}
include('../../include_db.php');
include(__DIR__ . "/../../../src/components/header.php"); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php

if (isset($_GET['bucket_id'])) {

    $bucket_id = $_GET['bucket_id'];

    $stm = $db->prepare('DELETE FROM Buckets WHERE id = :bucket_id');
    $stm->bindValue(':bucket_id', "$bucket_id", SQLITE3_TEXT);
    $res = $stm->execute();

    if ($res) {
        header('Location: /src/database/bucket/buckets.php');
        exit;
    }

    $db->close();
}

?>