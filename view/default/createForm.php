<header>
<h1>Welcome on the form creation page</h1>
<!-- This is supposed to be empty is there are no forms on this account-->
		<div id="signIn">
				<button type="button" id="goToSignIn">Sign In</button>
		</div>
</header> 
<main>
		
<!-- we don't need this for the moment
<div id="existing">
	<p>Existing forms</p>
</div>-->
<div id="newForm" class="formCss">
	<!-- <button type="button">Add a new Form</button>-->
		<div id="surveyInformations">
				<label for="formName">Name of the form : </label>
				<input id="formName" type="text"  name ="formName" placeholder="Form's Title">
		</div>
		
		<div id="userInformation">
			<p>Choose your required information</p>
			<p><h3>Predefined informations</h3></p>
			<div id="predefinedInformation">
			<!-- supposed to be empty -->
			<!-- structure type : 
			<div>
				<input id=""> <label for=""> </label>
			</div>
			-->
				<input type="checkbox" id="name" name="information" value="name" class="defaultInformation">
				<label for="name">Name </label><br>
				<input type="checkbox" id="age" name="information" value="age" class="defaultInformation">
				<label for="age">Age </label><br>
				<input type="checkbox" id="gender" name="information" value="gender" class="defaultInformation">
				<label for="gender">Gender </label><br>
				<input type="checkbox" id="secretName" name="information" value="secretName" class="defaultInformation">
				<label for="secretName">Secret Name </label><br><br>
			</div>
			<div id="customInformation">
				<button type="button" id="addField">Add a new field</button>
			</div>
		</div> 
		

		<!-- We don't need this for the moment
		<p> Existing applications for this form</p>-->
		<div id="applications">
			<div>
				<button type="button" id="addApplication">Add a new Application</button>
				<button type="button" id="makeMoveableApplication">Make applications moveable</button>
				<button type="button" id="makeMoveableQuestion">Make questions moveable</button>
			</div>
		</div>
	
</div>
<button type="button" id="submit">Create the form</button>

 <script src ="script/myscript.js"></script>
