<?php
require_once 'inc/bootstrap.php';
$db = App::getDatabase();
$auth = App::getAuth();
$auth->connectFromCookie($db);
if($auth->user()){
	App::Redirection('account.php');
} 
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
	$user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
	$session = Session::getInstance();
	if($user) {
		$session->setFlash('success', "vous etes desormais connecter");
		App::redirection('account.php');
	} else {
		$session->setFlash('danger', "identifiant ou mot de pass incorect");
		App::redirection('login.php');
	}
}
?>
<?php require_once 'inc/header.php'; ?>
<h1>Se connecter</h1>

<form method="POST">
	<div class="form-group">
		<label>Pseudo ou email</label>
		<input type="text" name="username" class="form-control" />
	</div>
	<div class="form-group">
		<label>Mot de passe<a href="forget.php">(jai oublier mon mot de passe)</a></label>
		<input type="password" name="password" class="form-control" />
	</div>
	<div class="form-group">
		<label>
			<input type="checkbox" name="remember" value="1">ce souvenir de moi
		</label>
	</div>

	<button type="submit" class="btn btn-primary">se connecter</button>
</form>

<?php require_once 'inc/footer.php'; ?>