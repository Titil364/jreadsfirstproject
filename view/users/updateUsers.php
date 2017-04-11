<form class ="formCss"id="userForm" method="post" action="index.php?action=updated&controller=users">
	<fieldset>
		<p>
		  <label for="userNickname">User Nickname</label> :
		  <input type="text" placeholder="doe34" name="userNickname" id="userNickname" value="<?php echo $data["userNickname"]?>" required/>
		  <p id="nicknameVerif"></p>
		</p>
		<p>
		  <label for="userForname">User Forname</label> :
		  <input type="text" placeholder="John" name="userForename" id="userForename" value="<?php echo $data["userForename"]?>" required/>
		</p>
		<p>
		  <label for="userSurname">User Surname</label> :
		  <input type="text" placeholder="Doe" name="userSurname" id="userSurname" value="<?php echo $data["userSurname"]?>" required/>
		</p>
		<p>
		  <label for="userMail">User Mail</label> :
		  <input type="email" placeholder="johndoe@mail.com" name="userMail" id="userMail"  value="<?php echo $data["userMail"]?>"required/> 
		</p>
		<p>
		  <label for="userPassword">User Password</label> :
		  <input type="password" minlength="6" placeholder="******" name="userPassword" id="userPassword" required/>
		</p>
		<p>
		  <label for="userPasswordVerif">User Password Confirmation</label> :
		  <input type="password" minlength="6" placeholder="******" name="userPasswordVerif" id="userPasswordVerif" required/>
		</p>
<!-- A quoi ça correspond ?-->
		<p id="passwordVerif"> </p>
		<p>
			<button type="submit" id ="validation"/>Save modification</button> 
		</p>
	</fieldset> 
</form>