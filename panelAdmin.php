<?php
require_once 'inc/bootstrap.php';
require_once 'inc/header.php';
$db = App::getDatabase();
$auth = App::getAuth();
if(!$auth->restrictAdmin()){
	App::redirection('account.php');
}
?>
<div class="btn-group btn-group-justified">
	<a href="membreBack.php" class="btn btn-primary">Gerer les membres</a>
</div>