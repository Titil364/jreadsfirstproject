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

<div class="answerArea">
	<div><label id="Applic0Q1thumbs1"><img src="media/thumb1image.png" class="answerIcon"></label><input type="radio" value =""></div>
	<div><label id="Applic0Q1thumbs2"><img src="media/thumb2image.png" class="answerIcon"></label><input type="radio" value =""></div>
	<div><label id="Applic0Q1thumbs3"><img src="media/thumb3image.png" class="answerIcon"></label><input type="radio" value =""></div>
	<div><label id="Applic0Q1thumbs4"><img src="media/thumb4image.png" class="answerIcon"></label><input type="radio" value =""></div>
	<div><label id="Applic0Q1thumbs5"><img src="media/thumb5image.png" class="answerIcon"></label><input type="radio" value =""></div>
</div>


<script src ="script/welcome.js"></script>