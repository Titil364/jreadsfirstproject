<main>

	<table>
	<caption>Manage users</caption>

	

	<?php 
	
		echo <<< EOT
			<thead>
				<tr>
					<th>Surname</th>
					<th>Forename</th>
					<th>Mail</th>
					<th>isAdmin</th>
					<th>State</th>
				</tr>
		   </thead>
EOT;
		echo "<tbody>";
		foreach($users as $u){
			$protectedSurname = htmlspecialchars($u->getSurname());
			$protectedForename = htmlspecialchars($u->getForename());
			$protectedMail = htmlspecialchars($u->getMail());
			//$protectedAdmin = ($u->getIsAdmin() == 1? "selected": "");
			//$state = ($u->getNonce() == NULL? "active":"Not active");
			
			echo "<tr>";
				echo "<td>$protectedSurname</td>";
				echo "<td>$protectedForename</td>";
				echo "<td>$protectedMail</td>";
				echo "<td><select name=\"admin\" size = \"1\">";
					echo "<option value=\"0\" ".($u->getIsAdmin() == 0? "selected": "")."> Regular";
					echo "<option value=\"1\" ".($u->getIsAdmin() == 1? "selected": "")."> Admin";
				echo "</select></td>";
				echo "<td><select name=\"active\" size = \"1\">";
					echo "<option value=\"0\" ".($u->getNonce() == NULL? "selected":"")."> Active";
					echo "<option value=\"1\" ".($u->getNonce() != NULL? "selected":"")."> Not active";
				echo "</select></td>";
			echo "</tr>";
		}
		echo "</tbody>";
//FOOTER
	if(count($users) > 5){
		echo <<< EOT
			<tfoot>
				<tr>
					<th>Surname</th>
					<th>Forename</th>
					<th>Mail</th>
					<th>isAdmin</th>
					<th>State</th>
				</tr>
		   </tfoot>
EOT;
	}
	?>

	</table>
</main>