<?php
$article = $singletone->getOneArticle($_GET['article']);
echo '<h3>Categorie : ' . $article->categorie . '</h3>';
echo "<h4>publie le " . $article->date . "</h4>";
$firstSplit = explode('<a href="index.php?article=', $article->corps);
$titre = explode('"><h2 class="text-center">', $firstSplit[1])[0];
$titre = str_replace(" ", "_", $titre);
$firstSplit = $firstSplit[1];
$firstSplit = explode('<h2 class="text-center">', $firstSplit);
$firstSplit = $firstSplit[1];
echo '<a href="index.php?article=';
echo $titre;
echo '"><h2 class="text-center">';
echo $firstSplit;
echo $article->tags;
if (isset($_SESSION['auth']) && intval($_SESSION['auth']->access) >= 0){
	include './comments.php';
}
else {
	echo '<br/><a href="./login.php">Pour laisser un commentaire, merci de vous connecter.</a>';
}
$comments = $singletone->getComments($_GET['article']);
if ($comments){
	foreach($comments as $value){
		echo '<div class="container">';
		echo '<h4>Publie par : ' . $value->auteur . '</h4>';
		echo '<h5>publie le ' . $value->date . '</h5>';
		echo '<p>' . str_replace("\n", '<br/>', $value->commentaire) . '</p>';
		echo '</div>';
	}
}
?>