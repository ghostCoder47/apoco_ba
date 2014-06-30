


<?php

require_once __DIR__ . '/../columns/user_columns.php';
require_once __DIR__ . '/../columns/bloodpressure_columns.php';
require_once __DIR__ . '/../columns/bodyweight_columns.php';
require_once __DIR__ . '/../columns/wunschgewicht_columns.php';
require_once __DIR__ . '/../columns/tageseinheiten_columns.php';


class UserJoinTbl  {
	
	
	const STMT_USER_PREVIEW = 
	
		'SELECT
			user.vorname, 
			user.nachname, 
			user.email,
			bodyweight.weight, 
			wunschgewicht.wunschgewicht,
	        tageseinheiten.tageseinheiten,
	        avg.sys_avg,
	        avg.dia_avg,
	        avg.pulse_avg
		FROM user
		LEFT JOIN (
			SELECT * FROM bodyweight 
			WHERE added_on = (
	        	SELECT MAX(added_on) FROM bodyweight 
	            	WHERE u_id = ?
				)
			) AS bodyweight
		ON user._id = bodyweight.u_id
		LEFT JOIN (
			SELECT * FROM wunschgewicht 
			WHERE added_on = (
		    	SELECT MAX(added_on) FROM wunschgewicht 
		        	WHERE u_id = ?
				)
		    ) AS wunschgewicht
		ON user._id = wunschgewicht.u_id
		LEFT JOIN (
			SELECT 
			u_id,
			SUM(energie_kcal) AS consumption 
			FROM (
				SELECT * FROM mealenergy 
				WHERE u_id = ?
			) AS mealenergy
			INNER JOIN mealenergy_content
			ON mealenergy._id = mealenergy_content.meal_id
			WHERE added_on LIKE ?
		) AS energyconsumption
		ON user._id = energyconsumption.u_id
		LEFT JOIN (
			SELECT * FROM tageseinheiten
		    WHERE added_on = (
		    	SELECT MAX(added_on) FROM tageseinheiten
		        WHERE u_id = ?
			)
		) AS tageseinheiten
		ON user._id = tageseinheiten.u_id
		LEFT JOIN (
			SELECT 
			u_id,
			SUM(systolic) DIV COUNT(*) AS sys_avg,
			SUM(diastolic) DIV COUNT(*) AS dia_avg,
			SUM(pulse) DIV COUNT(*) AS pulse_avg
			FROM bloodpressure 
			WHERE added_on <= ? + INTERVAL 1 DAY
			AND added_on > ? - INTERVAL 4 DAY 
		) AS avg
		ON user._id = avg.u_id';
	
}

?>