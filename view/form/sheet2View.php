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
			   <?php
					foreach($applicationTable as $value){
						echo "<tr>";
						echo "<th>".$value->getApplicationName()."</th>";
						echo "<th></th>";
						echo "<th></th>";
						echo "<th></th>";
						echo "</tr>";
					}
			   ?>
			</thead>
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
					foreach($applicationTable as $value){
						echo "<th>".$value->getApplicationName()."</th>";
					}
			   ?>
			   <th>Oldest</th>
		   </tr>
		   <?php
				for($i = 0;$i <= $nbFSQuestions; $i++){
					echo "<tr>";
					echo "<th> Easy to do </th>";
					foreach($applicationTable as $value){
						echo "<th> </th>";
					}
					echo "<th> Hard to do </th>";
					echo "</tr>";
				}
		   ?>
		   
		</thead>
	</div>
</main>
    

 