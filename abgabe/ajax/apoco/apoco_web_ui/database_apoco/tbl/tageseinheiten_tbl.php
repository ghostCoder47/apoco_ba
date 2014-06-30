


<?php

require_once __DIR__ . '/../columns/tageseinheiten_columns.php';

class TageseinheitenTbl implements TageseinheitenColumns {
	
	
	const TABLE_NAME = 'tageseinheiten';
	
	
	const STMT_CURRENT_TAGESLIMIT = 
		'SELECT * FROM tageseinheiten
			WHERE added_on = (
	        	SELECT MAX(added_on) FROM tageseinheiten
	            WHERE u_id = ?
	        )';
			
			
	const STMT_INSERT_TAGESLIMIT = 
		
		'INSERT INTO tageseinheiten
		(u_id, tageseinheiten)
		VALUES (?,?)';
	
}

?>