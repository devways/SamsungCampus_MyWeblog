	<?php
	if (isset($_GET['article'])){
		include './soloArticle.php';
	}
	elseif(isset($_GET['tags'])){
		include './tags.php';
	}
	else {
		include './allArticle.php';
	}