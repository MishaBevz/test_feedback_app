<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 19.11.2016
 * Time: 16:36
 */
require_once 'settings.php';





if(isset($_POST['register_name']) && isset($_POST['register_password'])){
    $register_name = clean($_POST['register_name']);
    $register_password = clean($_POST['register_password']);

    $check_register = mysqli_query($link,"SELECT * FROM users WHERE login='$register_name'");
    if(mysqli_num_rows($check_register) > 0 ){

        echo "Пользователь" . " " . $register_name . " " .  "уже существует";

    }

    else{
        if($register_name=="admin" && $register_password=="123"){
            $query="INSERT INTO users VALUES ('','$register_name','$register_password')";
            $result=mysqli_query($link,$query);
            echo "Регистрация прошла успешно!" . " " . "<a href='login_form.php'>Войти</a>";

        }

        else {
            echo "Данные введены неккоректно.Попробуйте снова";
        }

    }


}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<form method="post">
    <input type="text" name="register_name" placeholder="Логин" required>
    <input type="password" name="register_password" placeholder="Пароль" required>
    <input type="submit" name="send">
</form>

</body>
</html>
