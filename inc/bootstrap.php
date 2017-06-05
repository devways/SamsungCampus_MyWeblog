<?php
spl_autoload_register('app_autoload');

function app_autoload($class){
	if(substr($class, 0 , 5) != 'Swift') {
		require_once "class/$class.php";
	}

}