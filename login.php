<?php
require 'includes/bootstrap.php';
$auth = App::getAuth();
$db = App::getDatabase();
$auth->connectFromCookie($db);
if ($auth->user()){
    App::redirect('account.php');
}
if (!empty($_POST) || !empty($_POST['username']) && !empty($_POST['password'])){
    $user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
    $session = Session::getInstance();
    if ($user){
        $session->setFlash('success', 'Vous êtes maintenant connecté.');
        App::redirect('account.php');
    }else{
        $session->setFlash('danger', 'Identifiant ou mot de passe incorrect');
    }
}
?>
<?php require 'includes/header.php'; ?>

<h1>Se connecter</h1>

<form action="" method="post">
    <div class="form-group">
        <label for="">Pseudo ou email</label>
        <input type="text" name="username" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Mot de passe <a href="forget.php">(Mot de passe oublié)</a></label>
        <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="remember" value="1" /> Rester connecté
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Connexion</button>
</form>

<?php require 'includes/footer.php'; ?>
