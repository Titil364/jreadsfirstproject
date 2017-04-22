<main>

	<table>
	<caption>All of my delicious forms</caption>

	<thead>
       <tr>
           <th>FormID</th>
           <th>Name of the form</th>
           <th>Number of form completed</th>
		   <th></th>
		   <th>Who answered ?</th>
		   <th>State </th>
       </tr>
	</thead>

	<?php if(!isset($form)){
		echo "No form available";
	}
	else{
//BODY
		echo "<tbody>";
		foreach($form as $f){
			$secureId = htmlspecialchars($f->getFormId());
			$secureName = htmlspecialchars($f->getFormName());
			$secureNbCompletedForm = htmlspecialchars($f->getCompletedForm());
			
			$protectedId = rawurlencode($f->getFormId());
			$fillable = htmlspecialchars($f->getFillable());
			
			switch ($fillable){
				case -1:
					$fillWrite = "Nothing available";
					break;
				case 0:
					$fillWrite = "PreForm available";
					break;
				case 1:
					$fillWrite = "PostForm available";
					break;
			}
			
			echo "<tr>";
				echo "<td>$secureId</td>";
				echo "<td>$secureName</td>";
				echo "<td>$secureNbCompletedForm</td>";
				echo "<td><a href=\"index.php?controller=form&action=read&id=$protectedId\" >See the form</a></td>";
				echo "<td><a href=\"index.php?controller=form&action=whoAnswered&id=$protectedId\" >Answers</a></td>";
				echo "<td>".$fillWrite."</td>";
			echo "</tr>";
		}
		
		
		echo "</tbody>";
//FOOTER
	if(count($form) > 5){
		echo <<< EOT
			<tfoot>
			   <tr>
				   <th>FormID</th>
				   <th>Name of the form</th>
				   <th>Number of form completed</th>
				   <th></th>
				   <th>Who answered ?</th>
			   </tr>
		   </tfoot>
EOT;
	}
	}
	?>

	</table>
</main>