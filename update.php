<?php
session_start();
include_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$client) {
        $_SESSION["message"] = "connection_failed";
    } else {
        if (!empty($_POST["name"]) and !empty($_POST["phone"]) and !empty($_POST["user_id"])) {
            $id = $_POST["user_id"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];

            //$insert_query = "UPDATE users SET name='" . $name . "', phone='" . $phone . "' WHERE id='".$id."' ";
            $result = $users->updateMany(["id" => $id], [['$set' => ["name" => $name]], ['$set' => ["phone" => $phone]]]); //mysqli_query($connection, $insert_query);

            if ($result) {
                $_SESSION["message"] = "update_success";
                sleep(1);
                //session_reset();
                header('location:retrieve.php');
            } else {
                $_SESSION["message"] = "insert_error";
            }
        } else {
            $_SESSION["message"] = "empty_inputs";
        }
    }
} else {
    #GET
    $_SESSION["message"] = "empty_inputs";
    header("location:index.php");
}
include_once 'insert.html';