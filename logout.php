<?php
session_start();
setcookie('remember', NULL, -1);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous vous êtes déconnecté(e)';
header('Location: login.php');