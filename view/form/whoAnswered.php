<main>

	<table>
	<caption>All my delicious answers</caption>

	<thead>
       <tr>
           <th>Visitor Id</th>
           <th>Secret Name</th>
           <th>Code POST</th>
		   <th>Ble</th>
       </tr>
	</thead>

	<?php $Ble = "doux";
	
	if(!isset($visitor) || count($visitor) == 0){
		echo "<tr><td colspan=4>Nobody has answered the form. </td></tr>";
	}
	else{
//BODY
		echo "<tbody>";
		foreach($visitor as $f){
			$secureId = htmlspecialchars($f->getVisitorId());
			$secureName = htmlspecialchars($f->getVisitorSecretName());
			$codeForm = htmlspecialchars($Ble);
			

			
			echo "<tr>";
				echo "<td>$secureId</td>";
				echo "<td>$secureName</td>";
				echo "<td>$codeForm</td>";
				echo "<td>Ble</td>";
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