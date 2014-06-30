

<?php
    
    

	
require_once __DIR__ . '/../database_apoco/db_manager.php';
require_once __DIR__ . '/../database_apoco/db_config.php';
require_once __DIR__ . '/../database_apoco/json_tags.php';

require_once __DIR__ . '/../database_apoco/tbl/user_tbl.php';
require_once __DIR__ . '/../database_apoco/tbl/wunschgewicht_tbl.php';
require_once __DIR__ . '/../database_apoco/dto/user_dto.php';

require_once __DIR__ . '/../database_apoco/tools/bloodpressure_tool.php';


$response = array();
$db = new DB_Manager();


if (!$db) {

	$response["success"] = 0;
	$response["message"] = "connection error on external db while try to connect";
	echo "ERROR ERROR DB";
	echo json_encode($response);
	exit();
}

// mockup
// $_GET["user_id"] = "1";
// $_GET["date"] = "2013-06-22";
// $_GET["resolution"] = "tag";

if (checkRequiredFields()) {
	
	$user_id	= $_GET["user_id"];
	$date		= $_GET["date"];
	$resolution	= $_GET["resolution"];
	
	
	$db->connect();	
	
	$result = $db->getMealContent($user_id, $date, $resolution);
	
	
	if ($result["mealcontent"] != "none") {
		
		
		$db->selectDB(DB_Manager::CLEARFOOD);
		if ($result["mealcontent"] != "none") {
			
			$response["success"] = 1;	
			$response[JSON_TAGS::PAYLOAD]["productdata"] = array();
			$response[JSON_TAGS::PAYLOAD]["mealrecord"] = array();
			
			foreach ($result["mealcontent"] as $key => $value) {
								
				$productResult = $db->productData($value->barcode);
				array_push($response[JSON_TAGS::PAYLOAD]["productdata"], $productResult->toArray());
				array_push($response[JSON_TAGS::PAYLOAD]["mealrecord"], $value->toArray());
			}
		}
			
	} else {
		
		$response["success"] = 1;	
		$response[JSON_TAGS::PAYLOAD] = "none";
	}
	
	echo json_encode($response);

} else {
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";	
	echo json_encode($response);
}


function checkRequiredFields() {
	
	
	return isset($_GET["user_id"])
		&& isset($_GET["date"])
		&& isset($_GET["resolution"]);		
}



?>