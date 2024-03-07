<?php

class User
{
    public static function checkDuplicate($db, $email)
    {
        $checkduplicate = "SELECT UserEmail FROM Users";
        $checkDatabaseResult = $db->query($checkduplicate);
        $find_matched = false;
        while ($row = $checkDatabaseResult->fetchArray()) {
            if ($row['UserEmail'] == $email) {
                $find_matched = true;
                break;
            }
        }
        return $find_matched;
    }

    public static function getUsers($db)
    {
        $getUsers = "SELECT * FROM Users";
        $getUsersResult = $db->query($getUsers);
        $users = [];
        while ($row = $getUsersResult->fetchArray()) {
            if ($row['UserRole']  == 'user') {
                $users[] = $row;
            }
        }
        return $users;
    }

    public static function updateUsers($db, $email, $approved)
    {
        if ($approved == 'true') {
            $approved = true;
        } else {
            $approved = false;
        }
        $update = "UPDATE Users SET Approved = '$approved' WHERE UserEmail = '$email'";
        echo $approved;
        $result = $db->exec($update);
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }
}
