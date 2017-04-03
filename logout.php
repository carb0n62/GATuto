<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous vous êtes déconnecté(e)';
header('Location: login.php');