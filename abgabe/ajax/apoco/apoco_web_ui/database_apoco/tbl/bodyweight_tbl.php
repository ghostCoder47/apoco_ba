

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
	
	
	const STMT_BODYWEIGHT = 
	
		'SELECT * FROM bodyweight 
		WHERE added_on = (
				SELECT MAX(added_on) FROM bodyweight
        		WHERE u_id = ?
        	)';
	
	
	const STMT_GRAPH_DATA_START = 
		//is
		'SELECT * FROM bodyweight
		WHERE added_on = (
			SELECT MAX(added_on) FROM bodyweight 
			WHERE u_id = ?
        	AND added_on < ?
        
		)';
			
	const STMT_GRAPH_DATA_TO_VIEW_D =
		//iss:id date date 
		'SELECT * FROM bodyweight
		WHERE u_id = ?
		AND added_on < ? + interval 1 DAY
		AND added_on >= ?';
		
	const STMT_GRAPH_DATA_TO_VIEW_W =
		//iss:id date date 
		'SELECT * FROM bodyweight
		WHERE u_id = ?
		AND added_on < ? + interval 1 WEEK
		AND added_on >= ?';
		
	const STMT_GRAPH_DATA_TO_VIEW_M =
		//iss:id date date 
		'SELECT * FROM bodyweight
		WHERE u_id = ?
		AND added_on < ? + interval 1 MONTH
		AND added_on >= ?';
		
		
	const STMT_GRAPH_DATA_END = 
		//is
		'SELECT * FROM bodyweight
		WHERE added_on = (
			SELECT MAX(added_on) FROM bodyweight 
			WHERE u_id = ?
        	AND added_on > ? + INTERVAL 1 DAY
        
		)';

}

?>