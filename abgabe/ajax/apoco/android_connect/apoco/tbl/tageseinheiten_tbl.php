


<?php

require_once __DIR__ . '/../columns/tageseinheiten_columns.php';

class TageseinheitenTbl implements TageseinheitenColumns {
	
	
	const TABLE_NAME = 'tageseinheiten';
	
	
	const STMT_CURRENT_TAGESLIMIT = 
		'SELECT * FROM tageseinheiten
			WHERE added_on = (
	        	SELECT MAX(added_on) FROM tageseinheiten
	            WHERE u_id = (
	            SELECT _id FROM user
	            	WHERE email = ?
	            )
	        )';

			
			
	// const STMT_EMAIL_IN_USE = 'SELECT COUNT(*) FROM user 
		// WHERE email = ?';
// 		
// 		
	// const STMT_REGISTER_NEW_USER = 'INSERT INTO user (
		// vorname, 
		// nachname, 
		// email, 
		// password
		// ) VALUES(?,?,?,?)';
	
}

?>