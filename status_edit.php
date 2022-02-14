<?php
session_start();
require "functions.php";

$set_status = $_POST['set_status'];
$user_id = $_POST['id'];

set_status($set_status,$user_id);
set_flash_message('success', 'Профиль успешно обновлен!');
redirect_to("page_profile.php?id=$user_id");