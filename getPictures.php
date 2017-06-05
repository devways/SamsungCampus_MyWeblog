<?php
if (!empty($_FILES) && !empty($_POST)){
	foreach($_FILES as $key => $value){
		if ($key == "picture1" || $key == "picture2" || $key == "picture3"){
			if ($value['type'] != ''){
				if ($value['size'] > 160000){
					echo "Le fichier " . $value['name'] . " est trop volumineux.";
					return false;
				}
				$type = strpos($value['type'], 'image');
				if ($type === false) {
					echo "Le fichier ".$value['name']." n'est pas une image.";
					return false;
				}
			}
		}
	}
	foreach($_FILES as $key => $value){
		if ($key == "picture1" || $key == "picture2" || $key == "picture3"){
			if ($value['type'] != ''){
				transfertImage($value['tmp_name'], $value['name']);
			}
		}
	}
}

if (!empty($_POST)){
	if (strlen($_POST['title']) < 10){
		echo '<br/>';
		echo "Votre titre doit comporter au moins 10 caracteres !";
		return false;
	}
	if (strlen($_POST['chapo']) < 10){
		echo '<br/>';
		echo "Votre chapo doit comporter au moins 10 caracteres !";
		return false;
	}
	if (strlen($_POST['corps']) < 150){
		echo '<br/>';
		echo "Votre article est trop court !";
		return false;
	}
	transfertPost();
}

function transfertImage($path, $name){
	$mysqli = new mysqli('localhost', 'root', '', 'blogweb');
	$dest = "./images/articles/" . $name;
	move_uploaded_file($path, $dest);
	$query = 'insert into images (url, img_name) values ("' . $dest . '", "' . $name . '")';
	$res = $mysqli->query($query);
	if (!$res){
		var_dump($mysqli->error);
	}
}

function transfertPost(){
	$ids = array();
	$cpt = 0;
	$id_article = getIdArticle();
	$mysqli = new mysqli('localhost', 'root', '', 'blogweb');
	$query = 'insert into articles (';
	if ($_FILES['picture1']['name'] != ''){
		$query .= 'firstImage_id, ';
	}
	if ($_FILES['picture2']['name'] != ''){
		$query .= 'secondImage_id, ';
	}
	if ($_FILES['picture3']['name'] != ''){
		$query .= 'thirdImage_id, ';
	}
	$query .= 'titre, chapo, corps, categorie, tags) values(';
	if ($_FILES['picture1']['name'] != ''){
		$query2 = 'select id from images where img_name like "' . $_FILES['picture1']['name'] . '"order by id desc limit 1';
		$res = $mysqli->query($query2);
		while ($row = $res->fetch_assoc()){
			$ids[] = $row;
		}
		$id = $ids[0]['id'];
		$query .= $id . ', ';
		$ids = array();
	}
	if ($_FILES['picture2']['name'] != ''){
		$query2 = 'select id from images where img_name like "' . $_FILES['picture2']['name'] . '"order by id desc limit 1';
		$res = $mysqli->query($query2);
		while ($row = $res->fetch_assoc()){
			$ids[] = $row;
		}
		$id = $ids[0]['id'];
		$query .= $id . ', ';
		$ids = array();
	}
	if ($_FILES['picture3']['name'] != ''){
		$query2 = 'select id from images where img_name like "' . $_FILES['picture3']['name'] . '"order by id desc limit 1';
		$res = $mysqli->query($query2);
		while ($row = $res->fetch_assoc()){
			$ids[] = $row;
		}
		$id = $ids[0]['id'];
		$query .= $id . ', ';
	}
	$query .= '"' . $_POST['title'] . '", "' . $_POST['chapo'] . '", "' . addslashes($_POST['corps']) . '", "' . $_POST['categorie'] . '", "' . $_POST['tags'] . '")';
	if (!$mysqli->query($query)){
		var_dump($mysqli->error);
	}
	header('Location:index.php');
}

function getIdArticle(){
	$id_article = array();
	$mysqli = new mysqli('localhost', 'root', '', 'blogweb');
	$query = 'select id_article from articles order by id_article desc limit 1';
	$res = $mysqli->query($query);
	while ($row = $res->fetch_assoc()){
		$id_article[] = $row;
	}
	$id_article = intval($id_article[0]['id_article']);
	return $id_article;
}