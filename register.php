<?php
session_start();
require("functions.php");

$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];
$connection = new PDO("mysql:host=localhost; dbname=profiles; charset=utf8", "root", "");


/* 
Если пользователь с таким email уже есть в базе,
не вносить его в базу и вывести флеш сообщение
 */
if (!empty(get_user_id_by_email($connection, $user_email))) {
    set_flash_message("danger", "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
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
