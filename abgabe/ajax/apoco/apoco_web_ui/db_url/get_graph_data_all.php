

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
// $_GET["date"] = "2013-06-19";
// $_GET["resolution"] = "tag";


if (checkRequiredFields()) {
	
	$user_id	= $_GET["user_id"];
	$date		= $_GET["date"];
	$resolution	= $_GET["resolution"];
	
	
	$db->connect();		
	
	$result_bp 		= $db->getGraphDataBP($user_id, $date, $resolution);
	$result_bw 		= $db->getGraphDataBW($user_id, $date, $resolution);	
	$result_kcal_kg = $db->getGraphDataKCAL_KG($user_id, $date, $resolution);
		
	
	$tmp_user = new UserDto();
	$tmp_user->m_id = $user_id;
	$target_weight	= $db->latestTargetweight($tmp_user);
	$tageseinheiten = $db->tageseinheiten($tmp_user);
	
	
	$response[JSON_TAGS::SUCCESS] = 1;
	$response[JSON_TAGS::PAYLOAD] = array();
	
	if (sizeof($result_bp) > 0) {
		
		$response[JSON_TAGS::PAYLOAD]["bloodpressure"] = $result_bp;
	} else $response[JSON_TAGS::PAYLOAD]["bloodpressure"] = "none";
	
	if (sizeof($result_bw) > 0) {
		
		$response[JSON_TAGS::PAYLOAD]["bodyweight"] = $result_bw;
	} else $response[JSON_TAGS::PAYLOAD]["bodyweight"] = 0;
	
	if (sizeof($result_kcal_kg) > 0) {
		
		$response[JSON_TAGS::PAYLOAD]["kcal_kg_nrg"] = array();
		
		foreach ($result_kcal_kg as $index => $meal) {
			
			if (is_array($meal)) {
					
				$response[JSON_TAGS::PAYLOAD]["kcal_kg_nrg"]["data"] = array();				
				foreach ($meal as $key => $value) {						
					
					$response[JSON_TAGS::PAYLOAD]["kcal_kg_nrg"]["data"][] = $db->getMealEnergySum($value->getID());
				}
				 			
			} else if (is_object($meal)) {
					
				$response[JSON_TAGS::PAYLOAD]["kcal_kg_nrg"][$index] = $db->getMealEnergySum($meal->getID());
			} else {
								
				$response[JSON_TAGS::PAYLOAD]["kcal_kg_nrg"][$index] = "none";
			}
		}
	
		$response[JSON_TAGS::PAYLOAD]["kcal_kg"] = $result_kcal_kg;		
	} else $response[JSON_TAGS::PAYLOAD]["kcal_kg"] = "none";
	
	if ($target_weight != null) {
			
		$response[JSON_TAGS::PAYLOAD]["targetweight"] = $target_weight->toArray();
	} else $response[JSON_TAGS::PAYLOAD]["targetweight"] = "none";
	
	if ($tageseinheiten != null) {
		
		$response[JSON_TAGS::PAYLOAD]["tageseinheiten"] = $tageseinheiten->toArray();
	} else $response[JSON_TAGS::PAYLOAD]["tageseinheiten"] = "none";
	
	
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