<?php
class App{

    static $db = null;

    static function getDatabase(){
        if (!self::$db){
            self::$db = new Database('gatuto', 'gatuto', 'gatuto');
        }
        return self::$db;
    }
}