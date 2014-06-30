


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
}

?>