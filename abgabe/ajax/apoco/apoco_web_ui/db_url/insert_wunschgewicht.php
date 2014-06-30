<?php
    
    

	
require_once __DIR__ . '/../database_apoco/db_manager.php';
require_once __DIR__ . '/../database_apoco/db_config.php';
require_once __DIR__ . '/../database_apoco/json_tags.php';

require_once __DIR__ . '/../database_apoco/tbl/wunschgewicht_tbl.php';



$response = array();
$db = new DB_Manager();


if (!$db) {

	$response["success"] = 0;
	$response["message"] = "connection error on external db while try to connect";
	echo "ERROR ERROR DB";
	echo json_encode($response);
	exit();
}

// $_GET["user_id"] = 1;
// $_GET["wunschgewicht"] = 60;


if (checkRequiredFields()) {
	
	$user_id = $_GET["user_id"];
	$wunschgewicht = $_GET["wunschgewicht"];
	
	$db->connect();	
	$result = $db->updateWunschgewicht($user_id, $wunschgewicht);
	
	if ($result == 1) {
		
		$response[JSON_TAGS::SUCCESS] = 1;
	} else {
		
		$response[JSON_TAGS::SUCCESS] = 0;
	}
	echo json_encode($response);

} else {
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";
	echo json_encode($response);
}


function checkRequiredFields() {
	
	
	return isset($_GET["user_id"])
	&& isset($_GET["wunschgewicht"]);	
}



?>