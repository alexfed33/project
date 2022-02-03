<?php

function get_user_by_email($email) {
    $pdo = new PDO('mysql:host=localhost;dbname=project', 'root', '');

    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}


function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
}

function redirect_to($path) {
    header("Location: $path");
}

function add_user($email, $password) {
    $pdo = new PDO('mysql:host=localhost;dbname=project', 'root', '');

    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT)
    ]);
}

function display_flash_message($name) {
    if(isset($_SESSION[$name])) {
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]} </div>";
        unset($_SESSION[$name]);
    }

}