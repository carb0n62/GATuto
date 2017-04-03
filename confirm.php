<?php
$user_id = $_GET['id'];
$token = $_GET['token'];
require 'includes/db.php';

$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

if ($user && $user->confirmation_token == $token){ //$user->token is the same as $user['token']
    $req = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ? ')->execute([$user_id]);
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = 'Votre compte a bien été validé.';
    header('Location: account.php');
} else {
    $_SESSION['flash']['danger'] = "Ce compte a déjà été validé";
    header('Location: login.php');
}