

<?php

require_once __DIR__ . '/apoco/db_manager.php';
require_once __DIR__ . '/db_connect_apoco.php';
require_once __DIR__ . '/apoco/columns/user_columns.php';
require_once __DIR__ . '/apoco/columns/bodyweight_columns.php';
require_once __DIR__ . '/apoco/db_config.php';
require_once __DIR__ . '/apoco/dto/user_dto.php';
require_once __DIR__ . '/apoco/json_tags.php';


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
//$_POST["user"] = "{\"nachname\":\"d\",\"vorname\":\"d\",\"_id\":2,\"password\":\"aaaa\",\"email\":\"@.\"}"; 
//$_POST["payload"] = "[{\"devicename\":\"WeightTel\",\"unit\":\"kg\",\"added_on\":\"10-06-2013 14:20\",\"weight\":94,\"u_id\":2,\"_id\":4,\"sync\":0}]";

if (checkRequiredFields()) {

	$user = json_decode($_POST[JSON_TAGS::USER], true);
	
	$db->connect();
	$user = $db->getUserByEmail($user[UserColumns::EMAIL]);
	
	
	
	if ($user) {
		
		$payload = json_decode($_POST[JSON_TAGS::PAYLOAD],true);
		
		$result = $db->synchronizeBodyweight($user, $payload);
		if ($result) {
			
			$response["success"] = 1;
			$response["message"] = "synchronizing bodyweight complete";
			echo json_encode($response);			
		} else {
			
			$response["success"] = 0;
			$response["message"] = "synchronizing bodyweight failed";
			echo json_encode($response);
		}
		
	} else {
			
		$response["success"] = 0;
		$response["message"] = "user unknow on this server";
		echo json_encode($response);			
	}

} else {
	
	$response[JSON_TAGS::SUCCESS] = 0;
	$response[JSON_TAGS::MESSAGE] = "required field(s) is missing";
	echo json_encode($response);
}


function checkRequiredFields() {
	
	return 	isset($_POST[JSON_TAGS::USER]) &&
			isset($_POST[JSON_TAGS::PAYLOAD]);
}
?>