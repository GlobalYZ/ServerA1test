<?php ob_start();
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: /src/user/login.php");
    exit();
}
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
include(__DIR__ . "/../../../src/components/header.php");
include('../../include_db.php');
?>


<h1>Adding Bucket</h1>

<div class='alert alert-danger' role='alert'>
    <h4 class='alert-heading'>Error!</h4>
    <p>The bucket already exists in the database.</p>
</div>

<a href="/">Home</a>

<div class="row">
    <div class="col-md-4">
        <form action="process_create.php" method="post">
            <div class="form-group">
                <label for="Category" class="control-label">Category</label>
                <input for="Category" class="form-control" name="Category" id="Category" />
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