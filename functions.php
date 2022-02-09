<?php

//Соединение с базой данных
function config()
{
    $host = 'localhost';
    $db   = 'project';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    return $pdo = new PDO($dsn, $user, $pass, $opt);
};


function get_user_by_email($email) {
    $pdo = config();

    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
}

function redirect_to($path) {
    header("Location: $path");
}

function add_user($email, $password) {
    $pdo = config();

    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT)
    ]);

    return $pdo->lastInsertId();

}

function display_flash_message($name) {
    if(isset($_SESSION[$name])) {
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]} </div>";
        unset($_SESSION[$name]);
    }
}

function login($email, $password) {
    $pdo = config();

    $result = $pdo->query('SELECT * FROM users');

    foreach ($result as $users) {
        if ($email == $users['email'] and password_verify($password, $users['password'])) {

            $_SESSION['auth'] = true;
            $_SESSION['role'] = $users['role'];
            $_SESSION['id'] = $users['id'];
            $_SESSION['user'] = $users['email'];

            redirect_to("users.php");
            exit;
            }
        };

        if (empty($user)) {
            set_flash_message("danger", "Такого пользователя не существует");
            redirect_to("page_login.php");
            exit;
        }
}

function check_auth() {
    if($_SESSION['auth'] == false) {
        redirect_to("page_login.php");
    }
}

function check_admin() {
    if($_SESSION['role'] != 'admin') {
        redirect_to("page_login.php");
    }
}

function query_to_users() {
    $pdo = config();
    return $pdo->query('SELECT * FROM users');
}


function edit_information($name, $jobs, $phone, $address, $user_id) {
    $pdo = config();

    $sql = "UPDATE users SET name=:name, jobs=:jobs, phone=:$phone, address=:address WHERE id=:id";
    $pdo->prepare($sql)->execute([$name, $jobs, $phone, $address, $user_id]);
}


function set_status($status, $user_id) {
    $pdo = config();

    $sql = "UPDATE users SET status=:status WHERE id=:id";
    $pdo->prepare($sql)->execute([$status, $user_id]);
}


function upload_avatar($filename, $tmp_name, $user_id) {
    $pdo = config();

    if(!empty($filename)) {
        $result = pathinfo($filename);
        $filename = uniqid() . "." .$result['extension'];

        $sql = "UPDATE users SET avatar=:avatar WHERE id=:id";
        $pdo->prepare($sql)->execute([$filename, $user_id]);

        move_uploaded_file($tmp_name, 'img/avatars/' . $filename);
    }
}

function set_social_links($vk, $telegram, $instagram, $user_id) {
    $pdo = config();

    $sql = "UPDATE users SET vk=:vk, telegram=:telegram, instagram=:instagram WHERE id=:id";
    $pdo->prepare($sql)->execute([$vk, $telegram, $instagram, $user_id]);
}

function logout() {
    unset($_SESSION['auth']);
    session_destroy();
    redirect_to("page_login.php");
}


