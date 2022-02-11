<?php

session_start();
require "functions.php";

$name = $_POST['name'];
$jobs = $_POST['jobs'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$user_id = $_SESSION['user_id'];

edit_information($name, $jobs, $phone, $address, $user_id);
set_flash_message('success', 'Профиль успешно обновлен!');
redirect_to('users.php');