<?php
session_start();
require "functions.php";

$id = $_GET['id'];

check_auth();
is_author($_SESSION['id'], $id);

delete_user($id);

if ($_SESSION['id'] == $id) {

    unset($_SESSION['auth'],$_SESSION['role'],
          $_SESSION['id'], $_SESSION['user'],
          $_SESSION['email']); session_destroy();

    redirect_to("page_register.php"); exit();
}

set_flash_message('success', 'Пользователь удален!');
redirect_to("users.php");

