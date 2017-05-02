<form action="index.php" method="post">
	<input type="hidden" name="action" value="retrieveAccountByLogin">
	<input type="hidden" name="controller" value="users">

	<div> 
		<label for="uN">Enter your user nickname : </label>
		<input id="uN" type="text" name="userNickname" required>
	</div>
	
	<button type="submit">Submit</button>
</form>