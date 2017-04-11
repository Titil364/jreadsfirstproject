<fieldset>
        <legend>Log in :</legend>

	<div>
		Nickname : <?php echo $data["nickname"]?>
	</div>
	<div>
		Forename : <?php echo $data["forename"]?>
	</div>
	<div>
		Surname : <?php echo $data["surname"]?>
	</div>
	<div>
		Mail : <?php echo $data["mail"]?>
	</div>

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
EOT;
?>