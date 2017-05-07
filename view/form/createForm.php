
<main>
	<h1>Welcome on the form creation page</h1>	

	<div id="<?php echo htmlspecialchars($formId)?>" class="formCss">
			<div id="surveyInformations">
					<label for="formName">Name of the form : </label>
					<input id="formName" type="text"  name ="formName" placeholder="Form's Title" value="<?php echo (isset($formName)?htmlspecialchars($formName):"")?>">
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
				<?php 
					foreach($defaultInfo as $di){
						$checked = "";
						$name = $di->getPersonnalInformationName();
						if(!$create){
							for($i = 0; $i < count($personnalInformation); $i++){
								if($name == $personnalInformation[$i]->getPersonnalInformationName()){
									$checked = "checked";
									array_splice($personnalInformation, $i, 1);
									break;
								}
							}	
						}

						$protectedName = htmlspecialchars($name);
						$class = ($checked == "checked" ? "defaultInformationAlreadyChecked":"defaultInformation");
						echo "<div>";
						echo "<input type=\"checkbox\" name=\"informaton\" class=\"$class\" id=\"$protectedName\" $checked>";
						echo "<label for=\"$protectedName\"> $protectedName</label>";
						echo "</div>";
					}
				?>
				</div>
				<div id="customInformation">
					<button type="button" id="addField">Add a new field</button>
					<?php
						if(!$create){
							foreach($personnalInformation as $pi){
								$protectedName = htmlspecialchars($pi->getPersonnalInformationName());
								
								echo "<div class=\"field\">";
								echo "<input class=\"fieldInputCustom\" type=\"text\" placeholder=\"Your Field name\" value=\"$protectedName\">";
								//il va falloir link le button à la suppression du parent
								echo "<button class=\"removeButtonAECustom\" type=\"button\" value=\"Remove the Field\">Remove the Field</button>";
								echo "</div>";
							}	
						}
					?>
				</div>
			</div> 
			

			<!--                      -->
			<div id="applications">
				<div>
					<button type="button" id="addApplication">Add a new Application</button>
					<button type="button" id="makeMoveableApplication">Make applications moveable</button>
					<button type="button" id="makeMoveableQuestion">Make questions moveable</button>
				</div>
				<?php 
				if(!$create){
					$count = 0;
					foreach($applications as $a){
						$appliId = $a->getApplicationId();
						$protectedAppliId = htmlspecialchars($a->getApplicationId());
						$protectedAppliName = htmlspecialchars($a->getApplicationName());
						$protectedAppliDesc = htmlspecialchars($a->getApplicationDescription());
						
						$img =  "media/" . $folder . "/" . $appliId . "Img.png";
						$src = "";
						$class = "";
						if(file_exists($img)){
							$src = $img;
							$class = " displayed";
						}
						
						//Application wrapper
						echo "<div class=\"application formerApplication\" id=\"$protectedAppliId\">";
							//application info wrapper
							$info = $protectedAppliId . "Info";
							echo "<div id=\"$info\">";
								//application img displayer
								echo "<img class=\"imgDisplayer$class\"src=\"$src\">";
								//application title/name
								echo "<div class=\"appCreationTitle\">";
								$appliName = $protectedAppliId . "Name";
									echo "<label for=\"$appliName\">Name of the application : </label>";
									echo "<input type=\"text\" id=\"$appliName\" name=\"$appliName\" placeholder=\"Application's Title\" value=\"$protectedAppliName\">";
									echo "<button class=\"removeButton\" type=\"button\" value=\"Remove the application\">Remove the application</button>";
								echo "</div>";
								//application description
								echo "<div>";
								$desc = $protectedAppliId . "Desc";
								echo "<label for=\"$desc\">Describe your application : </label>";
								echo "<textarea id=\"$desc\" name=\"$desc\" placeholder=\"Describe me\">$protectedAppliDesc</textarea>";
								echo "</div>";
								//application image input
								echo "<div>";
									$i = $protectedAppliId . "Img";
									$text = ($src != ""?"(only if you want to change)":"");
									echo "<label for=\"$i\">Image of the application $text : </label>";
									echo "<input type=\"file\" id=\"$i\" name=\"Applic3Img\" accept=\"image/*\">";
									echo "<button class=\"removeImage\" type=\"button\" value=\"Remove image\">Remove the image</button>";
								echo "</div>";
							echo "</div>";
							//application questionPre wrapper
							echo "<div class=\"questionPreDiv\"><h3>Pre questions : </h3>";
								echo "<button class=\"addQuestionButton\" type=\"button\" value=\"Add Pre Question\">Add a Pre question</button>";
								$countQ = 1;
								foreach($questions_pre[$appliId] as $q){
									$idQuestion = htmlspecialchars($q->getQUestionId());
									$protectedQuestion = htmlspecialchars($q->getQuestionName());
									$type = $q->getQuestionTypeId();
									$qName = $idQuestion . "Name";
										echo "<div id=\"$idQuestion\" class=\"questionPre formerPreQuestion\"><div>";
										echo "<label for=\"$qName\">Question Pre n°$countQ : </label>";
										echo "<input type=\"text\" id=\"$qName\" name=\"$qName\" placeholder=\"Do you like carrots ?\" value=\"$protectedQuestion\">";
										echo "<button class=\"removeButton\" type=\"button\" value=\"Remove the question\">Remove the question</button>";
										echo "<select>";
										foreach($selectPlaceholders as $p){
											$selected = "";
											if($p->getQuestionTypeId() == $type){
												$selected = "selected";
											}
											$qTypeName = htmlspecialchars($p->getQuestionTypeName());
											$qTypeId = htmlspecialchars($qTypeName . idQuestion);
											echo "<option required=\"required\" value=\"$qTypeName\" id=\"$qTypeId\" $selected>$qTypeName</option> ";
										}
										echo "</select></div>";
										echo "<div class=\"answerArea\"></div>";
									echo "</div>";
									$countQ++;
								}

							echo "</div>";
							
							//application questionPost wrapper
							echo "<div class=\"questionPostDiv\"><h3>Post questions : </h3>";
								echo "<button class=\"addQuestionButton\" type=\"button\" value=\"Add Post Question\">Add a Post question</button>";
								$countQ = 1;
								foreach($questions_post[$appliId] as $q){
									$idQuestion = htmlspecialchars($q->getQUestionId());
									$protectedQuestion = htmlspecialchars($q->getQuestionName());
									$type = $q->getQuestionTypeId();
									$qName = $idQuestion . "Name";
										echo "<div id=\"$idQuestion\" class=\"questionPost formerPostQuestion\"><div>";
										echo "<label for=\"$qName\">Question Post n°$countQ : </label>";
										echo "<input type=\"text\" id=\"$qName\" name=\"$qName\" placeholder=\"Do you like carrots ?\" value=\"$protectedQuestion\">";
										echo "<button class=\"removeButton\" type=\"button\" value=\"Remove the question\">Remove the question</button>";
										echo "<select>";
										foreach($selectPlaceholders as $p){
											$selected = "";
											if($p->getQuestionTypeId() == $type){
												$selected = "selected";
											}
											$qTypeName = htmlspecialchars($p->getQuestionTypeName());
											$qTypeId = htmlspecialchars($qTypeName . $idQuestion);
											echo "<option required=\"required\" value=\"$qTypeName\" id=\"$qTypeId\" $selected>$qTypeName</option> ";
										}
										echo "</select></div>";
										echo "<div class=\"answerArea\"></div>";
									echo "</div>";
									$countQ++;
								}
							echo "</div>";
						echo "</div>";
						
						
						$count++;
					}
				}
				?>
			</div>
			
			
			<div id="funSorterInformation">
				<p>Choose your required questions for the fun sorter</p>
				<p><h3>Predefined questions</h3></p>
				<?php 
					foreach($defaultFS as $fs){
						$checked = "";
						$name = $fs->getFSQuestionName();
						if(!$create){
							for($i = 0; $i < count($fsQuestion); $i++){
								if($name == $fsQuestion[$i]->getFSQuestionName()){
									$checked = "checked";
									array_splice($fsQuestion, $i, 1);
									break;
								}
							}
						}
						$protectedName = htmlspecialchars($name);
						$protectedFS = htmlspecialchars($fs->getFSQuestionName());
						$class = ($checked == "checked"? "defaultFSQuestionAlreadyChecked": "defaultFSQuestion");
						echo "<div>";
						echo "<input type=\"checkbox\" name=\"FSQuestion\" class=\"$class\" id=\"$protectedFS\" $checked>";
						echo "<label for=\"$protectedFS\"> $protectedFS</label>";
						echo "</div>";
					}				
				?>

			</div>
			<div id="customQuestion">
					<button type="button" id="addFSQuestion">Add a new question</button>
					
					<?php
						if(!$create){
							foreach($fsQuestion as $fs){
								$names = explode("/", $fs->getFSQuestionName());
								$names[0] = htmlspecialchars($names[0]);
								$names[1] = htmlspecialchars($names[1]);
								echo "<div class=\"FSQuestionCustom\">";
									echo "<table><tr><td>";
										echo "<input class=\"questionInputLeftCustom\" type=\"text\" placeholder=\"First part\" value=\"$names[0]\">";
									echo "</td><td>";
										echo "<input type=\"text\" placeholder=\"Fake part\" style=\"visibility: hidden;\">";
									echo "</td><td>";
										echo "<input class=\"questionInputRightCustom\" type=\"text\" placeholder=\"Second part\" value=\"$names[1]\">";
									echo "</td></tr></table>";
									
									//Link le bouton au parent
									echo "<button class=\"removeButtonFS\" type=\"button\" value=\"Remove the Question\">Remove the Question</button>";
								echo "</div>";
							}
						}
					?>
			</div>
		
	</div>
	<?php 
		($create?$c="Create":$c="Update");
		echo "<button type=\"button\" id=\"submit\">$c the form</button>";
	?>
	
	<button type="button" id="preview">Preview the full Form</button>
</main>

<script src="script/formManipulation.js"></script>