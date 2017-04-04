<?php
require_once 'includes/functions.php';
reconnect_from_cookie();
if (isset($_SESSION['auth'])){
    header('Location: account.php');
    exit();
}
if (!empty($_POST) || !empty($_POST['username']) && !empty($_POST['password'])){
    require_once 'includes/db.php';
    require_once 'includes/functions.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    if (($user = $req->fetch(PDO::FETCH_OBJ)) && password_verify($_POST['password'], $user->password)){
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté.';
        if ($_POST['remember']){
            $remember_token = str_random(250);
            $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
            setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'heisenberg'), time() + 60 * 60 * 24 * 7);
        }
        header('Location: account.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect';
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
