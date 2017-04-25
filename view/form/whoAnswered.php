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
		
				
		
		echo "<thead>";
		echo "<tr>";
		echo "<td>Date Completed</td>";
		foreach($questions as $q){
			echo "<td>".$q->getPersonnalInformationName()."</td>";
		}
		echo "<td>See</td>";
		echo "</thead>";
		echo "</tr>";
		echo "<tbody>";
		$i = 0;
		foreach($visitor as $f){
			echo "<tr>";
			$date = $array[$i][0];
			echo "<td>".$date[0]->getDateCompletePre()."</td>";
			$information = $array[$i][1];
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