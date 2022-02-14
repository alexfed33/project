<?php
session_start();
require "functions.php";

$email = $_POST['email'];
$password = $_POST['password'];
$user_id = $_POST['id'];


if ($_SESSION['email'] == $email) {
    edit_credentials($email, $password, $user_id);
} else {
        $user = get_user_by_email($email);
        if (!empty($user)) {
            set_flash_message('danger', 'Такой email уже занят');
            redirect_to("security.php?id=$user_id");
            exit();
        }
        edit_credentials($email, $password, $user_id);
}











