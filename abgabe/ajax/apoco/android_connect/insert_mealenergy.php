

<?php

// muss erst mal gecheckt werden


require_once __DIR__ . '/apoco/db_manager.php';
require_once __DIR__ . '/apoco/json_tags.php';
require_once __DIR__ . '/db_connect_apoco.php';
require_once __DIR__ . '/apoco/columns/user_columns.php';
require_once __DIR__ . '/apoco/columns/mealenergy_columns.php';
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
//$_POST["user"] = "{\"nachname\":\"janas\",\"vorname\":\"dawid\",\"_id\":1,\"password\":\"aaaa\",\"email\":\"@.\"}";
//$_POST["payload"] = "[
						// [
							// {\"u_id\":1,\"_id\":4,\"sync\":0,\"added_on\":\"2013-06-18 16:40:21.727\"}					
					  		// ,{\"u_id\":1,\"_id\":13,\"sync\":0,\"added_on\":\"2013-06-19 13:50:28.205\"}
					  	// ]					 
					   // ,[
					   		// [
					   			// {\"barcode\":\"4006922001206\",\"meal_id\":4,\"weight\":57.2,\"_id\":4,\"sync\":0,\"energie_kcal\":113}
					 			// ,{\"barcode\":\"4006814001529\",\"meal_id\":4,\"weight\":130,\"_id\":5,\"sync\":0,\"energie_kcal\":638}
					 		// ]					 
						   // ,[
								// {\"barcode\":\"4006922000407\",\"meal_id\":13,\"weight\":86.7,\"_id\":15,\"sync\":0,\"energie_kcal\":198}
							// ]
						// ]
					// ]";
					
// $_POST["payload"] = 
// 	
		// "[
			// {
				// \"u_id\":1,\"_id\":4,\"sync\":0,\"added_on\":\"2013-06-18 16:40:21.727\"
			// },
			// {
				// \"u_id\":1,\"_id\":5,\"sync\":0,\"added_on\":\"2013-06-18 16:42:56.136\"
			// },
			// {
				// \"u_id\":1,\"_id\":6,\"sync\":0,\"added_on\":\"2013-06-19 11:57:21.622\"
			// },
			// {
				// \"u_id\":1,\"_id\":7,\"sync\":0,\"added_on\":\"2013-06-19 13:23:01.967\"
			// },
			// {
				// \"u_id\":1,\"_id\":8,\"sync\":0,\"added_on\":\"2013-06-19 13:25:01.448\"
			// },
			// {
				// \"u_id\":1,\"_id\":9,\"sync\":0,\"added_on\":\"2013-06-19 13:29:10.636\"
			// },
			// {
				// \"u_id\":1,\"_id\:10,\"sync\":0,\"added_on\":\"2013-06-19 13:37:23.007\"
			// },
			// {
				// \"u_id\":1,\"_id\":11,\"sync\":0,\added_on\":\"2013-06-19 13:47:28.035\"
			// },
			// {
				// \"u_id\":1,\"_id\":12,\"sync\":0,\"added_on\":\"2013-06-19 13:49:04.192\"
			// },
			// {
				// \u_id\":1,\"_id\":13,\"sync\":0,\"added_on\":\"2013-06-19 13:50:28.205\"
			// }
		// ],
		// [
			// [
				// {
					// \"barcode\":\"4006922001206\",\"meal_id\":4,\"weight\":57.2,\"_id\":4,\"sync\":0,\"energie_kcal\":113
				// },
				// {
					// \"barcode\":\"4006814001529\",\"meal_id\":4,\"weight\":130,\"_id\":5,\"sync\":0,\"energie_kcal\":638
				// }
			// ],
			// [
				// {
					// \"barcode\":\"4006922001206\",\"meal_id\":5,\"weight\":130.2,\"_id\":6,\"sync\":0,\"energie_kcal\":256
				// }
			// ],
			// [
				// {
					// \"barcode\":\"4006814001529\",\"meal_id\":6,\"weight\":93.7,\"_id\":7,\"sync\":0,"energie_kcal":460
				// },
				// {
					// \"barcode":"4006922001206","meal_id":6,"weight":364.9,"_id":8,"sync":0,"energie_kcal":719
				// }
			// ],
			// [
				// {
					// "barcode":"4006922001206","meal_id":7,"weight":86.8,"_id":9,"sync":0,"energie_kcal":171
				// }
			// ],
			// [
				// {
					// "barcode":"4006922001206","meal_id":8,"weight":13.9,"_id":10,"sync":0,"energie_kcal":27
				// }
			// ],
			// [
				// {
					// "barcode":"4006922000407","meal_id":9,"weight":13.9,"_id":11,"sync":0,"energie_kcal":32
				// }
			// ],
			// [
				// {
					// "barcode":"4006237640404","meal_id":10,"weight":21,"_id":12,"sync":0,"energie_kcal":75
				// }
			// ],
			// [
				// {
					// "barcode":"4006922000407","meal_id":11,"weight":13.9,"_id":13,"sync":0,"energie_kcal":32
				// }
			// ],
			// [
				// {
					// "barcode":"4006922001206","meal_id":12,"weight":13.9,"_id":14,"sync":0,"energie_kcal":27
				// }
			// ],
			// [
				// {
					// "barcode":"4006922000407","meal_id":13,"weight":86.7,"_id":15,"sync":0,"energie_kcal":198
				// }
			// ]
		// ]";
// 	
// 					

					  

if (checkRequiredFields()) {


	$db->connect();
	
	$user = json_decode($_POST[JSON_TAGS::USER], true);
	
	$db->connect();
	$user = $db->getUserByEmail($user[UserColumns::EMAIL]);
	
	if ($user) {
		
		$payload = json_decode($_POST["payload"], true);
		
		$result = $db->synchronizeMealenergy($user, $payload);		
		if ($result) {
			
			$response["success"] 	= 1;
			$response["message"] 	= "synchronizing mealenergy complete";
			$response["sync"] 		= $result;
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
	
	$response["success"] = 0;
	$response["message"] = "required field(s) is missing";
	echo json_encode($response);
}


function checkRequiredFields() {
		
	return 	isset($_POST[JSON_TAGS::USER]) && 
			isset($_POST[JSON_TAGS::PAYLOAD]);
			
}

?>