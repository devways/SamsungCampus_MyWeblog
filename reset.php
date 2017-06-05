<?php
require_once 'inc/Bootstrap.php';
if(isset($_GET['id']) && isset($_GET['reset_token'])) {
	$auth = App::getAuth();
	$db = App::getDatabase();
	$session = Session::getInstance();
	$user = $auth->checkReset($db, $_GET['id'], $_GET['reset_token']);
	if($user) {
		if(!empty($_POST)){
			$validator = new Validator($_POST);
			$validator->isConfirmed('password', "");
			if($validator->isValid()){
				$password = $auth->hashPassword($_POST['password']);
				$db->query('UPDATE users SET password = ?, reset_token = NULL, reset_at = NULL WHERE id = ?', [$password, $user->id]);
				$session->setFlash('access', "votre mot de passe a bien ete comfirmer");
				$auth->connect($user);
				App::Redirection('account.php');
				exit();
			}	
		} 
	} else {
			$session->setFlash('danger', "ce token n'est pas valide");
			App::Redirection('login.php');
			exit();
	}
} else {
		App::Redirection('login.php');
}
?>

<?php require_once 'inc/header.php'; ?>

<h1>Reinisitalisation de mot de passe</h1>

<form action="" method="POST">
	<div class="form-group">
		<label for="">mot de pass</label>
		<input type="password" name="password" class="form-control" />
	</div>
	<div class="form-group">
		<label for=""> confirmation Mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" />
	</div>
	<button type="submit" class="btn btn-primary">Reinitialisation</button>
</form>

<?php require_once 'inc/footer.php'; ?>