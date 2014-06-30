

<?php

require_once __DIR__ . '/../columns/food_columns.php';

class FoodTbl implements FoodColumns {
	
	
	const TABLE_NAME = 'energie';
	
	
	const STMT_PRODUCT_DATA = 
		'SELECT markenname, produkt, EAN, menge FROM energie
			WHERE EAN = ?';
		
	
	
}

?>