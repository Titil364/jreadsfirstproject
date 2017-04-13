<main>
	<div id="AAtable">
		<p>
			Would you like to do these activities again ? Tick a box for each ?
		</p>
		<table>
			<caption>Again Again table</caption>
			<thead>
			   <tr>
				   <th></th>
				   <th>Yes</th>
				   <th>Maybe</th>
				   <th>No</th>
			   </tr>
			</thead>
			<tbody>
			   <?php
					$i = 0;
					foreach($applicationTable as $value){
						echo "<tr>";
						echo "<td>".$value->getApplicationName()." : ".$alphabet[$i]."</td>";
						echo "<td><input type=\"radio\" name=\"radio".$i."\" class=\"radioButtonFS\"></td>";
						echo "<td><input type=\"radio\" name=\"radio".$i."\" class=\"radioButtonFS\"></td>";
						echo "<td><input type=\"radio\" name=\"radio".$i."\" class=\"radioButtonFS\"></td>";
						echo "</tr>";
						$i++;
					}
			   ?>
			</body>
		</table>
	</div>
	<p></p>
	<div id="FunSorter">
		<p>
			Write the activities in the boxes to show your preferences. The first is an example
		</p>
		<table>
			<caption>Fun Sorter</caption>
			<thead>
			   <tr>
				   <th>Newest</th>
				   <?php
						$i = 0;
						foreach($applicationTable as $value){
							echo "<th>".$value->getApplicationName()." : ".$alphabet[$i]."</th>";
							$i++;
						}
				   ?>
				   <th>Oldest</th>
			   </tr>
			</thead>
			<tbody>
			   <?php
					$j = 0;
					foreach($FSQuestionTable as $val){
						$name = $val->getFSQuestionName();
						$afficher = explode("/", $name);
						echo "<tr class=\"randomizeFS\"id=\"tr".$j."\">";
						echo "<td>".$afficher[0]."</td>";
						$i = 0;
						foreach($applicationTable as $value){
							echo "<td> <div class=\"FSmove".$j."\">".$alphabet[$i]."</div> </td>";
							$i++;
						}
						$j++;
						echo "<td>".$afficher[1]."</td>";
						echo "</tr>";
					}
			   ?>
			</tbody>
		</table>
		<table>
			x
		</table>
	</div>
	<script src="script/myScriptSheet2.js"></script>
</main>
    

 