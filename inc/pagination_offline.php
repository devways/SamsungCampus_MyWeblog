<?php
class Pagination_offline{

	private $limit;
	private $total;
	private $data;

	function __construct($limit, $array){
		$this->limit = $limit;
		$this->data = $array;
		$this->total = ceil(count($array) / $limit);
	}

	function split($limit, $array, $page = 0){
		$start_index = $limit * $page;
		foreach($array as $key => $value){
			if ($key >= $start_index && $key < ($start_index + $limit)){
				$result_array[] = $value;
			}
		}
		return $result_array;
	}

	function links($limit, $formulaire, $page = 0){
		$html = "";
		for ($i = 0; $i < $this->total; $i++){
			$html .= '<input form="'.$formulaire.'" value="';
			$html .= $i;
			$html .= '" type="submit" name="page"/>';
		}
		return $html;
	}
}