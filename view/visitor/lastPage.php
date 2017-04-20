<?php 
	echo "<div style=\"display:none;\" id=\"form-$formId\"> </div>";
?>
<div id="AAtable">
   <p>
	   Would you like to do these activities again ? Tick a box for each ?
   </p>
   <table id="aa">
	   <thead>
		  <tr>
			  <th></th>
			  <th>Yes</th>
			  <th>Maybe</th>
			  <th>No</th>
		  </tr>
	   </thead>
   </table>
</div>
<div id="FunSorter">
   <p>
	   Write the activities in the boxes to show your preferences. The first is an example
   </p>
   <table id="fs">
	   <thead>
		  <tr>
			  <th>Newest</th>
			  <?php
				   $i = 0;
				   foreach($applicationTable as $value){
					   echo "<th>".htmlspecialchars($value->getApplicationName())." : ".htmlspecialchars($alphabet[$i])."</th>";
					   $i++;
				   }
			  ?>
			  <th>Oldest</th>
		  </tr>
	   </thead>
   </table>
</div>
