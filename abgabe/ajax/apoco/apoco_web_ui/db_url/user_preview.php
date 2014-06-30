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

//MOCKUP
// $_GET["currentDate"] = "2013-07-26";
// $_GET["user_id"] = 1;


if (checkRequiredFields()) {
	
	$currentDate = $_GET["currentDate"];
	$user_id = $_GET["user_id"];
	
	
	$db->connect();		
	$user = $db->getUser($user_id);
	
	if ($user) {
		
		$response[JSON_TAGS::SUCCESS] = 1;
		
		$response[JSON_TAGS::PAYLOAD]["user"] =  $user->toArray();
		
		$bodyweight = $db->latestBodyweight($user);
		if ($bodyweight) {
			
			$response[JSON_TAGS::PAYLOAD]["bodyweight"] = $bodyweight->toArray();
		} else {
			
			$response[JSON_TAGS::PAYLOAD]["bodyweight"] = "none";
		}
		
		$wunschgewicht = $db->latestTargetweight($user);
		if ($wunschgewicht) {
			
			$response[JSON_TAGS::PAYLOAD]["wunschgewicht"] = $wunschgewicht->toArray();
		} else {
			
			$response[JSON_TAGS::PAYLOAD]["wunschgewicht"] = "none";
		}
		$tageslimit = $db->tageseinheiten($user);
		
		if ($tageslimit) {
			
			$response[JSON_TAGS::PAYLOAD]["tageslimit"] = $tageslimit->toArray();
		} else {
			
			$response[JSON_TAGS::PAYLOAD]["tageslimit"] = "none";
		}
		$nDays = 4;
		$bloodpressure = $db->latestNDaysBloodpressure($user, $currentDate, $nDays);		
		if(sizeof($bloodpressure) > 0) {
			
			$bpa = new BlutdruckAnalyse();
			$bpa->average($bloodpressure);
			$response[JSON_TAGS::PAYLOAD]["bloodpressure"] = $bpa->toArray();	
		} else {
			
			$response[JSON_TAGS::PAYLOAD]["bloodpressure"] = "none";	
		}
		
		echo json_encode($response);
	} else {
		
		$response[JSON_TAGS::SUCCESS] = 0;
		$response[JSON_TAGS::MESSAGE] = "no data found in db";
		echo json_encode($response);
	}		

} else {
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";
	echo json_encode($response);
}


function checkRequiredFields() {
	
	
	return	isset($_GET["currentDate"]) &&
			isset($_GET["user_id"]);	
}



?>