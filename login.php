<?php
session_start();
require "functions.php";

$email = $_POST['email'];
$password = $_POST['password'];

login($email,$password);

