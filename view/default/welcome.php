<main> 
	<div id="connect">
		<h1>Welcome on the Log In in page</h1>
		<button id="return">Return</button>
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
					<input class="input-field" type="submit"  value="Envoyer"/>
				</div>
				<div class="register-link">
					<a href="index.php?controller=users&action=create">
						<button type="button">Sign in</button>
					</a>
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


<script src ="script/welcome.js"></script>