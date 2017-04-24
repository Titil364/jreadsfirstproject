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
		
		
		$date = ModelDateComplete::getDateByVisitorAndForm("4",$formId);
		$datePre = $date[0]->getDateCompletePre();
		$questions = ModelAssocFormPI::getAssocFormPIByFormId($formId);
		$array = array();
		$i = 0;
		echo "<thead>";
		echo "<tr>";
		echo "<td>Date Completed</td>";
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
			$date = ModelDateComplete::getDateByVisitorAndForm($f->getVisitorId(),$formId);
			echo "<td>".$date[0]->getDateCompletePre()."</td>";
			$information = ModelInformation::getInformationByVisitorId($f->getVisitorId());
			//var_dump($information);
			$j=0;
			foreach($information as $a){
				$secure = htmlspecialchars ($a->getInformationName());
				echo "<td>$secure</td>";
			}
			echo "<td></td>";
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