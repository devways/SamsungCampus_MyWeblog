<?php
if(isset($_POST['choix_sup']) && !empty($_POST['choix_sup'])){
	$choixsup = $_POST['choix_sup'];
	for($i=0, $num = count($choixsup); $i < $num; $i++){
		$sup_article = $pdo->query("DELETE FROM articles WHERE id_article = '".intval($choixsup[$i])."'");	
	}
}
?>
<form method="post" id="displayArticle">
	<?php
	if (isset($_SESSION['auth']) && intval($_SESSION['auth']->access) >= 2){
		echo '<input type="submit" class="btn btn-danger" value="Supprimer un ou plusieurs articles">';
		echo '<a href="newArticle.php">Ajouter un article</a>';
	}
	?>
</form>
<form id="pagination" method="GET">
	<?php
	include './inc/pagination.php';
	$mysqli = new mysqli('localhost', 'root', '', 'blogweb');
	$query = 'SELECT id_article, corps, categorie, tags, firstImage_id, secondImage_id, thirdImage_id, DATE_FORMAT(date, \'%d/%m/%Y a %H:%i:%s\') as date_ajout FROM articles ORDER BY id_article DESC';
	if (isset($_GET['page'])){
		$page = $_GET['page'];
	}
	else {
		$page = 0;
	}
	$pagination = new Pagination($mysqli, 10, $query);
	$data = $pagination->getData(10, $page);
	$links = $pagination->links(10, "pagination", $page);
	foreach($data as $value){
		if ($value['firstImage_id']){
			$query = 'select url from images where id =' . $value['firstImage_id'];
			if (!$res = $mysqli->query($query)){
				var_dump($mysqli->error);
			}
			else {
				while ($row = $res->fetch_assoc()){
					$rows[] = $row;
				}
				$url_images[] = $rows[0]['url']; 
				$rows = [];
			}
		}
		if ($value['secondImage_id']){
			$query = 'select url from images where id =' . $value['secondImage_id'];
			if (!$res = $mysqli->query($query)){
				var_dump($mysqli->error);
			}
			else {
				while ($row = $res->fetch_assoc()){
					$rows[] = $row;
				}
				$url_images[] = $rows[0]['url'];
			}
		}
		if ($value['thirdImage_id']){
			$query = 'select url from images where id =' . $value['thirdImage_id'];
			if (!$res = $mysqli->query($query)){
				var_dump($mysqli->error);
			}
			else {
				while ($row = $res->fetch_assoc()){
					$rows[] = $row;
				}
				$url_images[] = $rows[0]['url']; 
			}
		}
		if (isset($_SESSION['auth']) && intval($_SESSION['auth']->access) >= 0){
			echo '<input form="displayArticle" type="checkbox" name="choix_sup[]" value="' . $value['id_article'].'"/>';
		}
		echo '<h3>Categorie : ' . $value['categorie'] . '</h3>';
		echo "<h4>publie le ".$value['date_ajout']."</h4>";
		$firstSplit = explode('<a href="index.php?article=', $value['corps']);
		$titre = explode('"><h2 class="text-center">', $firstSplit[1])[0];
		$titre = str_replace(" ", "_", $titre);
		$firstSplit = $firstSplit[1];
		$firstSplit = explode('<h2 class="text-center">', $firstSplit);
		$firstSplit = $firstSplit[1];
		echo '<a href="index.php?article=';
		echo $titre;
		echo '"><h2 class="text-center">';
		echo $firstSplit;
		if (!empty($url_images)){
			foreach($url_images as $url) {
				echo '<img class="col-md-offset-1 img-rounded" src="' . $url . '"/><br>';
			}
		}
		$x =  explode(' ' , $value['tags']);
		foreach ($x as $tag) {
			echo '<a href="index.php?tags='. $tag . '"> ' . $tag . '</a>';
		}
		echo '<br/>
		';
		$rows = [];
		$url_images = [];
	}
	echo $links;
	?>
</form>