<?php
class Session{
    
    public static function is_user($login){
        return (!empty($_SESSION['nickName'] && $_SESSION['nickName']==$login));
    }
    
    public static function is_admin() {
        return (!empty($_SESSION['admin']) && $_SESSION['admin']==1);
    }
    public static function connect($nickname, $surname, $forename, $mail) {
        $_SESSION['connected'] = true;
        $_SESSION['nickname'] = $nickname;
        $_SESSION['surname'] = $surname;
        $_SESSION['forename']  = $forename;
        $_SESSION['mail'] = $mail;
    }
    
    public static function is_connected() {
        return (!empty($_SESSION['connected']) && $_SESSION['connected']);
    }    
}
?>