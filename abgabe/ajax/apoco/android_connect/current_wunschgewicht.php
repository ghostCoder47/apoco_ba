

<?php

require_once __DIR__ . '/apoco/db_manager.php';
require_once __DIR__ . '/db_connect_apoco.php';
require_once __DIR__ . '/apoco/columns/user_columns.php';

require_once __DIR__ . '/apoco/db_config.php';
require_once __DIR__ . '/apoco/json_tags.php';
require_once __DIR__ . '/apoco/dto/user_dto.php';
require_once __DIR__ . '/apoco/dto/wunschgewicht_dto.php';



$response = array();
$db = new DB_Manager();


if (!$db) {

	$response["success"] = 0;
	$response["message"] = "connection error on external db while try to connect";
	echo "ERROR ERROR DB";
	echo json_encode($response);
	exit();
}

//mockup
// $_POST["user"] = "{\"nachname\":\"janas\",\"vorname\":\"dawid\",\"_id\":1,\"password\":\"aaaa\",\"email\":\"@.\"}";


if (checkRequiredFields()) {
	
	$user = json_decode($_POST[JSON_TAGS::USER], true);
	$db->connect();	
	
	$user = $db->getUserByEmail($user[UserColumns::EMAIL]);
	
	if ($user) {
		
		$result = $db->currentWunschgewicht($user);
		if(!empty($result)) {
			
			$response["success"] = 1;
			$response["message"] = "wunschgewicht erfolgreich ausgelesen";
			$response[WunschgewichtTbl::TABLE_NAME] = $result->toArray();
			echo json_encode($response);			
		} else {
				
			$response["success"] = 0;
			$response["message"] = "wunschgewicht konnten nicht bereitgestellt werden";
			echo json_encode($response);			
		}
	} else {
			
		$response["success"] = 0;
		$response["message"] = "user unknow on this server";
		echo json_encode($response);			
	}

} else {
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";
	echo json_encode($response);
}


function checkRequiredFields() {
	
	return isset($_POST[JSON_TAGS::USER]);
}

?>