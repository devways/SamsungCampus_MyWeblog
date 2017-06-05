<?php 
require_once 'inc/Bootstrap.php';

if(!empty($_POST) && !empty($_POST['email'])) {
	$db = App::getDatabase();
	$auth = App::getAuth();
	$session = Session::getInstance();
	if($auth->resetPassword($db, $_POST['email'])){
		$session->setFlash('success', "un email de reinitialisation vous a ete envoyer");
		App::Redirection("login.php");
		exit();
	} else {
		$session->setFlash('danger', "Aucun email ne corespond");
		App::Redirection('login.php');
	}			
}
?>

<?php require_once 'inc/header.php'; ?>

<h1>Se connecter</h1>

<form action="" method="POST">
	<div class="form-group">
		<label for="">email</label>
		<input type="email" name="email" class="form-control" />
	</div>
	<button type="submit" class="btn btn-primary">nouveau mot de passe</button>
</form>

<?php require_once 'inc/footer.php'; ?>