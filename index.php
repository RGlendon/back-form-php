<?php
session_start();

if (isset($_POST["send"])) {
    $from = htmlspecialchars($_POST["from"]);
    $to = htmlspecialchars($_POST["to"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    $_SESSION["from"] = $from;
    $_SESSION["to"] = $to;
    $_SESSION["subject"] = $subject;
    $_SESSION["message"] = $message;

    $error_from = "";
    $error_to = "";
    $error_subject = "";
    $error_message = "";
    $error = false;

    if ($from == "" || !preg_match("/@/", $from)) {
        $error_from = "Введите корректный email";
        $error = true;
    }
    if ($to == "" || !preg_match("/@/", $to)) {
        $error_to = "Введите корректный email";
        $error = true;
    }
    if (strlen($subject) <= 5) {
        $error_subject = "Длина сообщения должна быть больше 5 символов";
        $error = true;
    }
    if (strlen($message) <= 5) {
        $error_message = "Длина сообщения должна быть больше 5 символов";
        $error = true;
    }

    if (!$error) {
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        $headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/plain; charset=utf-8\r\n";
        mail($to, $subject, $message, $headers);
        header("Location: success.php?send=1");
        exit;
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>from</title>
</head>
<body>
<form name="test" action="" method="POST">
    <label>От кого:</label><br/>
    <input type="text" name="from" value="<?= $_SESSION["from"] ?>" placeholder="Имя"/><br/>
    <span style="color:red"><?= $error_from ?></span><br/>
    <label>Кому:</label><br/>
    <input type="text" name="to" value="<?= $_SESSION["to"] ?>" placeholder="Email"/><br/>
    <span style="color:red"><?= $error_to ?></span><br/>
    <label>Тема сообщения:</label><br/>
    <input type="text" name="subject" value="<?= $_SESSION["subject"] ?>" placeholder="Email"/><br/>
    <span style="color:red"><?= $error_subject ?></span><br/>
    <label>Сообщение:</label><br/>
    <textarea type="text" name="message" placeholder="Имя" cols="40"
              rows="20"><?= $_SESSION["message"] ?></textarea><br/>
    <span style="color:red"><?= $error_message ?></span><br/>
    <input type="submit" name="send" value="Отправить">
</form>
</body>
</html>