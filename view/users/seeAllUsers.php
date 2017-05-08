<main>
    <div class="adminPage">
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
                                        <th></th>
				</tr>
		   </thead>
EOT;
		echo "<tbody>";
		$count = 0;
		foreach($users as $u){
			$protectedSurname = htmlspecialchars($u->getSurname());
			$protectedForename = htmlspecialchars($u->getForename());
			$protectedMail = htmlspecialchars($u->getMail());
			$protectedSurname = htmlspecialchars($u->getNickname());
			//$state = ($u->getNonce() == NULL? "active":"Not active");
			
			echo "<tr id=\"$count\">";
				echo "<td>$protectedSurname</td>";
				echo "<td>$protectedForename</td>";
				echo "<td>$protectedMail</td>";
				echo "<td><select name=\"isAdmin\" size = \"1\">";
					echo "<option value=\"0\" ".($u->getIsAdmin() == 0? "selected": "")."> Regular";
					echo "<option value=\"1\" ".($u->getIsAdmin() == 1? "selected": "")."> Admin";
				echo "</select></td>";
				echo "<td><select name=\"userNonce\" size = \"1\">";
					echo "<option value=\"0\" ".($u->getNonce() == NULL? "selected":"")."> Active";
					echo "<option value=\"1\" ".($u->getNonce() != NULL? "selected":"")."> Not active";
				echo "</select></td>";
				echo "<td><button class=\"deleteAccount\">Delete</button></td>";
			echo "</tr>";
			
			$count++;
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
					<th></th>
				</tr>
		   </tfoot>
EOT;
	}
	?>

	</table>
    </div>
</main>