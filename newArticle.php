<?php include './inc/header.php';
	if (!isset($_SESSION['auth']) && intval($_SESSION['auth']->access) == 0){
		header('Location: ./index.php');
	}
?>
	<div id="tools" class="input">
		<div class="alignMiddle">
			<button onclick="goBold()" class="tool" type="button">B</button>
			<button onclick="goDel()" class="tool" type="button">S</button>
			<button onclick="goUnderline()" class="tool" type="button">U</button>
			<button onclick="goLink()" class="tool" type="button">link</button>
			<button onclick="goColor()" class="tool" type="button">color</button>
			<button onclick="goVideo()" class="tool" type="button">video</button>
		</div>
	</div>
	<form onsubmit="checkPost(event)" method="POST" enctype="multipart/form-data" id="newArticle">
		<div id="article" class="input">
			<select autofocus name="categorie" id="categorie">
				<option value="Sport">Sport</option>
				<option value="Cinema">Cinema</option>
				<option value="Histoire">Histoire</option>
				<option value="Jeux Video">Jeux Video</option>
				<option value="Cuisine">Cuisine</option>
				<option value="Medecine">Medecine</option>
				<option value="Musique">Musique</option>
				<option value="Voyage">Voyage</option>
				<option value="Livre">Livre</option>
				<option value="High-Tech">High-Tech</option>
				<option value="Sexo">Sexo</option>
			</select>
			<div class="form-group" id="titre">
				<input class="form-control" id="newTitle" name="title" placeholder="Titre"/>
			</div>
			<div class="form-group" id="chapo">
				<input class="form-control" id="newChapo" name="chapo" placeholder="Chapo"/>
			</div>
			<div class="form-group" id="tags">
				<input class="form-control" name="tags" placeholder="tag1 tag2"/>
			</div>
			<textarea class="form-control" rows="25" id="input" name="corps"></textarea>
			<button type="button" onclick="getInput()" id="preview">Previsualiser l'article</button>
			<div id="output" class="input">
			</div>
			<input class="pictureFile" name="picture1" type="file"/>
			<input class="pictureFile" name="picture2" type="file"/>
			<input class="pictureFile" name="picture3" type="file"/>
			<input value="Envoyer l'article" type="submit"/>
			<?php include './getPictures.php'; ?>
		</div>
	</form>
	<script type="text/javascript" src="parser.js"></script>
<?php require_once 'inc/footer.php'; ?>