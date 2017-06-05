<?php
require_once './inc/Bootstrap.php';

$db = App::getDatabase();

$tags = $_GET['tags'];


$tag = $db->query('SELECT titre, corps, categorie, firstImage_id, secondImage_id, thirdImage_id, date FROM articles WHERE tags  like "%'.$tags.'%" ORDER BY id_article DESC')->fetchAll();

foreach ($tag as $value) {
	echo '<h3>Categorie : ' . $value->categorie . '</h3>';
	echo '<h4>Publie le '. $value->date . '</h4>';
	echo $value->corps;

	if ($value->firstImage_id){
		$query = 'select url from images where id =' . $value->firstImage_id;
		if (!$res = $db->query($query)){
			var_dump($db->error);
		}
		else {
			while ($row = $res->fetch(PDO::FETCH_ASSOC)){
				$rows[] = $row;
			}
			$url_images[] = $rows[0]['url']; 
			$rows = [];
		}
	}
	if ($value->secondImage_id){
		$query = 'select url from images where id =' . $value->secondImage_id;
		if (!$res = $db->query($query)){
			var_dump($db->error);
		}
		else {
			while ($row = $res->fetch_assoc()){
				$rows[] = $row;
			}
			$url_images[] = $rows[0]['url'];
		}
	}
	if ($value->thirdImage_id){
		$query = 'select url from images where id =' . $value->thirdImage_id;
		if (!$res = $db->query($query)){
			var_dump($db->error);
		}
		else {
			while ($row = $res->fetch_assoc()){
				$rows[] = $row;
			}
			$url_images[] = $rows[0]['url']; 
		}
	}
	if (!empty($url_images)){
		foreach($url_images as $url) {
			echo '<img class ="col-md-offset-1 img-rounded" src="' . $url . '"/><br>';
		}
	}
}
?>
<a href="index.php">&#8592; Retour a la liste des billets</a>