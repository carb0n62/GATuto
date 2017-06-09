<?php
require 'includes/bootstrap.php';
if (!empty($_POST) || !empty($_POST['email'])){
    $db = App::getDatabase();
    $auth = App::getAuth();
    $session = Session::getInstance();
    if ($auth->resetPassword($db, $_POST['email'])){
        $session->setFlash('success', 'Un mail vous a été envoyé pour réinitialiser votre mot de passe.');
        App::redirect('login.php');
    }else{
        $session->setFlash('danger', 'Aucun compte ne correspond à cette adresse');
    }
}
?>

<?php require 'includes/header.php'; ?>

    <h1>Mot de passe oublié</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

<?php require 'includes/footer.php'; ?>