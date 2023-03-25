<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {}
else {
    include_once('connection.php');

    $id = $_GET["id"];

    if (!$client) {
        $_SESSION["message"] = "connection_failed";
    } else {
        if (!empty($_GET["id"])) {
            $id = $_GET["id"];

            //$delete_query = "DELETE FROM users  where id = '".$id."'";
            $result = $users->deleteOne(["id"=>$id]);

            if ($result) {
                $_SESSION["message"] = "delete_success";
                sleep(2);
                header('location:retrieve.php');
                //session_reset();
            } else {
                $_SESSION["message"] = "insert_error";
            }
        } else {
            $_SESSION["message"] = "empty_inputs";
        }
    }

    //header('location:retrieve.php');
}