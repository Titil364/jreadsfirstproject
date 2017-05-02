<main> 
	<div id="connect">
		<h1>Welcome on the Log In in page</h1>
		<button class="return">Return</button>
		<form class="formCss" method="POST" action="index.php">
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
				</div>
			</fieldset> 
		</form>
	</div>
	<div id="visitorAccess">
						<h1>Welcome to the visitor interface</h1>
				<button class="return">Return</button>
				<form class="formCss" method="GET" action="index.php">
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
		<div>Are you a : </div>
		<button id="visitor">Visitor</button>
		<div>or</div>
		<button id="user">User</button>
	</div>
</main>