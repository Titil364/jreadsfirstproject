<!DOCTYPE html>
<html>
    <head>
	
        <meta charset="UTF-8">
		<link rel="icon" href="media/favicon.png"/>
        <title><?php echo $pagetitle ?></title>
        <link rel="stylesheet" href="css/styles.css">
		<?php 
			if(isset($stylesheet)){
				echo "<link rel=\"stylesheet\" href=\"css/$stylesheet.css\">";
			}
		?>
    </head>
    <body>
		<header>
			<?php
				if(Session::is_connected()){
					echo <<< EOT
						<a class='menu-logo' href="index.php">
							<img class='menu-logo-img' src='media/logo.png' alt='logo'>
							<div class='menu-logo-content'>
								Chici
							</div>
						</a>
						<div class='menu-buttons'>
							<div class="menu-item">   
									<a href='index.php?action=create&controller=form'>
										<button type="button">Create a new form</button>
									</a>
							</div>
							<div class="menu-item">
								<a href='index.php?action=displaySelf&controller=users'>
									<button type="button" id="goToProfile">Profile</button>
								</a>
							</div>
EOT;
									if (Session::is_admin()) {
										echo "<div class=\"menu-item\">";
										echo "<a href='index.php'>";
										echo "<button type=\"button\">See u soon</button></a>";
										echo "</div>";
									}
					echo <<< EOT
							<div class="menu-item">
								<a href='index.php?action=disconnect&controller=users'>
									<button type="button">Log out</button>
								</a>
							</div>
						</div>
EOT;
				} 
			?>
		</header> 
		<!--<script src ="script/jquery.min.js"></script>-->
		<script src ="script/jquery.js"></script>
        <script src="script/jquery-ui.min.js"></script>
		<script src="script/jquery1.10.2.min.js"></script>
		
		
       <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src ="script/object.js"></script>
		<?php 
			if(isset($jscript)){
				echo "<script src=\"script/$jscript.js\"></script>";
			}
		?>
                <?php
                $filepath = File::build_path(array('view', $controller, $view . ".php"));
                require $filepath;
                ?>
		<!-- <footer>
            <div> I am a footer NOTICE ME PLEASE </div>
        </footer> -->


    </body>
</html>