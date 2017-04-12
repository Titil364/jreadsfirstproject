<?php


    
    require_once File::build_path(array('model', 'ModelUsers.php'));   

    var_dump(ModelUsers::checkExistingUser($_POST['userNickname']));
    
    
?>