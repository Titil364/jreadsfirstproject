<!DOCTYPE html>
<html>
    <head>
	
        <meta charset="UTF-8">
        <title><?php echo $pagetitle ?></title>
        <link rel="stylesheet" href="css/styles.css">
		
    </head>
    <body>

                <?php
                $filepath = File::build_path(array('view', $controller, $view . ".php"));
                require $filepath;
                ?>
        <footer>
            
        </footer>
		<script src ="script/jquery.js"></script>
		<script src ="script/object.js"></script>
		<script src ="script/myscript.js"></script>
		
		<!--<script src ="script/jquery.min.js"></script>-->
    </body>
</html>