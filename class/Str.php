<?php
class Str {
	public function random($length) {
		$alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}
} 