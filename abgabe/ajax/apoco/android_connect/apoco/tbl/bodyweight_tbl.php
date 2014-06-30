

<?php

require_once __DIR__ . '/../columns/bodyweight_columns.php';

class BodyweightTbl implements BodyweightColumns {
	
	
	const TABLE_NAME = 'bodyweight';
	
	
	const STMT_INSERT_BODYWEIGHT = 
		'INSERT INTO bodyweight (
			u_id, 
			added_on, 
			weight, 
			unit
			) VALUES (?,?,?,?)';
	
	
}

?>