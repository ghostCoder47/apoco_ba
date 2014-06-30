


<?php

require_once __DIR__ . '/../columns/wunschgewicht_columns.php';

class WunschgewichtTbl implements WunschgewichtColumns {
	
	
	const TABLE_NAME = 'wunschgewicht';
	
	
	const STMT_CURRENT_WUNSCHGEWICHT = 
		'SELECT * FROM wunschgewicht
			WHERE added_on = (
	        	SELECT MAX(added_on) FROM wunschgewicht
	            WHERE u_id = (
	            SELECT _id FROM user
	            	WHERE email = ?
	            )
	        )';

			
}

?>