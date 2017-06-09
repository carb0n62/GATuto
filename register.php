<?php

require_once 'includes/functions.php';
require_once 'includes/bootstrap.php';



if (!empty($_POST)){

    $errors = array();
    $db = App::getDatabase();
    $validator = new Validator($_POST);
    $validator->isAlpha('username', "Votre pseudo n'est pas valide (alphanumérique)");
    if($validator->isValid()){
        $validator->isUniq('username', $db, 'users', 'Ce pseudo est déjà pris');
    }
    $validator->isEmail('email', "Votre email n'est pas valide");
    if($validator->isValid()){
        $validator->isUniq('email', $db, 'users', 'Cet email est déjà utilisé pour un autre compte');
    }
    $validator->isConfirmed('password', 'Vous devez rentrer un mot de passe valide');

    if($validator->isValid()){

        App::getAuth()->register($db, $_POST['username'], $_POST['password'], $_POST['email']);
        Session::getInstance()->setFlash('success', 'Votre compte a bien été créé, un email de confirmation vous a été envoyé.');
        App::redirect('login.php');
    }else{
        $errors = $validator->getErrors();
    }
    //debug($errors);
}

?>

<?php require 'includes/header.php'; ?>


<h1>S'inscrire</h1>

<?php if (!empty($errors)): ?>

    <div class="alert alert-danger">
        <p>Le formulaire n'est pas rempli correctement: </p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="">Pseudo</label>
            <input type="text" name="username" class="form-control" />
        </div>

        <div class="form-group">
            <label for="">Email</label>
            <input type="text" name="email" class="form-control" />
        </div>

        <div class="form-group">
            <label for="">Mot de passe</label>
            <input type="password" name="password" class="form-control" />
        </div>

        <div class="form-group">
            <label for="">Confirmez votre mot de passe</label>
            <input type="password" name="confirm_password" class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary">Inscription</button>
    </form>

<?php require 'includes/footer.php'; ?>