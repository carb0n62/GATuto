<?php require 'includes/header.php'; ?>

<?php

if (!empty($_POST)){

    $errors = array();
    require_once 'includes/db.php';

    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        $errors['username'] = 'Votre pseudo est invalide';
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if ($user){
            $errors['username'] = 'Ce pseudo est déjà utilisé';
        }
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Votre adresse email est invalide';
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if ($user){
            $errors['email'] = 'Cette adresse email est déjà utilisée';
        }
    }

    if (empty($_POST['password'])){
        $errors['password'] = 'Veuillez entrer un mot de passe';
    }

    if (empty($_POST['confirm_password'])){
        $errors['confirm_password'] = 'Veuillez confirmer votre mot de passe';
    }

    if ($_POST['confirm_password'] != $_POST['password']){
        $errors['confirm_password'] = 'Les mots de passe ne correspondent pas';
    }

    if(empty($errors)){
        $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
        $user_id = $pdo->lastInsertId();
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, veuillez cliquer sur ce lien\n\nhttp://127.0.0.1/gatuto/confirm.php?id=$user_id&token=$token");
        header('Location: login.php');
        exit();
    }
    //debug($errors);
}

?>




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