<?php
require 'includes/bootstrap.php';
$db = App::getDatabase();


if (App::getAuth()->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance())){ //$user->token is the same as $user['token']
    Session::getInstance()->setFlash('success', "Votre compte a bien été validé.");
    App::redirect('account.php');
} else {
    Session::getInstance()->setFlash('danger', "Ce compte a déjà été validé");
    App::redirect('login.php');
}