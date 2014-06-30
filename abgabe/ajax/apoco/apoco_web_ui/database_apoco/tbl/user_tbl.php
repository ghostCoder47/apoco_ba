


<?php

require_once __DIR__ . '/../columns/user_columns.php';

class UserTbl implements UserColumns {
	
	
	const TABLE_NAME = 'user';
	
	
	const STMT_GET_USERLIST = 
		'SELECT * FROM user';
		
	const STMT_GET_USER = 
		
		'SELECT * FROM user
		WHERE _id = ?';
		
		
		
	//ANDROID
	const STMT_EMAIL_IN_USE = 
		'SELECT COUNT(*) FROM user 
			WHERE email = ?';
		
		
	const STMT_REGISTER_NEW_USER = 
		'INSERT INTO user (
			vorname, 
			nachname, 
			email, 
			password
			) VALUES(?,?,?,?)';
	
	
	const STMT_GET_USER_BY_EMAIL = 
		'SELECT * FROM user 
		WHERE email = ?';
}

?>