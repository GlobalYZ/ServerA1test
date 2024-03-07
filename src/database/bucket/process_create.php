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

if (isset($_POST['create'])) {

    extract($_POST);

    $Category = sanitize_input($Category);
    $Company = sanitize_input($Company);

    // Checks if ID exists already
    $stm = $db->prepare('SELECT COUNT(*) as cnt FROM Buckets WHERE Company = ?');
    $stm->bindParam(1, $Company);

    $res = $stm->execute();

    $row = $res->fetchArray(SQLITE3_ASSOC);
    $count = $row['cnt'];

    $exist = FALSE;
    if ($count != 0) {
        $exist = TRUE;
    }

    if (!$exist) {
        /* create a prepared statement */
        $Company = strtoupper($Company);
        $SQL_insert_data = "INSERT INTO Buckets (TransactionType, Company)
        VALUES ('$Category', '$Company')";

        $db->exec($SQL_insert_data);
        $changes = $db->changes();
    }

    $db->close();

    if ($exist) {
        header('Location: ../bucket/create_exists.php');
    } else {
        header('Location: /src/database/bucket/buckets.php');
    }
}

include(__DIR__ . "/../../../src/components/footer.php");

?>