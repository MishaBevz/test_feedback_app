<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 22.11.2016
 * Time: 14:46
 */

$to = "";
$subject = "Отзыв от:" . " " . $name . " " . "<$email_validate>";
$mail_message = $message;
mail($to, $subject, $message);
header('Location: /');
exit;