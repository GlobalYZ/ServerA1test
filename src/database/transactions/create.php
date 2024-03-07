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

<h1>Adding Transaction</h1>
<a href="/">Home</a>

<div class="row">
    <div class="col-md-4">
        <form action="process_create.php" method="post">
            <div class="form-group">
                <label for="TName" class="control-label">Transaction Name</label>
                <input for="TName" class="form-control" name="TName" id="TName" />
            </div>

            <div class="form-group">
                <label for="TType" class="control-label">Category</label>
                <select for="TType" class="form-control" name="TType" id="TType">
                    <option value="Revenue">Revenue</option>
                    <option value="Expense">Expense</option>
                </select>
            </div>

            <div class="form-group">
                <label for="TAmount" class="control-label">Transaction Amount</label>
                <input for="TAmount" class="form-control" name="TAmount" id="TAmount" />
            </div>

            <div class="form-group">
                <label for="Category" class="control-label">Category</label>
                <select for="Category" class="form-control" name="Category" id="Category">
                    <option value="Entertainment">Entertainment</option>
                    <option value="Communication">Communication</option>
                    <option value="Groceries">Groceries</option>
                    <option value="Donations">Donations</option>
                    <option value="Car Insurance">Car Insurance</option>
                    <option value="Gas Heating">Gas Heating</option>
                </select>
            </div>


            <div class="form-group">
                <input type="submit" value="Create" name="create" class="btn btn-success" />
            </div>
        </form>
    </div>
</div>

<br />

<?php
include(__DIR__ . "/../../../src/components/footer.php");
ob_end_flush(); ?>