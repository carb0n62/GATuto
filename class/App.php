<?php
class App{

    static $db = null;

    static function getDatabase(){
        if (!self::$db){
            self::$db = new Database('gatuto', 'gatuto', 'gatuto');
        }
        return self::$db;
    }

    static function getAuth(){
        return new Auth(Session::getInstance(), ['restriction_msg' => 'You need to be logged in to access this page.']);
    }

    static function redirect($page){
        header("Location: $page");
        exit();
    }
}