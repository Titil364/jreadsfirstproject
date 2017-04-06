<!DOCTYPE html>
<html>
    <head>
	
        <meta charset="UTF-8">
		<link rel="icon" href="media/favicon.png"/>
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
		
		<script src ="script/myscript.js"></script>
    </body>
</html>