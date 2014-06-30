

<?php

require_once __DIR__ . '/apoco/db_manager.php';
require_once __DIR__ . '/db_connect_apoco.php';
require_once __DIR__ . '/apoco/columns/user_columns.php';
require_once __DIR__ . '/apoco/columns/food_columns.php';

require_once __DIR__ . '/apoco/db_config.php';
require_once __DIR__ . '/apoco/json_tags.php';
require_once __DIR__ . '/apoco/dto/user_dto.php';
require_once __DIR__ . '/apoco/dto/tageseinheiten_dto.php';


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
// $_POST[JSON_TAGS::EAN] = "{\"EAN\":\"4000286200169\"}";


if (checkRequiredFields()) {
	
	
	$ean = json_decode($_POST[JSON_TAGS::EAN], true);
	
	$db->connect();	
	$db->selectDB(DB_Manager::CLEARFOOD);
 	
	$result = $db->productData($ean[JSON_TAGS::EAN]);
	
	
	
	if(!empty($result)) {
						
						
		$fuck = $result->toArray();
		
		$response["success"] = 1;
		$response["message"] = "produkt wurde gefunden";
		$response[FoodTbl::TABLE_NAME] = $result->toArray();
		echo json_encode($response);			
	} else {
			
		$response["success"] = 0;
		$response["message"] = "produkt leider nicht gefunden";
		echo json_encode($response);			
	}
	

} else {
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";
	echo json_encode($response);
}


function checkRequiredFields() {
		
	return 	isset($_POST[JSON_TAGS::EAN]);
}

?>