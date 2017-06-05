<?php

class App {

	static $db;

	static function getDatabase() {
		if(!self::$db){
			self::$db = new Database('root', '', 'blogweb');
		}
		return self::$db;
	}

	static function getAuth() {
		return new dataAuth(Session::getInstance(), ['restriction_msg' => "lol test niker"]);
	}

	static function redirection($param) {
		header("Location: $param");
		exit();
	}
}