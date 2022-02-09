<?php
session_start();
require "functions.php";


$email = $_POST['email'];
$password = $_POST['password'];

$name = $_POST['name'];
$jobs = $_POST['jobs'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$status = $_POST['status'];

$image = $_FILES['avatar']['name'];
$tmp_name = $_FILES['avatar']['tmp_name'];

$vk = $_POST['vk'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];

$user = get_user_by_email($email);

if (!empty($user)) {
    set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем!");
    redirect_to("create_user.php");
    exit;
}

$user_id = add_user($email, $password);

edit_information($name, $jobs, $phone, $address, $user_id);
set_status($status, $user_id);
upload_avatar($image, $tmp_name, $user_id);
set_social_links($vk, $telegram, $instagram, $user_id);

set_flash_message("success", "Пользователь успешно добавлен!");
redirect_to("users.php");
exit;

