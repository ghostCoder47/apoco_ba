
<?php


class DB_CONNECT {
	
	
	function __construct() {
		
		$this->connect();
	}
	
	
	function __destruct() {
		
		$this->close();
	}
	
	
	function connect() {
		
		require_once __DIR__ . '/apoco/db_config.php';
		$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die (mysql_error());
		$db = mysql_select_db(DB_DATABASE) or die (mysql_error());
		return $connection;
	}   
	
	
	function close() {
		
		mysql_close();
	}
}


?>