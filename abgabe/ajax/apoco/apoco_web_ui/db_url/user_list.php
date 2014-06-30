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

// $_GET["currentDate"] = "2013-07-21";

if (checkRequiredFields()) {
	
	$currentDate = $_GET["currentDate"];
	
	$db->connect();		
	$result = $db->userList();
	if (mysqli_num_rows($result) > 0) {
				
		$response[JSON_TAGS::SUCCESS] = 1;
		$response[JSON_TAGS::PAYLOAD] = array();
		$response[JSON_TAGS::PAYLOAD]["user"] = array();
		$response[JSON_TAGS::PAYLOAD]["bodyweight"] = array();
		$response[JSON_TAGS::PAYLOAD]["targetweight"] = array();
		$response[JSON_TAGS::PAYLOAD]["bloodpressure"] = array();
		$response[JSON_TAGS::PAYLOAD]["kcal"] = array();
		$response[JSON_TAGS::PAYLOAD]["tageslimit"] = array();
		
		
		while ($user = $result->fetch_object()) {
		
			$u = new UserDTO();
			$u->mysqli_result_init($user);
			array_push($response[JSON_TAGS::PAYLOAD]["user"], $u->toArray());
			
			$bodyweight = $db->latestBodyweight($u);
			
			if (null != $bodyweight) {
						
				array_push($response[JSON_TAGS::PAYLOAD]["bodyweight"], $bodyweight->toArray());
			} else {
				
				array_push($response[JSON_TAGS::PAYLOAD]["bodyweight"], "none");				
			}
			
			$targetweight = $db->latestTargetweight($u);
			
			if (null != $targetweight) {
				
				array_push($response[JSON_TAGS::PAYLOAD]["targetweight"], $targetweight->toArray());
			} else {
				
				array_push($response[JSON_TAGS::PAYLOAD]["targetweight"], "none");
			}
			
			
			
			$nDays = 4;
			$bp4Days = $db->latestNDaysBloodpressure($u, $currentDate, $nDays);
			if (sizeof($bp4Days) > 0) {
				
				$bpa = new BlutdruckAnalyse();
				$bpa->average($bp4Days);
				array_push($response[JSON_TAGS::PAYLOAD]["bloodpressure"], $bpa->toArray());
			} else {
				
				array_push($response[JSON_TAGS::PAYLOAD]["bloodpressure"], "none");
			}
			
			$tagesEnergie = $db->energyConsumption($u, $currentDate);
			if ($tagesEnergie) {
				
				array_push($response[JSON_TAGS::PAYLOAD]["kcal"], $tagesEnergie);				
			} else {
				
				array_push($response[JSON_TAGS::PAYLOAD]["kcal"], "none");	
			}
			
			$tageslimit = $db->tageseinheiten($u);		
			if ($tageslimit) {
				
				array_push($response[JSON_TAGS::PAYLOAD]["tageslimit"], $tageslimit->toArray());
			} else {
				
				array_push($response[JSON_TAGS::PAYLOAD]["tageslimit"], "none");
			}
			
		}
	
		echo json_encode($response);
	} else {
		
		$response[JSON_TAGS::SUCCESS] = 0;
		$response[JSON_TAGS::MESSAGE] = "no user found in db";
		echo json_encode($response);
	}		

} else {
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";
	echo json_encode($response);
}


function checkRequiredFields() {
	
	
	return isset($_GET["currentDate"]);	
}



?>