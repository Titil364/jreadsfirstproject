

 
<main>
	<h1>Welcome on the form creation page</h1>	
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
			
			
			<div id="funSorterInformation">
				<p>Choose your required questions for the fun sorter</p>
				<p><h3>Predefined questions</h3></p>
				<input type="checkbox" id="FSeasy" name="information" value="name" class="defaultInformation">
				<label for="name">Easy to do / Hard to do</label><br>
				<input type="checkbox" id="FSfun" name="information" value="age" class="defaultInformation">
				<label for="age">Most fun / Least fun</label><br>
				<input type="checkbox" id="FSlearn" name="information" value="gender" class="defaultInformation">
				<label for="gender">Learned the most / Learned the least</label><br>
				<input type="checkbox" id="FScool" name="information" value="secretName" class="defaultInformation">
				<label for="secretName">Most cool / Least cool</label><br>
				<input type="checkbox" id="FSboring" name="information" value="secretName" class="defaultInformation">
				<label for="secretName">Most boring / Least boring</label><br><br>
			</div>
		
	</div>
	<button type="button" id="submit">Create the form</button>

</main>

<script src ="script/myscript.js"></script>
