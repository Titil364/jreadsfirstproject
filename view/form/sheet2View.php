<main>
	<div id="AAtable">
		<p>
			Would you like to do these activities again ? Tick a box for each ?
		</p>
		<table id="aa">
			<caption>Again Again table</caption>
			<thead>
			   <tr>
				   <th></th>
				   <th>Yes</th>
				   <th>Maybe</th>
				   <th>No</th>
			   </tr>
			</thead>
			   <?php /*
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
			    */?>
		</table>
	</div>
	<p></p>
	<div id="FunSorter">
		<p>
			Write the activities in the boxes to show your preferences. The first is an example
		</p>
		<table id="fs">
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
		</table>
	</div>
	<div>
		<input type ="button" id="print" value="Printable">
	</div>
	<script src="script/myScriptSheet2.js"></script>
</main>
