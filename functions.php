<?php

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
        string - $name

    Description: Показать флеш сообщение

    Return value: null
*/
function display_flash_message($name)
{
    echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
    unset($_SESSION[$name]);
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