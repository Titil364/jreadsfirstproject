<form action="index.php" method="post">
	<input type="hidden" name="action" value="changedPassword">
	<input type="hidden" name="controller" value="users">
	<input type="hidden" name="nonce" value="<?php echo $nonce;?>">
	<input type="hidden" name="userNickname" value="<?php echo $nick;?>">

	<p>
	  <label for="userPassword">User Password</label> :
	  <input type="password" minlength="6" placeholder="******" name="userPassword" id="userPassword" required/>
	</p>
	<p>
	  <label for="userPasswordVerif">User Password Confirmation</label> :
	  <input type="password" minlength="6" placeholder="******" name="userPasswordVerif" id="userPasswordVerif" required/>
	</p>
	
	<button type="submit" />Submit</button>
</form>