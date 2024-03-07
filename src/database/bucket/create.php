<?php ob_start();
session_start();
if ($_SESSION['role'] != 'admin') {
    // echo '<script>window.location.href = "/src/user/login.php";</script>';
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

<h1>Adding Bucket</h1>
<a href="/">Home</a>

<div class="row">
    <div class="col-md-4">
        <form action="process_create.php" method="post">
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
                <label for="Company" class="control-label">Company Name</label>
                <input for="Company" class="form-control" name="Company" id="Company" />
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
?>