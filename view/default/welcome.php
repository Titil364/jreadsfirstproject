<div id="welcomeimage">
    <img src ="media/chicilogo.png">
    <h1>Form interface</h1>
</div>

<main>
	<div id="connect">
		<h3>Please log yourself</h3>
		<button class="return">Return</button>
		<form class="formWelcome" method="POST" action="index.php">
			<fieldset>
				<legend>Log in :</legend>
				<input type='hidden' name='action' value='connected'>
				<input type='hidden' name='controller' value='users'>
				<div class="input">
					<label class="input-item" for="nick_id">Nickname</label>
					<input class="input-field" type="text" value="<?php if(isset($data['login'])){ echo htmlspecialchars($data['login']); }else{echo"";}?>" name="nickname" id="nick_id" required/>
				</div>
				<div class="input">
					<label class="input-item" for="pass_id">Password</label>
					<input class="input-field" type="password" name="password" id="pass_id" required/>
				</div>
				<div class="input">
					<input class="input-field" type="submit"  value="Send"/>
				</div>
				<div class="register-link">
					<a href="index.php?controller=users&action=create">
						<button type="button">Sign in</button>
					</a>
				</div><div class="none">
					<a href="index.php?controller=users&action=retrieveAccount">
						<button type="button">Password forgot ?</button>
					</a>
				</div>
			</fieldset> 
		</form>
	</div>
	<div id="visitorAccess">
						<h3>Get your form to complete it</h3>
				<button class="return">Return</button>
				<form class="formWelcome" method="GET" action="index.php">
						<fieldset>
								<legend>Please enter your Id : </legend>
								<input type='hidden' name='action' value='read'>
								<input type='hidden' name='controller' value='visitor'>
								<div class="input">
								</div>
								<div class="inputVisitorId">
										<label class="input-item" for="visitor_id" required>Visitor Id : </label>
										<input class="input-field" id="visitor_id" type="text" name="visitorId"/>
								</div>
								<div>
										<input class="input-field" type="button" id="submit" value="Send"/>
								</div>
						</fieldset> 
				</form>
	</div>
	<div id="welcome">
		<div>Are you  </div>
		<div>
			<div>
				
				<button id="visitor"><img id="visitorImg" src="media/chicismile.png"><div>Visitor</div></button>
			</div>

			<div>or</div>

			<div>
				<button id="user"><img id="userImg" src="media/chicismile.png"><div>User</div></button>
			</div>

			<div>?</div>
		</div>
	</div>
</main>