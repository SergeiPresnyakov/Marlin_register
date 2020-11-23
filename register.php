<?php
session_start();

$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];
$connection = new PDO("mysql:host=localhost; dbname=profiles; charset=utf8", "root", "");

/*
    Parameters:
        PDO - $pdo
        string - $email
        string = $password

    Description: Добавить пользователя в БД

    Return value: null
*/
function add_user($pdo, $email, $password)
{
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute(["email" => $email, "password" => $password]);
}

/*
    Parameters:
        PDO - $pdo
        string - $email

    Description: Получить id пользователя по email

    Return value: int (user_id)
*/
function get_user_id_by_email($pdo, $email)
{
    $sql = "SELECT id FROM users WHERE email = :email";
    $statement = $pdo->prepare($sql);
    $statement->execute(["email" => $email]);
    $user_id = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $user_id;
}

/*
    Parameters:
        string - $name
        string = $message

    Description: Подготовить флеш сообщение

    Return value: null
*/
function set_flash_message($name, $message)
{
    $_SESSION[$name] = $message;
}

/*
    Parameters:
        string - $path

    Description: Перенаправляет на страницу по адресу $path

    Return value: null
*/
function redirect_to($path)
{
    header("Location: {$path}");
    exit;
}

/* 
Если пользователь с таким email уже есть в базе,
не вносить его в базу и вывести флеш сообщение
 */
if (!empty(get_user_id_by_email($connection, $user_email))) {
    set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
    redirect_to("/tasks2/page_register.php");

/*
Если такого email ещё нет в базе,
регистрируем нового пользователя 
*/
} else {
    add_user($connection, $user_email, $user_password);
    set_flash_message("success", "Регистрация успешна");
    redirect_to("/tasks2/page_login.php");
}
