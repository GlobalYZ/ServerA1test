<?php
if ($_GET['email'] && $_GET['password']) {
    $db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/A1.sqlite');
    $tableNmae = "Users";

    //check duplicate email (if user existed in database)
    $checkduplicate = "SELECT UserEmail FROM Users";
    $checkDatabaseResult = $db->query($checkduplicate);
    $if_duplicated = false;
    $email = $_GET['email'];
    $password = $_GET['password'];
    while ($Row = $checkDatabaseResult->fetchArray(SQLITE3_NUM)) {
        if ($email == $Row[0]) {
            $if_duplicated = true;
            $message = "duplication error, email already existed.\n
                    creation failed";
            ob_start(); // Start output buffering
            header("Location: /src/user/login.php?message=" . urlencode($message));
            ob_end_flush(); // Send output buffer and turn off output buffering
            exit();
        }
    }

    if ($if_duplicated == false) {
        $notApproved = false;
        $insert = "INSERT INTO Users (UserEmail, UserPassword, UserRole, Approved) VALUES ('$email', '$password', 'user', '$notApproved')";
        $db->exec($insert);

        $checkduplicate = "SELECT UserEmail FROM Users";
        $checkDatabaseResult = $db->query($checkduplicate);
        while ($Row = $checkDatabaseResult->fetchArray(SQLITE3_NUM)) {
            if ($email == $Row[0]) {
                $message = "sign up is sucessful!";

                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['role'] = 'user';
                $_SESSION['approved'] = $notApproved;
                ob_start(); // Start output buffering
                header("Location: /index.php?message=" . urlencode($message));
                ob_end_flush(); // Send output buffer and turn off output buffering
                exit();
            }
        }

        header("Location: /src/user/login.php?message=" . urlencode($message));
    }
}
