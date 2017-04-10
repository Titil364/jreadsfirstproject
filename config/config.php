<?php
class Conf {
    static private $debug = true;
	
    static private $databases = array(
        // Le nom d'hote est infolimon a l'IUT
        // ou localhost sur votre machine
        'hostname' => 'localhost',
        // A l'IUT, vous avez une BDD nommee comme votre login
        // Sur votre machine, vous devrez creer une BDD
        'database_name' => 'ChiCI',
        // A l'IUT, c'est votre login
        // Sur votre machine, vous avez surement un compte 'root'
        'login' => 'root',
        // A l'IUT, c'est votre mdp (INE par defaut)
        // Sur votre machine personelle, vous avez creez ce mdp a l'installation
        'password' => ''
    );
    static public function getDebug() {
        return self::$debug;
    }
    static public function getLogin() {
        //en PHP l'indice d'un tableau n'est pas forcement un chiffre.
        return self::$databases['login'];
    }
    static public function getHostName() {
        return self::$databases['hostname'];
    }
    static public function getDatabaseName() {
        return self::$databases['database_name'];
    }
    static public function getPassword() {
        return self::$databases['password'];
    }
}
?>