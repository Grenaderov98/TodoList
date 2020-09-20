<?php
$data = $_POST;
if (isset($data["lgnButton"])) {
    $errors = array();
    if (empty($data["Login"])) {
        $errors[] = "Окно Логин не должно быть пустым!";
    } else {
        $user = R::findOne('users', 'LOGIN = ?', array($data["Login"]));

        if ($user) {
            if (empty($data["Password"])) {
                $errors[] = "Пожалуйста введите пароль!";
            } else {
                $verify = hash("sha512", $data["Password"]);
                if ($verify == $user->password) {
                    $_SESSION["logged_user_id"] = $user->id;
                    header("Location: /");
                } else {
                    $errors[] = "Пароль указан неверное, пожалуйста попробуйте снова!";
                }
            }
        } else {
            $errors[] = "Пользователь с таким логином не найден!";
        }
    }
    if (!empty($errors)) {
        echo "<script>alert('$errors[0]');</script>";
    }
}
?>


<html>
<head>
    <meta charset="UTF-8">
    <title>Task manager</title>
    <link rel="stylesheet" href="css/style.css">
</head>


<div id="wrapper">
    <div class="img">
        <img src="img/logo.png" alt="">
    </div>
    <form id="signin" method="post">

        <input type="text" id="user" name="Login" placeholder="Логин"/>
        <input type="password" id="pass" name="Password" placeholder="Пароль"/>
        <button type="submit" name="lgnButton">&#xf0da;</button>
    </form>
</div>
</body>
</html>
