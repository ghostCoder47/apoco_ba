


<?php

require_once __DIR__ . '/../columns/mealenergy_columns.php';

class MealenergyTbl implements MealenergyColumns {
	
	
	const TABLE_NAME = 'mealenergy';
	
	
	const STMT_INSERT_MEALENERGY = 
		'INSERT INTO mealenergy (
			u_id,
			added_on
			) VALUES (?,?)';
	
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