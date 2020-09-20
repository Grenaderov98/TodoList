<?php
session_start();
require "Connection.php";

if (empty($_SESSION["logged_user_id"])) {
    require "Login.php";
    exit;
}

$uri = $_SERVER['REQUEST_URI'];
$pages = ["/", "/myTasks", "/TeamTasks"];
if (in_array($uri, $pages)) {
    $team = R::find('users', 'leader_id = ?', array($_SESSION["logged_user_id"]));
    $priority = R::find('priority');
    $status = R::find('status');
    include "Menu.php";
}

switch ($uri) {
    case "/logout":
        require "Logout.php";
        break;
    case "/test":
        echo('test');
        break;
    case "/tasksAjax":
        require('tasksAjax.php');
        break;
    case "/TeamTasks":
        if (!empty($team)) {
            require "TeamTasks.php";
        } else {
            require "myTasks.php";
        }
        break;
    case "/myTasks":
    default:
        require "myTasks.php";
        break;
}
