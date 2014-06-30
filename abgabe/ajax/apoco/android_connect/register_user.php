

<?php

require_once __DIR__ . '/apoco/db_manager.php';
require_once __DIR__ . '/db_connect_apoco.php';
require_once __DIR__ . '/apoco/columns/user_columns.php';

require_once __DIR__ . '/apoco/db_config.php';
require_once __DIR__ . '/apoco/dto/user_dto.php';


$response = array();
$db = new DB_Manager();


if (!$db) {

	$response["success"] = 0;
	$response["message"] = "connection error on external db while try to connect";
	echo "ERROR ERROR DB";
	echo json_encode($response);
	exit();
}

//MOCKUP
// $_POST[UserColumns::VORNAME] 	= "Dawid";
// $_POST[UserColumns::NACHNAME] 	= "Janas";
// $_POST[UserColumns::EMAIL] 		= "kahani@gmx.net";
// $_POST[UserColumns::PASSWORD] 	= "password";
// 	


if (checkPOSTValues()) {
	
	$user = new UserDto($_POST);	
	$db->connect();	
	
	
	if($db->emailInUse($user->getEmail()) == 0) {
		
		$result = $db->registerNewUser($user);
		if ($result) {
				
			$response["success"] = 1;
			$response["message"] = "user successfully registered";
			echo json_encode($response);
		} else {
				
			$response["success"] = 0;
			$response["message"] = "user registering failed";
			echo json_encode($response);				
		}
			
			
	} else {
			
		$response["success"] = 0;
		$response["message"] = "email <" . $user->getEmail() . "> allready in use";
		echo json_encode($response);			
	}
	

} else {
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";
	echo json_encode($response);
}


function checkPOSTValues() {
		
	return 	isset($_POST[UserColumns::VORNAME]) && 
			isset($_POST[UserColumns::NACHNAME]) && 
			isset($_POST[UserColumns::EMAIL]) && 
			isset($_POST[UserColumns::PASSWORD]);
}

?>