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
					$i = 0;
					foreach($applicationTable as $value){
						echo "<tr>";
						echo "<th>".$value->getApplicationName()." : ".$alphabet[$i]."</th>";
						echo "<th><input type=\"radio\" name=\"radio".$i."\" class=\"radioButtonFS\"></th>";
						echo "<th><input type=\"radio\" name=\"radio".$i."\" class=\"radioButtonFS\"></th>";
						echo "<th><input type=\"radio\" name=\"radio".$i."\" class=\"radioButtonFS\"></th>";
						echo "</tr>";
						$i++;
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
					$i = 0;
					foreach($applicationTable as $value){
						echo "<th>".$value->getApplicationName()." : ".$alphabet[$i]."</th>";
						$i++;
					}
			   ?>
			   <th>Oldest</th>
		   </tr>
		   <?php
				foreach($FSQuestionTable as $val){
					$name = $val->getFSQuestionName();
					$afficher = explode("/", $name);
					echo "<tr>";
					echo "<th>".$afficher[0]."</th>";
					$i = 0;
					foreach($applicationTable as $value){
						echo "<th> <div class=\"FSmove\">".$alphabet[$i]."</div> </th>";
						$i++;
					}
					echo "<th>".$afficher[1]."</th>";
					echo "</tr>";
				}
		   ?>
		   
		</thead>
	</div>
	<script src="script/myScriptSheet2.js"></script>
</main>
    

 