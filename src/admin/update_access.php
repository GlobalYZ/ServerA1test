<?php ob_start();
$db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/A1.sqlite');
require_once '../user/user.php';
if ($_GET['email'] && $_GET['approved']) {
    $email = $_GET['email'];
    $approved = $_GET['approved'];
    $result = User::updateUsers($db, $email, $approved);
    if ($result) {
        ob_start(); // Start output buffering
        header("Location: /src/admin/admin_view.php?" . urlencode("update successful"));
        ob_end_flush(); // Send output buffer and turn off output buffering
    } else {
        ob_start(); // Start output buffering
        header("Location: /src/admin/admin_view.php?" . urlencode("update failed"));
        ob_end_flush(); // Send output buffer and turn off output buffering
    }
}
