<?php
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: /src/user/login.php");
    exit();
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
ob_start();
include(__DIR__ . "/../../../src/components/header.php");
include('../../include_db.php');
?>

<h1>Editing Transaction</h1>
<a href="/">Home</a>

<?php

if (isset($_GET['transaction_id'])) {

    $transaction_id = $_GET['transaction_id'];

    $stm = $db->prepare('SELECT * FROM Transactions WHERE TransactionID = :transaction_id');

    $stm->bindValue(':transaction_id', "$transaction_id", SQLITE3_TEXT);

    $res = $stm->execute();

    $row = $res->fetchArray(SQLITE3_NUM);
    $id = $row[0];
    $Date = $row[1];
    $TransactionName = $row[2];
    $Expense = $row[3];
    $Revenue = $row[4];
    $NetTotal = $row[5];
    $TransactionType = $row[6];

    if ($Revenue > $Expense) {
        $AmountType = "Revenue";
        $Value = $Revenue;
    } else {
        $AmountType = "Expense";
        $Value = $Expense;
    }

    $db->close();
}
?>

<h1>Update</h1>

<div class="row">
    <div class="col-md-4">
        <form action="process_edit.php" method="post">
            <div class="form-group">
                <label hidden for="id" class="control-label" name="id" id="id"></label>
                <input type="hidden" for="id" class="form-control" name="id" id="id" value="<?php echo $id; ?>" />
            </div>

            <div class="form-group">
                <label for="Date" class="control-label">Date</label>
                <input for="Date" class="form-control" name="Date" id="Date" value="<?php echo $Date; ?>" />
            </div>

            <div class="form-group">
                <label for="TransactionName" class="control-label">TransactionName</label>
                <input for="TransactionName" class="form-control" name="TransactionName" id="TransactionName" value="<?php echo $TransactionName; ?>" />
            </div>

            <div class="form-group">
                <label for="AmountType" class="control-label">Category</label>
                <select for="AmountType" class="form-control" name="AmountType" id="AmountType">
                    <?php
                    echo "<option value='$AmountType' selected hidden>$AmountType</option>"
                    ?>
                    <option value="Revenue">Revenue</option>
                    <option value="Expense">Expense</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Value" class="control-label">Amount</label>
                <input for="Value" class="form-control" name="Value" id="Value" value="<?php echo $Value; ?>" />
            </div>

            <div class="form-group">
                <label for="TransactionType" class="control-label">Type</label>
                <select for="TransactionType" class="form-control" name="TransactionType" id="TransactionType" disabled>
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
                <input type="submit" value="Update" name="update" class="btn btn-warning" />
            </div>
        </form>
    </div>
</div>

<br />

<?php
include(__DIR__ . "/../../../src/components/footer.php");
ob_end_flush(); ?>