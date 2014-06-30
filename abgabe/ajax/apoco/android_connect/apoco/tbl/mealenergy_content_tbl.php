


<?php

require_once __DIR__ . '/../columns/mealenergy_content_columns.php';

class MealenergyContentTbl implements MealenergyContentColumns {
	
	
	const TABLE_NAME = 'mealenergy_content';
	
	
	const STMT_INSERT_MEALENERGY_CONTENT = 
	
		'INSERT INTO mealenergy_content (
			meal_id,
			barcode,
			energie_kcal,
			weight
			) VALUES (?,?,?,?)';
			
}

?>