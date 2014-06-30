


<?php

require_once __DIR__ . '/../columns/mealenergy_columns.php';

class MealenergyTbl implements MealenergyColumns {
	
	
	const TABLE_NAME = 'mealenergy';
	
	
	const STMT_ENERGY_CONSUMPTION = 
		
		'SELECT SUM(energie_kcal) FROM mealenergy_content
		WHERE meal_id IN (
			SELECT _id FROM mealenergy
			WHERE added_on LIKE ?
			AND u_id = ?)';
	
	
	
	const STMT_INSERT_MEALENERGY = 
		'INSERT INTO mealenergy (
			u_id,
			added_on
			) VALUES (?,?)';
			
			
	const STMT_GRAPH_DATA_START = 
		//is
		'SELECT * FROM mealenergy
		WHERE added_on = (
			SELECT MAX(added_on) FROM mealenergy 
        	WHERE u_id = ?
            AND added_on LIKE (
            	SELECT CONCAT(
                	(SELECT ? - INTERVAL 1 DAY)
                    , "%"
                )
            )             
		)';		
			
	const STMT_GRAPH_DATA_TO_VIEW_D =
		//iss:id date date 
		'SELECT * FROM mealenergy
		WHERE u_id = ?
		AND added_on < ? + interval 1 DAY
		AND added_on >= ?';
		
	const STMT_GRAPH_DATA_TO_VIEW_W =
		//iss:id date date 
		'SELECT * FROM mealenergy
		WHERE u_id = ?
		AND added_on < ? + interval 1 WEEK
		AND added_on >= ?';
		
	const STMT_GRAPH_DATA_TO_VIEW_M =
		//iss:id date date 
		'SELECT * FROM mealenergy
		WHERE u_id = ?
		AND added_on < ? + interval 1 MONTH
		AND added_on >= ?';
		
		
	const STMT_GRAPH_DATA_END = 
		//is
		'SELECT * FROM mealenergy
		WHERE added_on = (
			SELECT MIN(added_on) FROM mealenergy 
        	WHERE u_id = ?
            AND added_on LIKE (
            	SELECT CONCAT(
                	(SELECT ? + INTERVAL 2 DAY)
                    , "%"
                )
            )             
		)';
		
	
	const STMT_GRAPH_DATA_TO_VIEW_TZ =
		
		'SELECT * FROM mealenergy
		WHERE u_id = ?';
		
	
	const STMT_MEAL_CONTENT_D = 
	
		'SELECT barcode, added_on, energie_kcal, weight 
		FROM mealenergy_content
		JOIN (
			SELECT _id, added_on 
			FROM mealenergy
			WHERE u_id = ? 
			AND added_on < ? + INTERVAL 1 DAY
			AND added_on >= ?
		) AS mealenergy
		ON mealenergy_content.meal_id = mealenergy._id';
		
	
	const STMT_MEAL_CONTENT_W = 
	
		'SELECT barcode, added_on, energie_kcal, weight 
		FROM mealenergy_content
		JOIN (
			SELECT _id, added_on 
			FROM mealenergy
			WHERE u_id = ? 
			AND added_on < ? + INTERVAL 1 WEEK
			AND added_on >= ?
		) AS mealenergy
		ON mealenergy_content.meal_id = mealenergy._id';
		
		
	const STMT_MEAL_CONTENT_M = 
	
		'SELECT barcode, added_on, energie_kcal, weight 
		FROM mealenergy_content
		JOIN (
			SELECT _id, added_on 
			FROM mealenergy
			WHERE u_id = ? 
			AND added_on < ? + INTERVAL 1 MONTH
			AND added_on >= ?
		) AS mealenergy
		ON mealenergy_content.meal_id = mealenergy._id';
		
	
	
}

?>