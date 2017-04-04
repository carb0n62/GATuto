<?php
if (isset($_GET['id']) && isset($_GET['token'])){
    require 'includes/db.php';
    require 'includes/functions.php';
    session_start();
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE )');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();

    if ($user){
        if (!empty($_POST)){
            if (!empty($_POST['password']) && $_POST['password'] == $_POST['confirm_password']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                $_SESSION['flash']['success'] = "Votre mot de passe a été modifié avec succès !";
                header('Location: login.php');
                exit();
            }
        }
    } else {
        $_SESSION['flash']['danger'] = "Ce lien n'est pas/plus valide.";
        header('Location: login.php');
        exit();
    }
}
?>
<?php require 'includes/header.php'; ?>

<h1>Réinitialisation du mot de passe</h1>

<form action="" method="post">
    <div class="form-group">
        <label for="">Nouveau mot de passe</label>
        <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Confirmer nouveau mot de passe</label>
        <input type="password" name="confirm_password" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<?php require 'includes/footer.php'; ?>
