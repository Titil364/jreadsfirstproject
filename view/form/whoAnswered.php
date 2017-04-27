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
			$sName = $array[$i][2];
			if($sName !== null){
				$date = $array[$i][0];
				echo "<tr>";			
				echo "<td>".$date[0]->getDateCompletePre()."</td>";
				$information = $array[$i][1];
				$j=0;
				foreach($information as $a){
					$secure = htmlspecialchars ($a->getInformationName());
					echo "<td>$secure</td>";
				}
				$visitorId = $information[$i]->getVisitorId();
				echo "<td><a href=\""."index.php?controller=form&action=readAnswer&formId=$formId&visitorId=$visitorId\">Answer</a></td>";
				echo "</tr>";
				$i++;
			}
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
	<input type="button" id="addUser" value="Add Visitor">
	<?php
		echo '<input type="hidden" id="formId" value="'.$formId.'">'
	?>
	<table>
		<thead>
			<tr>
				<th>Id</th>
				<th>Used</th>
			</tr>
		</thead>
		<tbody id="users">
	<?php
			$i = 0;
			foreach($visitor as $f){
				if ($array[$i][2] === null){
					$used = "No";
				} else {
					$used="Yes";
				}
				$tdNum = $i+1;
				echo '<tr id="'.$tdNum.'">';
				echo '<td>'.$array[$i][3].'</td>';
				echo '<td>'.$used.'</td>';
				echo '</tr>';
				$i++;
			}
	?>
		</tbody>
	</table>
</main>

