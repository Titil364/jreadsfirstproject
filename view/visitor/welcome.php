<main>
	<?php
		$secureVisitorId = rawurlencode($visitorId);
		$secureFormId = rawurldecode($f->getFormId());
		
		$protectedFormName = htmlspecialchars($f->getFormName());
		//center pourra être remplacé par du css
		echo "<center><h1>$protectedFormName</h1><center>";
		
		foreach($applicationOrder as $order){
			$a = $applications[$order];
			$protectedName = htmlspecialchars($a->getApplicationName());
			$protectedDesc = htmlspecialchars($a->getApplicationDescription());
			$img =  "media/" . $folder . "/" . $a->getApplicationId() . "Img.png";
			
			$secureApplicationId = rawurlencode($a->getApplicationId());
			echo "<div class=\"applications\">";
			
			if(file_exists($img)){
				echo "<img src =\"$img\" >";
			}
			echo "<a href=\"index.php?controller=visitor&action=answerApplication&visitorId=$secureVisitorId&applicationId=$secureApplicationId&formId=$secureFormId\">";
			echo "<h3>$protectedName</h3>";
			if($protectedDesc != ""){
				echo "<p>$protectedDesc</p>";	
			}
			echo "</a>";
			echo "</div>";	
		}
	?>
</main>
