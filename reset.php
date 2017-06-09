<?php
require 'includes/bootstrap.php';
if (isset($_GET['id']) && isset($_GET['token'])){
    $auth = App::getAuth();
    $db = App::getDatabase();
    $user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);
    if ($user){
        if (!empty($_POST)){
            $validator = new Validator($_POST);
            $validator->isConfirmed('password');
            if ($validator->isValid()){
                $password = $auth->hashPassword($_POST['password']);
                $db->query('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?', [$password, $_GET['id']]);
                //$auth->connect($user);
                Session::getInstance()->setFlash('success', "Votre mot de passe a été modifié avec succès !");
                App::redirect('login.php');
            }
        }
    } else {
        Session::getInstance()->setFlash('danger', "Ce lien n'est pas/plus valide.");
        App::redirect('login.php');
    }
}else{
    App::redirect('login.php');
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
