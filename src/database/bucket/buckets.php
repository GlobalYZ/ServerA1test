<?php ob_start();
session_start();
//kick out if user is not admin
if ($_SESSION['role'] != 'admin') {
    header("Location: /src/user/login.php");
    exit();
}
include(__DIR__ . "/../../../src/components/header.php");
include('../../include_db.php');
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<?php

$res = $db->query('SELECT * FROM Buckets');

echo "<table width='100%' class='table table-striped'>\n";
echo "<tr><th>Category</th><th>Company</th><th>Features</th></tr>\n";

while ($row = $res->fetchArray()) {
    echo "<tr><td>{$row['1']}</td>";
    echo "<td>{$row['2']}</td>";
    echo "<td>";
    echo "<a class='btn btn-small btn-warning' href='edit.php?bucket_id={$row['0']}'>update</a>";
    echo "&nbsp;";
    echo "<a class='btn btn-small btn-danger' href='delete.php?bucket_id={$row['0']}'>delete</a>";
    echo "</td></tr>\n";
};

echo "</table>\n";

// Issues with footer covering list 
include(__DIR__ . "/../../../src/components/footer.php");
?>

<h1>Bucket Testing</h1>
<a href="/">Home</a>

<p><a href="../bucket/create.php" class="btn btn-small btn-success">Add Bucket</a></p>