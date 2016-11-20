<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 19.11.2016
 * Time: 16:20
 */
require_once 'settings.php';

if(isset($_POST['login']) && isset($_POST['password'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    if($login=="admin" && $password=="123"){
        echo "Здравствуйте администратор";
    }
    else{
        echo "Неверные данные";
    }
}

?>

</<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" name="send">
    </form>


</body>
</html>
