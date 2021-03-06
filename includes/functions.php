<?php

function debug($variable){
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function check_login(){
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = 'Aïe ! Vous devez être connecté pour accéder à cette page !';
        header('Location: login.php');
        exit();
    }
}

function reconnect_from_cookie(){
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        require_once 'db.php';
        if (!isset($pdo)){
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
        $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        if ($user){
            $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'heisenberg');
            if ($expected == $remember_token){
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() + 60 * 60 * 24 *7);
            }
        } else {
            setcookie('remember', NULL, -1);
        }
    }
}