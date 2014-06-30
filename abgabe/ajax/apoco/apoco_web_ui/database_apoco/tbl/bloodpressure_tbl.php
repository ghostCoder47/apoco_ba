


<?php

require_once __DIR__ . '/../columns/bloodpressure_columns.php';

class BloodpressureTbl implements BloodpressureColumns {
	
	
	const TABLE_NAME = 'bloodpressure';
	
	
	const STMT_INSERT_BLOODPRESSURE = 
	
		'INSERT INTO bloodpressure (
			u_id,
			added_on,
			diastolic,
			systolic,
			pulse
			) VALUES (?,?,?,?,?)';
			
	const STMT_LAST_NDAYS_BLOODPRESSURE = 
	
		'SELECT * FROM bloodpressure
		WHERE u_id = ? 
		AND added_on < ? + INTERVAL 1 DAY
		AND added_on >= ? - INTERVAL ? DAY';
		
	
	const STMT_BLOODPRESSURE = 
		
		'select * from bloodpressure';
		
	const STMT_GRAPH_DATA_START = 
		//is
		'SELECT * FROM bloodpressure
		WHERE added_on = (
			SELECT MAX(added_on) FROM bloodpressure 
			WHERE u_id = ?
        	AND added_on < ?
        
		)';		
		
	const STMT_GRAPH_DATA_TO_VIEW_D =
		//iss:id date date 
		'SELECT * FROM bloodpressure
		WHERE u_id = ?
		AND added_on < ? + interval 1 DAY
		AND added_on >= ?';
		
	const STMT_GRAPH_DATA_TO_VIEW_W =
		//iss:id date date 
		'SELECT * FROM bloodpressure
		WHERE u_id = ?
		AND added_on < ? + interval 1 WEEK
		AND added_on >= ?';
		
	const STMT_GRAPH_DATA_TO_VIEW_M =
		//iss:id date date 
		'SELECT * FROM bloodpressure
		WHERE u_id = ?
		AND added_on < ? + interval 1 MONTH
		AND added_on >= ?';
		
		
	const STMT_GRAPH_DATA_END = 
		//is
		'SELECT * FROM bloodpressure
		WHERE added_on = (
			SELECT MAX(added_on) FROM bloodpressure 
			WHERE u_id = ?
        	AND added_on > ? + INTERVAL 1 DAY
        
		)';
	
		
			
}

?>