<?php
    require_once('vendor/autoload.php');

    $client = new MongoDB\Client("mongodb://localhost:27017");

    $db = $client->orbit;

    $users = $db->users;

?>