<?php
require_once 'inc/bootstrap.php';
Session::getInstance();
if(isset($_SESSION["auth"])){
	header('Location: account.php');
}
if(!empty($_POST)) {
	$errors = array();

	$db = App::getDatabase();
	$validator = new Validator($_POST);
	$validator->isAlphaNum("username","Votre pseudo n'est pas valide");
	if($validator->isValid()){
		$validator->isUnic("username", "users", $db, "Ce pseudo est deja pris");
	}
	$validator->isEmail("email","Votre email n'est pas valide");
	if($validator->isValid()){
		$validator->isUnic("email", "users", $db, "Cette email est deja pris");
	}	
	$validator->isAlpha("lastname","Votre nom n'est pas valide");
	$validator->isAlpha("firstname","Votre prenom n'est pas valide");
	$validator->isConfirmed("password", "Votre mot de passe n'est pas valide");

	if($validator->isValid()) {
		App::getAuth()->register($db, $_POST['username'], $_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password']);
		Session::getInstance()->setFlash('success',"un email de confirmation vous a ete envoyer");
		App::redirection('login.php');
	} else {
		$errors = $validator->getErrors();
	}
}

?>
<?php require 'inc/header.php' ?>

<h1>S'inscrire</h1>

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

<form action="" method="POST">
	<div class="form-group">
		<label for="">Pseudo</label>
		<input type="text" name="username" class="form-control" />
	</div>
	<div class="form-group">
		<label for="">nom</label>
		<input type="text" name="lastname" class="form-control" />
	</div>
	<div class="form-group">
		<label for="">prenom</label>
		<input type="text" name="firstname" class="form-control" />
	</div>
	<div class="form-group">
		<label for="">email</label>
		<input type="text" name="email" class="form-control" />
	</div>
	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="password" class="form-control" />
	</div>
	<div class="form-group">
		<label for="">Confirmez votre mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" />
	</div>

	<button type="submit" class="btn btn-primary">M'inscrire</button>
</form>

<?php require 'inc/footer.php' ?>