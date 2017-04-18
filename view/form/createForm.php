

 
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

			</div>
			<div id="customQuestion">
					<button type="button" id="addFSQuestion">Add a new question</button>
			</div>
			<button type="button" id="saveQuestion">Save questions</button>
		
	</div>
	<button type="button" id="submit">Create the form</button>
	<button type="button" id="preview">Preview the full Form</button>
	

</main>

<script src ="script/myscript.js"></script>
