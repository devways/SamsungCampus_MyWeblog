<?php
class Pagination{

	private $connection;
	private $limit;
	private $requete;
	private $total;

	public function __construct($connection, $limit, $requete){
		$this->connection = $connection;
		$this->limit = $limit;
		$this->requete = $requete;
		$this->res = $connection->query($requete);
		$this->total = ceil($this->res->num_rows / $limit);
	}

	public function getData($limit, $page = 0){
		$requete = $this->requete." limit ".(($page) * $this->limit). ", $this->limit";
		$res = $this->connection->query($requete);
		if ($res){
			while ($row = $res->fetch_assoc()){
				$result[] = $row;
			}
			return $result;
		}
		else {
			var_dump($this->connection->error);
		}
	}

	public function links($limit, $formulaire, $page = 1){
		$html = "";
		for ($i = 0; $i < $this->total; $i++){
			$html .= '<input value="';
			$html .= $i;
			$html .= '" form="'.$formulaire.'"';
			$html .= ' type="submit" name="page"/>';
		}
		return $html;
	}
}