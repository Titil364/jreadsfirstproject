<!DOCTYPE html>
<html>
    <head>
	
        <meta charset="UTF-8">
		<link rel="icon" href="media/favicon.png"/>
        <title><?php echo $pagetitle ?></title>
        <link rel="stylesheet" href="css/styles.css">
		
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
								<a href='index.php?controller=users&action=displaySelf'>Compte</a>                    
							</div>


							<div class="menu-item">   
									<a href='index.php?action=update&controller=users'>Paramètres</a>
							</div>
EOT;
									if (Session::is_admin()) {
										echo "<div class=\"menu-item\">";
										echo "<a href='index.php'>See u soon</a>";
										echo "</div>";
									}
					echo <<< EOT
							<div class="menu-item">
								<a href='index.php?action=disconnect&controller=users'>Se déconnecter</a>
							</div>
						</div>
EOT;
				}
			?>
			<div id="signIn">
					<button type="button" id="goToSignIn">Sign In</button>
					<button type="button" id="goToProfile">Profile</button>
			</div>
		</header> 
		<script src ="script/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
		<script src ="script/object.js"></script>

                <?php
                $filepath = File::build_path(array('view', $controller, $view . ".php"));
                require $filepath;
                ?>

		
		<!--<script src ="script/jquery.min.js"></script>-->
    </body>
</html>