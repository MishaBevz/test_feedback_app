<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 18.11.2016
 * Time: 12:50
 */
require_once 'settings.php';

// если значения переменных $key и $key2 не определены - присваиваем им значения по умолчанию.
if(!isset($key)){
    $key = "date";
}
if(!isset($key2)){
    $key2 = "DESC";
}

// Если GET запрос передает определенное значение - присваиваем переменным $key и $key2 нужные нам значения.
if(isset($_GET['date'])){
    $key = "date";
    $key2 = "ASC";
    echo "Сортировка по дате(сначала старые)";
}

if (isset($_GET['name'])){
    $key = "name";
    $key2 = "ASC";
    echo "Сортировка по имени в алфавитном порядке";
}

if (isset( $_GET['email'])){
    $key = "email";
    $key2 = "ASC";
    echo "Сортировка по email в алфавитном порядке";
}

$query = "SELECT * FROM feedback ORDER BY $key $key2 "; // Выбираем нужные нам данные.Переменная $key отвечает за выбор поля таблицы,а переменная $key2 - в каком направлении данные будут сортироваться.
$result = mysqli_query($link,$query)
            or die ("Ошибка" . mysqli_error($link));



if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){ //Проверяем,отличные ли от Null пришли данные.
    // Фильтруем данные (о функции 'clean' подробности в файле settings.php)
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);
    $message = clean($_POST['message']);
    $date = date("Y-m-d H:i:s");

    // Далее делаем проверку на наличие загруженных файлов.
    // Проверяем тип файлов.
    if($_FILES['picture']['type'] == "image/gif" || $_FILES['picture']['type'] == "image/jpeg" || $_FILES['picture']['type'] == "image/png"){

        $uploaddir = 'view/img/'; // Путь загрузки файлов

        $uploadfile = $uploaddir . time(); // Имя файла
        $uploadfile = $uploaddir . md5($uploadfile) . rand(999,100000) . "." . basename($_FILES['picture']['type']); // Шифруем имя файла, дабы избежать одинаковых имен файлов в будущем.


        if(move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)){
            echo "Файл корректен и был успешно загружен";
        } else {
            echo "Файл некорректен для загрузки";
        }

        $image = $uploadfile;
    }



    // Проверка данных на валидность(о функции 'check_length' подробности в файле settings.php) :
    if(check_length($name, 2, 25) && check_length($message, 10, 1000) && $email_validate) {
        // Если все хорошо,добавляем данные в таблицу:
        $query_feedbackForm = "INSERT INTO feedback VALUES ('','$name','$email_validate','$image','$message','$date')";
        mysqli_query($link,$query_feedbackForm)
            or die ("Ошибка" . mysqli_error($link));
        // И отправляем сообщение на электронную почту:
        $to = "";
        $subject = "Отзыв от:" . " " . $name . " " . "<$email_validate>";
        $mail_message = $message;

        mail($to, $subject, $message);





        header('Location: /');
        exit;
    }

    else {
        echo "Введенные данные некорректные";
    }

}




?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Отзывы</title>
</head>
<body>
<h1><a href="register_form.php">Регистрация</a></h1>
<h1><a href="login_form.php">Войти</a></h1><br>

<ul>
    <h1>Отзывы:<br></h1>
    <li><a href="/">Сортировать по дате(сначала новые,стоит по умолчанию)</a></li>
    <li><a href="index.php?date=sort">Сортировать по дате(сначала старые)</a></li>
    <li><a href="index.php?name=sort">Сортировать по имени (в алфавитном порядке)</a></li>
    <li><a href="index.php?email=sort">Сортировать по email (в алфавитном порядке)</a></li>
</ul>

<?php while($row = mysqli_fetch_array($result)): //Вывод отзывов на страничку ?>
<br><hr>
<h3><?php echo $row['name']?></h3>
<h4><?php echo $row['email']?></h4>
<p><img src="<?php echo $row['image']?>"></p>
<p><?php echo $row['message']?></p>
<p><?php echo $row['date']?></p>
<?php endwhile; ?>
<br>
<br>
<hr>
Форма обратной связи:<br>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Имя" required><br><br>
    <input type="email" name="email" placeholder="Ваш email" required><br><br>
    <input type="file" name="picture"><br><br>
    <textarea name="message" placeholder="Введите сообщение"></textarea><br><br>
    <input type="submit" name="send">
</form>

</body>
</html>
