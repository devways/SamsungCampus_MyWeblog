<?php 
require_once 'inc/bootstrap.php';
$db = App::getDatabase();
$auth = App::getAuth();
$auth->restrict();
$session = Session::getInstance();
if(!empty($_POST)) {
	$errors = array();

	$db = App::getDatabase();
	$validator = new Validator($_POST);
	$validator->isAlphaNum("username","Votre pseudo n'est pas valide");
	$validator->isEmail("email","Votre email n'est pas valide");	
	$validator->isAlpha("lastname","Votre nom n'est pas valide");
	$validator->isAlpha("firstname","Votre prenom n'est pas valide");
	$validator->isConfirmedUp("password", "Votre mot de passe n'est pas valide");
	$errors = $validator->getErrors();
	if($validator->isValid()) {
		$auth->update($db, $_POST['username'], $_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password']);
		$session->setFlash('success',"Vos modif on bien ete pris en conte");
		$session = Session::getInstance();
		App::redirection('account.php');
	} else {
		$errors = $validator->getErrors();
	}
}
?>
<?php require_once 'inc/header.php'; ?>

<h1>Bonjour <?= $_SESSION['auth']->username; ?></h1>
<?php if (!empty($errors)): ?>
	<div class="alert alert-danger">
		<p>Vous n'avez pas remplis le formulaire correctement</p>
		<ul>
			<?php foreach($errors as $error): ?>
				<li><?= $error; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<form method="post" id="pass">
	<div class="form-group">
		<input class="form-control" type="text" name="username" value="<?= $_SESSION['auth']->username ?>">
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="firstname" value="<?= $_SESSION['auth']->firstname ?>">
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="lastname" value="<?= $_SESSION['auth']->lastname ?>">
	</div>
	<div class="form-group">
		<input class="form-control" type="email" name="email" value="<?= $_SESSION['auth']->email ?>">
	</div>
	<div class="form-group">
		<input class="form-control" type="password" name="password" placeholder="entrez votre nouveau mot de passe">
	</div>
	<div class="form-group">
		<input class="form-control" type="password" name="password_confirm" placeholder="confirmer le nouveau mot de passe">
	</div>
	<button type="submit" class="btn btn-primary">Mettre a jour</button>
</form>
<?php require_once 'inc/footer.php'; ?>