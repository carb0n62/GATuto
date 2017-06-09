<?php

class Auth
{
    private $options = [
        'restriction_msg' => "Aïe ! Vous devez être connecté pour accéder à cette page !"
    ];
    private $session;

    public function __construct($session, $options = []){
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
    }

    public function register($db, $username, $password, $email){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(60);
        $db->query("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?", [
            $username,
            $password,
            $email,
            $token]);
        $user_id = $db->lastInsertId();
        mail($email, 'Confirmation de votre compte', "Afin de valider votre compte, veuillez cliquer sur ce lien\n\nhttp://127.0.0.1/gatuto/confirm.php?id=$user_id&token=$token");
    }

    public function confirm($db, $user_id, $token){

        $user = $db->query('SELECT * FROM users WHERE id = ?', [$user_id])->fetch();

        if ($user && $user->confirmation_token == $token){ //$user->token is the same as $user['token']
            $db->query('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ? ', [$user_id]);
            $this->session->write('auth', $user);
            return true;
        }
        return false;
    }

    public function restrict(){
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            header('Location: login.php');
            exit();
        }
    }

}