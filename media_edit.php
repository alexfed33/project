<?php
session_start();
require "functions.php";

$image = $_FILES['avatar']['name'];
$tmp_name = $_FILES['avatar']['tmp_name'];
$user_id = $_POST['id'];

upload_avatar($image, $tmp_name, $user_id);
set_flash_message('success', 'Профиль успешно обновлен!');
redirect_to("page_profile.php?id=$user_id");
