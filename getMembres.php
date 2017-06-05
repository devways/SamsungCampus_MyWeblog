<?php
include './inc/pagination.php';
$mysqli = new mysqli('localhost', 'root', '', 'blogweb');
$query = 'select username, lastname, firstname, access from users';
$pagination = new Pagination($mysqli, 10, $query);
if (!isset($_GET['page'])){
	$page = 0;
}
else {
	$page = $_GET['page'];
}
$membres = $pagination->getData(10, $page);
$links = $pagination->links(10, "membres", $page);
echo '<table class="table">';
echo '<tr>';
echo '<th>Pseudo</th><th>Nom</th><th>Prenom</th><th>Status</th>';
echo '</tr>';
foreach($membres as $value){
	switch ($value['access']) {
		case 0:
				$value['access'] = "Bannis";
			break;
		
		case 1:
				$value['access'] = "Utilisateur";
			break;

		case 2:
				$value['access'] = "Auteur";
			break;

		case 3:
				$value['access'] = "Administrateur";
			break;
	}
	echo '<tr>';
	echo '<td><a href="./membreBack.php?user=' . ucwords($value['username']) . '"/>' . ucwords($value['username']) . '</a></td><td>' . ucwords($value['lastname']) . '</td><td>' . ucwords($value['firstname']) . '</td><td>' . ucwords($value['access']) . '</td>';
	echo '</tr>';
}
echo '</table>';
echo $links;