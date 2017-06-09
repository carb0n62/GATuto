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

    public function user(){
        if (!$this->session->read('auth')){
            return false;
        }
        return $this->session->read('auth');
    }

    public function connect($user){
        $this->session->write('auth', $user);
    }

    public function connectFromCookie($db){
        if (isset($_COOKIE['remember']) && !$this->user()){
            $remember_token = $_COOKIE['remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $user = $db->query('SELECT * FROM users WHERE id = ?', [$user_id])->fetch();
            if ($user){
                $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'heisenberg');
                if ($expected == $remember_token){
                    $this->connect($user);
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 *7);
                }
            } else {
                setcookie('remember', NULL, -1);
            }
        }
    }

    public function login($db, $username, $password, $remember = false){
        $user = $db->query('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL', ['username' => $username])->fetch();
        if (password_verify($password, $user->password)){
            $this->connect($user);
            if ($remember){
                $this->remember($db, $user->id);
            }
            return $user;
        }else{
            return false;
        }
    }

    public function remember($db, $user_id){
        $remember_token = Str::random(250);
        $db->query('UPDATE users SET remember_token = ? WHERE id = ?', [$remember_token, $user_id]);
        setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id . 'heisenberg'), time() + 60 * 60 * 24 * 7);
    }

}