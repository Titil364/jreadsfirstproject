<main>

	<table>
	<caption>All my delicious answers</caption>

	
<?php
	
	
?>

	<?php 
	
	if(!isset($visitor) || count($visitor) == 0){
		echo "<tr><td colspan=4>Nobody has answered the form. </td></tr>";
	}
	else{
//BODY
		$questions = ModelAssocFormPI::getAssocFormPIByFormId($formId);
		$array = array();
		$i = 0;
		echo "<thead>";
		echo "<tr>";
		foreach($questions as $q){
			echo "<td>".$q->getPersonnalInformationName()."</td>";
			$array[$i] = $q->getPersonnalInformationName();
			$i++;
		}
		echo "<td>See</td>";
		echo "</thead>";
		echo "</tr>";
		echo "<tbody>";
		foreach($visitor as $f){
			echo "<tr>";
			foreach($array as $a){
				$secure = htmlspecialchars ($f->getVisitorA($a));
				echo "<td>$secure</td>";
			}
			echo "</tr>";
		}
		
		
		echo "</tbody>";
//FOOTER
	if(count($visitor) > 5){
		echo <<< EOT
			<tfoot>
				<tr>
					<th>Visitor Id</th>
					<th>Secret Name</th>
					<th>Number of form completed</th>
					<th>Code POST</th>
				</tr>
		   </tfoot>
EOT;
	}
	}
	?>

	</table>
</main>