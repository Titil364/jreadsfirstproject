<div class="formCss">
		<fieldset>
				<legend>Your information</legend>
		
			<p>
				Nickname : <?php echo $data["nickname"]?>
			</p>
			<p>
				Forename : <?php echo $data["forename"]?>
			</p>
			<p>
				Surname : <?php echo $data["surname"]?>
			</p>
			<p>
				Mail : <?php echo $data["mail"]?>
			</p>
		
		</fieldset>
<?php
echo <<< EOT
    <form method="POST" action="index.php">
        <input type='hidden' name='action' value='readAllMyForm'>
        <input type='hidden' name='controller' value='users'>
        <div class="input">
            <input class="input-field" type="submit"  value="Your form"/>
        </div>
    </form>
	<a href='index.php?action=update&controller=users'>
		<button type="button"> Update your Account </button>	
    </a>

EOT;
?>
</div>