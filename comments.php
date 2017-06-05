<form id="comment" method="POST">
	<div class="form-group">
		<textarea class="form-control" rows="3" name="newComment" placeholder="Nouveau commentaire"></textarea>
		<input type="submit" value="Envoyer le commentaire"/>
	</div>
	<?php
	if (isset($_POST['newComment'])){
		$addMessage = $singletone->transfertComment($_GET['article'], $_SESSION['auth']->username, $_POST['newComment']);
		echo $addMessage;
	}
	?>
</form>