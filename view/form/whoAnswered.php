<main>
	<div>
		<input type="button" id="analytics" value="See Form Analytics">
	</div>

	<table>
	<caption>All answers</caption>

<?php
	
	
?>

	<?php
	$visitorSN = false;
	foreach($visitor as $v){
		if($v->getVisitorSecretName()!=null){
			$visitorSN = true;
		}
	}
	if(!isset($visitor) || $visitorSN == false){
		echo "<tr id=\"noAns\"><td colspan=4>Nobody has answered the form. </td></tr>";
	}
	else{
//BODY
		
		
		echo "<thead>";
		echo "<tr>";
		echo "<th>Date Completed</th>";
		foreach($questions as $q){
			echo "<th>".$q->getPersonnalInformationName()."</th>";
		}
		echo "<th>See</th>";
		echo "</thead>";
		echo "</tr>";
		echo "<tbody>";
		$i = 0;
		foreach($visitor as $s){
			$sName = $array[$i][2];
			if($sName != null){
				$date = $array[$i][0];
				echo "<tr>";			
				echo "<td>".$date."</td>";
				$information = $array[$i][1];
				$j=0;
				foreach($information as $a){
					$secure = htmlspecialchars ($a->getInformationName());
					echo "<td>$secure</td>";
				}
				$visitorId = $s->getVisitorId();
				echo "<td><a href=\""."index.php?controller=form&action=readAnswer&formId=$formId&visitorId=$visitorId\">Answer</a></td>";
				echo "</tr>";
			}
			$i++;
		}
		echo "</tbody>";
//FOOTER
	/*if(count($visitor) > 5){
		echo <<< EOT
			<tfoot>
				<tr>
					<th>Visitor Id</th>
					<th>Secret Name</th>
					<th>Number of form completed</th>
					<th>Code POST</th>
				</tr>
		   </tfoot>*/
//EOT;
	//}
	}
	?>

	</table>
	<input type="number" id="numberVisitor" value="1">
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
					$used = '<img src="docs/No.png" width=40px height=30px alt="No">';
				} else {
					$used = '<img src="docs/Yes.png" width=40px height=30px alt="Yes">';
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

