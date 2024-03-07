<?php ob_start();
include("src/components/header.php"); ?>
<?php include(__DIR__ . '/src/include_db.php'); ?>
<?php

//  This is the start of user logic
// create users table of not exist
$SQL_create_table = "CREATE TABLE IF NOT EXISTS Users (
        UserEmail VARCHAR(30),
        UserPassword VARCHAR(30) NOT NULL,
        UserRole VARCHAR(10) NOT NULL,
        Approved BOOLEAN NOT NULL DEFAULT FALSE,
        PRIMARY KEY (UserEmail)
    );";

$db->exec($SQL_create_table);

$tableNmae = "Users";

//otherwise, lead user to login page
require_once $_SERVER['DOCUMENT_ROOT'] . "/src/user/user.php";
$result = $db->querySingle("SELECT COUNT(*) FROM $tableNmae");
$adminPass = 'P@$' . '$' . 'w0rd';
$adminEmail = 'aa@aa.aa';
$adminApproved = true;
$if_duplicated = User::checkDuplicate($db, $adminEmail);
if ($if_duplicated == false) {
    $insert = "INSERT INTO Users (UserEmail, UserPassword, UserRole, Approved) VALUES ('$adminEmail', '$adminPass', 'admin', '$adminApproved')";
    $db->exec($insert);
}


session_start();

if (isset($_SESSION['email'])) {
    session_start();
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];
    echo "<h1>Welcome back, " . $email . "!</h1>";
    echo "Your role is " . $role;
    echo "<br>";
} else {
    header("Location: /src/user/login.php");
}

if ($_SESSION['role'] == 'admin') {
    header("Location: /src/admin/admin_view.php");
    exit();
}

if ($_SESSION['approved'] != true) {
    header("Location: /src/user/login.php?message=" . urlencode("You are not approved yet! Can not login"));
} else {
    header("Location: /src/database/index.php");
    exit();
}

?>

<!-- this is the end of user logic -->

<!-- Making a test button to work with database while learning w2-->
<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
    <input type="button" value="Database" onclick="location.href='/src/database/index.php'" />
</div>

<?php include("src/components/footer.php");
ob_end_flush(); ?>