<?php
require 'includes/bootstrap.php';
App::getAuth()->restrict();

if (!empty($_POST)){
    if (empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']){
        $_SESSION['flash']['danger'] = 'Les mots de passe ne correspondent pas.';
    } else {
        $user_id = $_SESSION['auth']->id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'includes/db.php';
        $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = 'Votre mot de passe a été modifié avec succès !';
    }
}

require 'includes/header.php';
?>

<h1>Bienvenue, <?= $_SESSION['auth']->username; ?></h1>
<h3>Modifier vos informations</h3><br />
<h4>Modifier votre mot de passe</h4>
<form action="" method="post">
    <div class="form-group">
        <input class="form-control" type="password" name="password" placeholder="Nouveau mot de passe"/>
    </div>

    <div class="form-group">
        <input class="form-control" type="password" name="confirm_password" placeholder="Confirmer nouveau mot de passe"/>
    </div>

    <button class="btn btn-primary">Modifier</button>
</form>

<?php require 'includes/footer.php'; ?>
