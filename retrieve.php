<?php
include_once('connection.php');

session_start();

$cursor = $users->find();

include_once 'retrieve.html';
session_reset();

?>