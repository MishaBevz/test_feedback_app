<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 22.11.2016
 * Time: 14:41
 */

// Далее делаем проверку на наличие загруженных файлов.
// Проверяем тип файлов.
if($_FILES['picture']['type'] == "image/gif" || $_FILES['picture']['type'] == "image/jpeg" || $_FILES['picture']['type'] == "image/png"){

    // Путь загрузки файлов:
    $uploaddir = 'View/img/';

    // Имя файла:
    $uploadfile = $uploaddir . time();

    // Шифруем имя файла, дабы избежать одинаковых имен файлов в будущем:
    $uploadfile = $uploaddir . md5($uploadfile) . rand(999,100000) . "." . basename($_FILES['picture']['type']);

    if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) {
        echo "Файл корректен и был успешно загружен.\n";
    } else {
        echo "Возможная атака с помощью файловой загрузки!\n";
    }

    $image = $uploadfile ;

}