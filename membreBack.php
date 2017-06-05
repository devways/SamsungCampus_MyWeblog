<?php include './inc/header.php';?>
<div class="form-control">
		<?php
		if (empty($_GET)){
			echo '<form id="membres" method="GET">';
			include 'getMembres.php';
		}
		if (!empty($_GET)):
			$userData = $singletone->getMembre($_GET['user']) ?>
		<form method="post" id="pass">
			<div class="form-group">
				<input class="form-control" type="text" name="username" value="<?= ucwords($userData->username) ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="firstname" value="<?= ucwords($userData->firstname) ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="lastname" value="<?= ucwords($userData->lastname) ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="email" name="email" value="<?= $userData->email ?>">
			</div>
			<input type="hidden" name="id" value="<?= $userData->id ?>"/>
			<div class="form-group">
				<select name="rang"class="form-control" id="sel1">
				<option value="0">Bannir le membre</option>
				<option value="1">Donner le rang utilisateur</option>
				<option value="2">Donner le rang auteur</option>
				<option value="3">Donner le rang administrateur</option>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Mettre a jour</button>
		</form>
		<?php
		var_dump($_POST);
		if (!empty($_POST)){
			echo "blaaaah";
			$singletone->editMembre();
		}
		endif;
		?>
	</form>
</div>
<?php
include './inc/footer.php';