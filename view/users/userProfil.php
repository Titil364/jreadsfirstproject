<div class="formCss">
		<fieldset>
				<legend>Your information</legend>
		
			<p>
				Nickname : <?php echo htmlspecialchars($data["userNickname"])?>
			</p>
			<p>
				Forename : <?php echo htmlspecialchars($data["userForename"])?>
			</p>
			<p>
				Surname : <?php echo htmlspecialchars($data["userSurname"])?>
			</p>
			<p>
				Mail : <?php echo htmlspecialchars($data["userMail"])?>
			</p>
		
		</fieldset>

    <form method="GET" action="index.php">
        <input type='hidden' name='action' value='readAllMyForm'>
        <input type='hidden' name='controller' value='users'>
        <div class="input">
            <input class="input-field" type="submit"  value="Your form"/>
        </div>
    </form>
	<a href='index.php?action=update&controller=users'>
		<button type="button"> Update your Account </button>	
    </a>
</div>