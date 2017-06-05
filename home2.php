	<?php
	if(isset($_POST['choix_sup']) && !empty($_POST['choix_sup'])){
		$choixsup = $_POST['choix_sup'];
		for($i=0, $num = count($choixsup); $i < $num; $i++){
			$sup_article = $pdo->query("DELETE FROM articles WHERE id_article = '".intval($choixsup[$i])."'");	
		}
	}
	?>
	<a href="newArticle.php"><button type="button" class="btn btn-success">Ajouter un article</button></a>

	<form method="post" id="displayArticle">
		<input type="submit" class="btn btn-danger" value="Supprimer un ou plusieurs articles">
	</form>

	<form method="get" id="Pagination">
	<?php
	include './inc/pagination.php';
	$mysqli = new mysqli('localhost', 'root', '', 'blogweb');
	$query = 'SELECT id_article, corps, categorie, tags, DATE_FORMAT(date, \'%d/%m/%Y a %H:%i:%s\') as date_ajout FROM articles ORDER BY id_article DESC';
	if (isset($_GET['page'])){
		$page = $_GET['page'];
	}
	else {
		$page = 0;
	}
	$pagination = new Pagination($mysqli, 10, $query);
	$data = $pagination->getData(10, $page);
	$links = $pagination->links(10, "Pagination", $page);
	?>
	<?php foreach($data as $value){ ?>|
	<h3><input form="displayArticle" type="checkbox" name="choix_sup[]" value="<?php echo $value['id_article']; ?>"><?php echo " Categorie ". $value['categorie']; ?></h3>
	<h4><?php echo "publie le ".$value['date_ajout']; ?></h4>
	<p><?php	echo $value['corps']; ?></p>
	<p><?php	echo  $value['tags']; ?></p>
	<?php } ?>
	<?php echo $links; ?>
	</form>