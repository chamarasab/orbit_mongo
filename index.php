<?php
session_start();
//$connection = mysqli_connect("localhost", "root", "", "orbit");

include_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$client) {
        $_SESSION["message"] = "connection_failed";
    } else {
        if (!empty($_POST["name"]) and !empty($_POST["phone"])) {
            $post_data = array();
            #AutoIncrement ID
            #db.users.find({},{id:1}).sort( { _id : -1 } ).limit(1);
            $id = 0;

            $lastuser = $users->find(
                [

                ],
                [
                    '_id' => -1
                ],
                [
                    'id' => 1,
                    'limit' => 1,

                ]
            );
            foreach ($lastuser as $key) {
                $id = $key["id"];
            }
            $id = $id + 1;
            $post_data["id"] = "$id";
            $post_data["name"] = $_POST["name"];
            $post_data["phone"] = $_POST["phone"];
            //$insert_query = "INSERT INTO users (name, phone) VALUES ('" . $name . "','" . $phone . "'); ";

            $result = $users->insertOne($post_data); //mysqli_query($connection, $insert_query);

            if ($result) {
                $_SESSION["message"] = "insert_success";
                sleep(2);
                //session_reset();
                header('location:retrieve.php');
            } else {
                $_SESSION["message"] = "insert_error";
            }

            $_POST = array();
            $post_data = array();

        } else {
            $_SESSION["message"] = "empty_inputs";
        }
    }
} else {
    #GET
    $_SESSION["message"] = "welcome";

    /**
     * find user
     */
    $user_id = null;
    $user_name = "";
    $user_contact = "";

    if (isset($_GET["id"])) {
        $user_id = $_GET["id"];
        //$select_query = "SELECT * from users WHERE id = '".$user_id."'";
        $result = $users->find(["id" => $user_id]); //mysqli_query($connection, $select_query);
        if ($result) {
            $_SESSION["message"] = "user_found_success";

            foreach ($result as $user) {
                $user_id = $user['id'];
                $user_name = $user['name'];
                $user_contact = $user['phone'];
            }
        } else {
            $_SESSION["message"] = "user_found_failed";
        }
    }

}
include_once 'insert.html';