<header>
<h1>Welcome on the form creation page</h1>
<!-- This is supposed to be empty is there are no forms on this account-->
</header> 
<main>
<div id="existing">
	<p>Existing forms</p>
</div>
<div id="newForm">
	<!-- <button type="button">Add a new Form</button>-->

		<p>
			<label id="formTitle">Title : </label>
			<input type="text"  name ="title" placeholder="Form's Title">
		</p>
		<p>Choose your required information</p>
		<div>
			<p><h3>Predefined informations</h3></p>
			<form id="defaultInfCheckboxes">
				<input type="checkbox" name="informations" value="name">
				Name <br>
				<input type="checkbox" name="informations" value="age">
				Age <br>
				<input type="checkbox" name="informations" value="gender">
				Gender <br>
				<input type="checkbox" name="informations" value="secretName">
				Secret Name <br><br>
			</form>
		</div> 
		<button type="button" id="addField">Add a new Field</button>
		<div id="newField">
			
		</div>						

			<p> Existing tasks for this form</p>
			<button type="button" id="addApplication">Add a new Task</button>
	
</div>
<button type="button" id="submit">Create the form</button> 
 
 		<!--<div id="newTask">
				
				<label for="id2">Name : </label>
				<input type="text" id="id2" name ="title" placeholder="Task's Title">
				<p>
					<label for="id1">Image : </label>
					<input type="url"  id="id1" label="image" name ="title" placeholder="URL for the task's image">
					<button type ="button" value="Preview">Preview</button>
				</p>
				
				<p> Existing questions for this form</p> 
				<button type="button">Add a new Question</button>
				<fieldset id="newQuestion">
					<p>
						<label for="id">Title : </label>
						<input type="text" id="id" label="Title" name ="title" placeholder="Question's Title">
					</p>
					<p>
						<button type="button">Yes/No Question</button>
						<button type="button">Text Area</button>
						<button type="button">Thumb Up</button>
						<button type="button">Smiley</button>
					</p>
				</fieldset> 
			</div> -->