<form class ="formCss"id="userForm" method="post" action="index.php?action=created&controller=users">
	<fieldset>
		<p>
		  <label for="userNickname">User Nickname</label> :
		  <input type="text" placeholder="doe34" name="userNickname" id="userNickname" value="<?php echo $data["nickname"]?>" required/>
		  <p id="nicknameVerif"></p>
		</p>
		<p>
		  <label for="userForname">User Forname</label> :
		  <input type="text" placeholder="John" name="userForename" id="userForename" value="<?php echo $data["forename"]?>" required/>
		</p>
		<p>
		  <label for="userSurname">User Surname</label> :
		  <input type="text" placeholder="Doe" name="userSurname" id="userSurname" value="<?php echo $data["surname"]?>" required/>
		</p>
		<p>
		  <label for="userMail">User Mail</label> :
		  <input type="email" placeholder="johndoe@mail.com" name="userMail" id="userMail"  value="<?php echo $data["mail"]?>"required/> 
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
			<button type="button" id ="validation"/>Save modification</button> 
		</p>
	</fieldset> 
</form>