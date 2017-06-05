<?php
class Validator{
	
	private $data;
	private $errors = [];

	public function __construct($data){
		$this->data = $data;
	}	

	private function getField($field){
		if(!isset($this->data[$field])){
			return null;
		} else{
			return $this->data[$field];
		}
	}

	public function isAlphaNum($field, $errorMsg) {
		if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isUnic($field, $table, $db, $errorMsg){
		$record = $db->query("SELECT * FROM $table WHERE $field = ?", [$this->getField($field)])->fetch();
		if($record){
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isEmail($field, $errorMsg){
		if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isAlpha($field, $errorMsg) {
		if(!preg_match('/^[a-zA-Z- ]+$/', $this->getField($field))) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isConfirmed($field, $errorMsg) {
		if(empty($this->getField($field)) || $this->getField($field) != $this->getField($field . "_confirm") || (strlen($this->getField($field)) != strlen($this->getField($field . "_confirm")))) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isConfirmedUp($field, $errorMsg){
		if(($this->getField($field) != $this->getField($field . "_confirm")) || (strlen($this->getField($field)) != strlen($this->getField($field . "_confirm")))) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isValid(){
		return empty($this->errors);
	}

	public function getErrors(){
		return $this->errors;
	}
}