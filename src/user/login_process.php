<?php
if ($_GET['email'] && $_GET['password']) {
    $db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/A1.sqlite');
    $tableNmae = "Users";

    //check duplicate email (if user existed in database)
    $checkduplicate = "SELECT UserEmail FROM Users";
    $checkDatabaseResult = $db->query($checkduplicate);
    $find_matched = false;
    $email = $_GET['email'];
    $role = null;
    $password = $_GET['password'];
    if ($stmt = $db->prepare("SELECT * FROM Users WHERE UserEmail = :email")) {

        $stmt->bindValue(":email", $email);

        $result = $stmt->execute();

        if ($row = $result->fetchArray()) {
            //if email mathed user
            $find_matched = true;
            if ($row['UserPassword'] == $password) {
                //password check passed, login is successful
                $message = "login is sucessful!";

                //get the user role
                $role = $row['UserRole'];
                $approved = $row['Approved'];

                //create new session
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['role'] = $role;
                $_SESSION['approved'] = $approved;

                header("Location: /index.php?message=" . urlencode($message));
            } else {
                //password check failed
                $message = "password is incorrect!";
                header("Location: /src/user/login.php?message=" . urlencode($message));
                exit();
            }
        }
    }

    if ($find_matched == false) {
        $message = "User does not exist! Please sign up first!";
        header("Location: /src/user/signup.php?message=" . urlencode($message));
        exit();
    }
}
