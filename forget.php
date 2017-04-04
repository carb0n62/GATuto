<?php
if (!empty($_POST) || !empty($_POST['email'])){
    require_once 'includes/db.php';
    require_once 'includes/functions.php';
    session_start();
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if ($user){
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe, veuillez cliquer sur ce lien\n\nhttp://127.0.0.1/gatuto/reset.php?id={$user->id}&token=$reset_token");
        $_SESSION['flash']['success'] = 'Un mail vous a été envoyé pour réinitialiser votre mot de passe.';
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'L\'adresse email n\'existe pas.';
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