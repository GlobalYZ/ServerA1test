<?php ob_start();
//kick out if user is not admin
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: /src/user/login.php");
    exit();
}
include(__DIR__ . "/../../../src/components/header.php");
include('../../include_db.php');
?>
<h1>Editing Bucket</h1>
<a href="/">Home</a>

<?php
if (isset($_GET['bucket_id'])) {

    $bucket_id = $_GET['bucket_id'];

    $stm = $db->prepare('SELECT * FROM Buckets WHERE id = :bucket_id');

    $stm->bindValue(':bucket_id', "$bucket_id", SQLITE3_TEXT);

    $res = $stm->execute();

    $row = $res->fetchArray(SQLITE3_NUM);
    $TransactionType = $row[1];
    $Company = $row[2];

    $db->close();
}
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<h1>Update</h1>

<div class="row">
    <div class="col-md-4">
        <form action="process_edit.php" method="post">
            <div class="form-group">
                <label hidden for="id" class="control-label" name="id" id="id"></label>
                <input type="hidden" for="id" class="form-control" name="id" id="id" value="<?php echo $bucket_id; ?>" />
            </div>

            <div class="form-group">
                <label for="TransactionType" class="control-label">Category</label>
                <select for="TransactionType" class="form-control" name="TransactionType" id="TransactionType">
                    <?php
                    echo "<option value='$TransactionType' selected hidden>$TransactionType</option>"
                    ?>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Communication">Communication</option>
                    <option value="Groceries">Groceries</option>
                    <option value="Donations">Donations</option>
                    <option value="Car Insurance">Car Insurance</option>
                    <option value="Gas Heating">Gas Heating</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Company" class="control-label">Company</label>
                <input for="Company" class="form-control" name="Company" id="Company" value="<?php echo $Company; ?>" />
            </div>

            <div class="form-group">
                <input type="submit" value="Update" name="update" class="btn btn-warning" />
            </div>
        </form>
    </div>
</div>

<br />

<?php
include(__DIR__ . "/../../../src/components/footer.php");
?>