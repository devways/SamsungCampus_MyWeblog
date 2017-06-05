<?php
final class UserFactory {
	
	private $pdo;

	public static function Instance(){
		static $inst = null;
		if ($inst === null){
			$inst = new UserFactory();
		}
		return $inst;
	}

	private function __construct(){
		$pdo = new PDO('mysql:dbname=blogweb;host=localhost','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$this->pdo = $pdo;
	}

	public function getOneArticle($titre){
		$query = $this->pdo->prepare('SELECT corps, DATE_FORMAT(date, \'%d/%m/%Y a %H:%i:%s\') date, tags, categorie FROM articles WHERE titre like :titre');
		$query->execute(['titre' => $titre]);
		$article = $query->fetch();
		return $article;
	}

	public function transfertComment($titre, $auteur, $commentaire){
		if (strlen($commentaire) < 10){
			return "Votre commentaire doit faire plus de 10 caracteres !";
		}
		elseif (strlen($commentaire) > 500){
			return "Votre commentaire ne peut pas faire plus de 500 caracteres !";
		}
		else {
			$query = $this->pdo->prepare('SELECT id_article FROM articles WHERE titre LIKE :titre');
			$query->execute(['titre' => $titre]);
			$id_article = $query->fetch();
			$id_article = $id_article->id_article;
			$query = $this->pdo->prepare('INSERT INTO commentaires (id_article, auteur, commentaire) VALUES (:id_article, :auteur, :commentaire)');
			$query->execute(['id_article' => $id_article,
				'auteur' => $auteur,
				'commentaire' => htmlspecialchars($commentaire)]);
			return "Votre commentaire a bien ete valide";
		}
	}

	public function getComments($titre){
		$query = $this->pdo->prepare('SELECT id_article FROM articles WHERE titre LIKE :titre');
		$query->execute(['titre' => $titre]);
		$id_article = $query->fetch();
		$id_article = $id_article->id_article;
		$query = $this->pdo->prepare('SELECT auteur, commentaire, DATE_FORMAT(date, \'%d/%m/%Y a %H:%i:%s\') date from commentaires where id_article = :id_article ORDER BY date DESC');
		$query->execute(['id_article' => $id_article]);
		while ($res = $query->fetch()){
			$commentaires[] = $res;
		}
		if (isset($commentaires)){
			return $commentaires;
		}
		else {
			return false;
		}
	}
}