<?php
require 'includes/bootstrap.php';
App::getAuth()->logout();
Session::getInstance()->setFlash('success', 'Vous vous êtes déconnecté(e)');
App::redirect('login.php');