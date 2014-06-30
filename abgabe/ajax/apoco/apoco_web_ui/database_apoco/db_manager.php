


<?php

require_once __DIR__ . '/tbl/user_tbl.php';
require_once __DIR__ . '/tbl/tageseinheiten_tbl.php';
require_once __DIR__ . '/tbl/food_tbl.php';
require_once __DIR__ . '/tbl/bodyweight_tbl.php';
require_once __DIR__ . '/tbl/bloodpressure_tbl.php';
require_once __DIR__ . '/tbl/mealenergy_tbl.php';
require_once __DIR__ . '/tbl/mealenergy_content_tbl.php';
require_once __DIR__ . '/tbl/tageseinheiten_tbl.php';
require_once __DIR__ . '/tbl/user_join_tbl.php';

require_once __DIR__ . '/dto/user_dto.php';
require_once __DIR__ . '/dto/food_dto.php';
require_once __DIR__ . '/dto/bodyweight_dto.php';
require_once __DIR__ . '/dto/bloodpressure_dto.php';
require_once __DIR__ . '/dto/mealenergy_dto.php';
require_once __DIR__ . '/dto/mealenergy_content_dto.php';
require_once __DIR__ . '/dto/tageseinheiten_dto.php';
require_once __DIR__ . '/dto/wunschgewicht_dto.php';
require_once __DIR__ . '/dto/help_dto/mealcontent_dto.php';

class DB_Manager {
	
	
	const APOCO_DB 	= 'apoco';
	const CLEARFOOD = 'clearfood';
	
	
	private $m_db;
	
	
	public function __construct() {
		
	}
	
	
	function __destruct() {
		
		$this->close();
	}
	
	
	public function connect() {
		
		require_once __DIR__ . '/db_config.php';
		$this->m_db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
		if (mysqli_connect_errno()) {
    			
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
		}
		return $this->m_db;
	}
	
	
	public function selectDB($db) {
		
		$this->m_db->select_db($db);		
	}
	
	
	public function close() {
		
	}



	// web_ui
	
	public function userList() {
		
		$stmt = $this->m_db->stmt_init();
		$sql = UserTbl::STMT_GET_USERLIST;
		
		$result = $this->m_db->query($sql);
		return $result;
	}
	
	
	public function getUser($user_id) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = UserTbl::STMT_GET_USER;
				
		
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('i', $user_id);
			$stmt->execute();	
			$values = array();
				
			$stmt->bind_result(		
				$values[UserColumns::_ID],
				$values[UserColumns::VORNAME],
				$values[UserColumns::NACHNAME],
				$values[UserColumns::EMAIL],
				$values[UserColumns::PASSWORD]);

			if ($stmt->fetch()) {
				
				$stmt->close();
				$user = new UserDTO();
				$user->array_init($values);
				return $user;
			}
			
		} return null;	
	}
	
	
	public function getUserPreview($user_id, $currentDate) {
						
		$stmt = $this->m_db->stmt_init();
		$sql = UserJoinTbl::STMT_USER_PREVIEW;
				
		
		if ($stmt->prepare($sql)) {
			
			$currentDate = $currentDate . "%";
			
			$stmt->bind_param('iiisiss', $user_id, $user_id, $user_id, $currentDate, $user_id, $currentDate, $currentDate);
			$stmt->execute();	
			$values = array();
				
			$stmt->bind_result(		
				$values[UserColumns::VORNAME],
				$values[UserColumns::NACHNAME],
				$values[UserColumns::EMAIL],				
				$values[BodyweightColumns::WEIGHT],
				$values[WunschgewichtColumns::WUNSCHGEWICHT],
				$values[TageseinheitenColumns::TAGESEINHEITEN],
				$values["sys_avg"],
				$values["dia_avg"],
				$values["pulse_avg"]);

			if ($stmt->fetch()) {
				
				$stmt->close();
				return $values;
			}
			
		} return null;	
	}
	
	
	public function latestBodyweight(UserDto $user) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = BodyweightTbl::STMT_BODYWEIGHT;
		if ($stmt->prepare($sql)) {
			
			$u_id = $user->getID();
			
			$stmt->bind_param('i', $u_id);
			$stmt->execute();	
			$values = array();
				
			$stmt->bind_result(			
				$values[BodyweightColumns::_ID],
				$values[BodyweightColumns::U_ID],
				$values[BodyweightColumns::ADDED_ON],
				$values[BodyweightColumns::WEIGHT],
				$values[BodyweightColumns::UNIT]);
			if ($stmt->fetch()) {
				
				$stmt->close();
				$bw = new BodyweightDTO();
				$bw->array_init($values);
				return $bw;
			}
			
		} return null;	
	}
	
	
	public function latestTargetweight(UserDto $user) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = WunschgewichtTbl::STMT_WUNSCHGEWICHT;
		if ($stmt->prepare($sql)) {
			
			$u_id = $user->getID();
			
			$stmt->bind_param('i', $u_id);
			$stmt->execute();	
			$values = array();
				
			$stmt->bind_result(			
				$values[WunschgewichtColumns::_ID],
				$values[WunschgewichtColumns::U_ID],
				$values[WunschgewichtColumns::ADDED_ON],
				$values[WunschgewichtColumns::WUNSCHGEWICHT],
				$values[WunschgewichtColumns::UNIT]);
			if ($stmt->fetch()) {				
				
				
				$stmt->close();
				$wg = new WunschgewichtDTO();
				$wg->array_init($values);
				return $wg;
			}
			
		} return null;	
	}
	
	
	public function tageseinheiten(UserDto $user) {
				
		$stmt = $this->m_db->stmt_init();
		$sql = TageseinheitenTbl::STMT_CURRENT_TAGESLIMIT;
		if ($stmt->prepare($sql)) {
			
			$u_id = $user->getID();
			
			$stmt->bind_param('i', $u_id);
			$stmt->execute();	
			$values = array();
				
			$stmt->bind_result(			
				$values[TageseinheitenColumns::_ID],
				$values[TageseinheitenColumns::U_ID],
				$values[TageseinheitenColumns::ADDED_ON],
				$values[TageseinheitenColumns::TAGESEINHEITEN]);
						
			if ($stmt->fetch()) {
				
				$stmt->close();
				$te = new TageseinheitenDTO();				
				$te->array_init($values);			
				return $te;
			}
			
		} return null;	
	}
	
	
	public function latestNDaysBloodpressure(UserDTO $user, $currentDate, $nDays) {
		
		
		$stmt = $this->m_db->stmt_init();
		$sql = BloodpressureTbl::STMT_LAST_NDAYS_BLOODPRESSURE;
		if ($stmt->prepare($sql)) {
			
			$u_id 		= $user->getID();
			
			$stmt->bind_param('issi', $u_id, $currentDate, $currentDate, $nDays);
			$stmt->execute();
				
			$values = array();
			$stmt->bind_result(
				$values[BloodpressureColumns::_ID],
				$values[BloodpressureColumns::U_ID],
				$values[BloodpressureColumns::ADDED_ON],
				$values[BloodpressureColumns::DIASTOLIC],
				$values[BloodpressureColumns::SYSTOLIC],
				$values[BloodpressureColumns::PULSE]);
			
			$result = $stmt->get_result();
			$resultData = array();
			while ($row = $result->fetch_assoc()) {
				
				$bp = new BloodpressureDTO();
				$bp->array_init($row);
				$resultData[] = $bp;
			}
			
			
			$stmt->close();
			return $resultData;	
					
		} return null;	
	}
	
	
	public function energyConsumption(UserDTO $user, $date) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = MealenergyTbl::STMT_ENERGY_CONSUMPTION;
		if ($stmt->prepare($sql)) {
			
			$u_id 		= $user->getID();
			$date = $date . "%";
			
			$stmt->bind_param('si', $date, $u_id);
			$stmt->execute();
				
			$energySum;
			$stmt->bind_result($energySum);
			if ($stmt->fetch()) {
					
					$stmt->close();
					return $energySum;
			}				
			$stmt->close();
					
		} return null;	
	}
	
	
	public function updateWunschgewicht($user_id, $wunschgewicht) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = WunschgewichtTbl::STMT_INSERT_WUNSCHGEWICHT;
		if ($stmt->prepare($sql)) {
						
			$stmt->bind_param('is', $user_id, $wunschgewicht);
			return $stmt->execute();
		}				
	}
	
	
	public function updateTageslimit($user_id, $tageslimit) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = TageseinheitenTbl::STMT_INSERT_TAGESLIMIT;
		if ($stmt->prepare($sql)) {
						
			$stmt->bind_param('ii', $user_id, $tageslimit);
			return $stmt->execute();
		}								
	}
	
	
	//graph data
	
		
	public function getGraphDataBP($user_id, $date, $resolution) {
		
		$resultData = array();
		
		$stmt = $this->m_db->stmt_init();
		$sql = BloodpressureTbl::STMT_GRAPH_DATA_START;
		if ($stmt->prepare($sql)) {
						
			$stmt->bind_param('is', $user_id, $date);
			$stmt->execute();
			
			$values = array();
			$stmt->bind_result(
				$values[BloodpressureColumns::_ID],
				$values[BloodpressureColumns::U_ID],
				$values[BloodpressureColumns::ADDED_ON],
				$values[BloodpressureColumns::DIASTOLIC],
				$values[BloodpressureColumns::SYSTOLIC],
				$values[BloodpressureColumns::PULSE]);
			$result = $stmt->get_result();
			if ($row = $result->fetch_assoc()) {				
				
				$resultData["start"] = $row;
			} else $resultData["start"] = "none";					
			$stmt->close();
								
		}; 	
		
		
		$stmt = $this->m_db->stmt_init();
		
		switch ($resolution) {
			
			case "tag":
				
				$sql = BloodpressureTbl::STMT_GRAPH_DATA_TO_VIEW_D;
				break;
				
			case "woche":
				
				$sql = BloodpressureTbl::STMT_GRAPH_DATA_TO_VIEW_W;
				break;
				
			case "monat":
				
				$sql = BloodpressureTbl::STMT_GRAPH_DATA_TO_VIEW_M;
				break;
		}		
		
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('iss', $user_id, $date, $date);
			$stmt->execute();
						
			$values = array();
			$stmt->bind_result(
				$values[BloodpressureColumns::_ID],
				$values[BloodpressureColumns::U_ID],
				$values[BloodpressureColumns::ADDED_ON],
				$values[BloodpressureColumns::DIASTOLIC],
				$values[BloodpressureColumns::SYSTOLIC],
				$values[BloodpressureColumns::PULSE]);
					
			$result = $stmt->get_result();			
			$resultData["data"] = array();
			$confirmed = false;
			while ($row = $result->fetch_assoc()) {
				
				
				array_push($resultData["data"], $row);
				$confirmed = true;	
			}		
			if (!$confirmed) $resultData["data"] = "none";
					
			$stmt->close();
							
		}; 	
		
				
		$stmt = $this->m_db->stmt_init();
		$sql = BloodpressureTbl::STMT_GRAPH_DATA_END;
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('is', $user_id, $date);
			$stmt->execute();
				
			$values = array();
			$stmt->bind_result(
				$values[BloodpressureColumns::_ID],
				$values[BloodpressureColumns::U_ID],
				$values[BloodpressureColumns::ADDED_ON],
				$values[BloodpressureColumns::DIASTOLIC],
				$values[BloodpressureColumns::SYSTOLIC],
				$values[BloodpressureColumns::PULSE]);
			
			$result = $stmt->get_result();
			if ($row = $result->fetch_assoc()) {
				
				$resultData["end"] = $row;
			} else $resultData["end"] = "none";					
			$stmt->close();
			return $resultData;	
					
		}return null;	
		
		
	}
		
	
	public function getGraphDataBW($user_id, $date, $resolution) {
		
		$resultData = array();
		
		$stmt = $this->m_db->stmt_init();
		$sql = BodyweightTbl::STMT_GRAPH_DATA_START;
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('is', $user_id, $date);			
			$stmt->execute();
			
			$values = array();
			$stmt->bind_result(
				$values[BodyweightColumns::_ID],
				$values[BodyweightColumns::U_ID],
				$values[BodyweightColumns::ADDED_ON],
				$values[BodyweightColumns::WEIGHT],
				$values[BodyweightColumns::UNIT]);
				
			$result = $stmt->get_result();	
			if ($row = $result->fetch_assoc()) {
				
				$resultData["start"] = $row;
			} else $resultData["start"] = "none";									
			$stmt->close();
								
		}; 	
		
		
		$stmt = $this->m_db->stmt_init();
		
		switch ($resolution) {
			
			case "tag":
				
				$sql = BodyweightTbl::STMT_GRAPH_DATA_TO_VIEW_D;
				break;
				
			case "woche":
				
				$sql = BodyweightTbl::STMT_GRAPH_DATA_TO_VIEW_W;
				break;
				
			case "monat":
				
				$sql = BodyweightTbl::STMT_GRAPH_DATA_TO_VIEW_M;
				break;
		}		
		
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('iss', $user_id, $date, $date);
			$stmt->execute();
						
			$values = array();
			$stmt->bind_result(
				$values[BodyweightColumns::_ID],
				$values[BodyweightColumns::U_ID],
				$values[BodyweightColumns::ADDED_ON],
				$values[BodyweightColumns::WEIGHT],
				$values[BodyweightColumns::UNIT]);
					
			$result = $stmt->get_result();			
			$resultData["data"] = array();
			$confirmed = false;
			while ($row = $result->fetch_assoc()) {
				
				array_push($resultData["data"], $row);
				$confirmed = true;
			}						
			if (!$confirmed) $resultData["data"] = "none"; 		
			$stmt->close();
							
		}
		
				
		$stmt = $this->m_db->stmt_init();
		$sql = BodyweightTbl::STMT_GRAPH_DATA_END;
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('is', $user_id, $date);
			$stmt->execute();
				
			$values = array();
			$stmt->bind_result(
				$values[BodyweightColumns::_ID],
				$values[BodyweightColumns::U_ID],
				$values[BodyweightColumns::ADDED_ON],
				$values[BodyweightColumns::WEIGHT],
				$values[BodyweightColumns::UNIT]);
			
			$result = $stmt->get_result();
			if ($row = $result->fetch_assoc()) {
								
				$resultData["end"] = $row;
			} else $resultData["end"] = "none";	
			$stmt->close();
			return $resultData;	
					
		}return null;	
	}
	

	public function getGraphDataKCAL_KG($user_id, $date, $resolution) {
		
		$resultData = array();
		
		
		$resultData["start"] = "none";
		
		$stmt = $this->m_db->stmt_init();
		
		switch ($resolution) {
			
			case "tag":
				
				$sql = MealenergyTbl::STMT_GRAPH_DATA_TO_VIEW_D;
				break;
				
			case "woche":
				
				$sql = MealenergyTbl::STMT_GRAPH_DATA_TO_VIEW_W;
				break;
				
			case "monat":
				
				$sql = MealenergyTbl::STMT_GRAPH_DATA_TO_VIEW_M;
				break;
		}		
		
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('iss', $user_id, $date, $date);
			$stmt->execute();
						
			$values = array();
			$stmt->bind_result(
				$values[MealenergyColumns::_ID],
				$values[MealenergyColumns::U_ID],
				$values[MealenergyColumns::ADDED_ON]);
					
			$result = $stmt->get_result();			
			$resultData["data"] = array();
			$confirmed = false;
			while ($row = $result->fetch_assoc()) {
				
				$kcal = new MealenergyDto();
				$kcal->array_init($row);
				array_push($resultData["data"], $kcal);
				$confirmed = true;
			}			
			if (!$confirmed) $resultData["data"] = "none";					
			$stmt->close();
							
		}; 	
		
				
		$stmt = $this->m_db->stmt_init();
		$sql = MealenergyTbl::STMT_GRAPH_DATA_END;
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('is', $user_id, $date);
			$stmt->execute();
				
			$values = array();
			$stmt->bind_result(
				$values[MealenergyColumns::_ID],
				$values[MealenergyColumns::U_ID],
				$values[MealenergyColumns::ADDED_ON]);
			
			$result = $stmt->get_result();
			if ($row = $result->fetch_assoc()) {
								
				$kcal = new MealenergyDto();
				$kcal->array_init($row);
				$resultData["end"] = $kcal;
			} else $resultData["end"] = "none";
			$stmt->close();
			return $resultData;	
					
		}return null;	
	}
	
	
	public function getMealEnergySum($meal_id) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = MealenergyContentTbl::STMT_GET_MEALENERGY_SUM;
		if ($stmt->prepare($sql)) {
						
			$stmt->bind_param('i', $meal_id);
			$stmt->execute();
							
			$stmt->bind_result($energySum);
				
			$result = $stmt->get_result();	
			if ($row = $result->fetch_assoc()) {
				
				$stmt->close();
				return $row;
			} else return "none";			
		}
	}
		
	
	public function getMealContent($user_id, $datum, $resolution) {
		
		$resultData = array();
		
		
		$stmt = $this->m_db->stmt_init();
		
		switch ($resolution) {
			
			case "tag":
				
				$sql = MealenergyTbl::STMT_MEAL_CONTENT_D;
				break;
				
			case "woche":
				
				$sql = MealenergyTbl::STMT_MEAL_CONTENT_W;
				break;
				
			case "monat":
				
				$sql = MealenergyTbl::STMT_MEAL_CONTENT_M;
				break;
		}		
		
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('iss', $user_id, $datum, $datum);
			$stmt->execute();
						
			$values = array();
			$stmt->bind_result(
				$values["barcode"],
				$values["added_on"],
				$values["energie_kcal"],
				$values["weight"]);
					
			$result = $stmt->get_result();									
			$resultData["mealcontent"] = array();
			$confirmed = false;	
			while ($row = $result->fetch_assoc()) {
												
				$mealcontent = new MealcontentDTO();
				$mealcontent->array_init($row);
				array_push($resultData["mealcontent"], $mealcontent);
				$confirmed = true;
			}		
					
			if (!$confirmed) $resultData["mealcontent"] = "none";					
			$stmt->close();
			return $resultData; 					
		}	
		
		return null;	
	}
	
		
	public function productData($ean) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = FoodTbl::STMT_PRODUCT_DATA;
		if ($stmt->prepare($sql)) {
			
			$stmt->bind_param('s', $ean);
			$stmt->execute();
				
			$values = array();
			$stmt->bind_result( 
				$values[FoodColumns::MARKENNAME], 
				$values[FoodColumns::PRODUKT], 
				$values[FoodColumns::EAN],
				$values[FoodColumns::MENGE]);
					
			if ($stmt->fetch()) {
				
				$stmt->close();
			
				return new FoodDto($values);
			} else $stmt->close();				
		}		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	// android_rest

	public function emailInUse($email) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = UserTbl::STMT_EMAIL_IN_USE;
		if ($stmt->prepare($sql)) {
		
			$stmt->bind_param('s', $email);
			$stmt->execute();	
			$stmt->bind_result($count);
			$stmt->fetch();
			$stmt->close();
			return $count;
			
		} return -1;	
	}
	
	
	public function registerNewUser(UserDto $user) {
			
		$stmt = $this->m_db->stmt_init();
		$sql = UserTbl::STMT_REGISTER_NEW_USER;
		if ($stmt->prepare($sql)) {
			
			$vorname 	= $user->getVorname();
			$nachname 	= $user->getNachname();
			$email 		= $user->getEmail();
			$password 	= $user->getPassword();
			
			$stmt->bind_param('ssss', $vorname, $nachname, $email, $password);
			return $stmt->execute();
		}		
	 	
	}
	
	
	public function getUserByEmail($email) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = UserTbl::STMT_GET_USER_BY_EMAIL;
		if ($stmt->prepare($sql)) {
		
			$stmt->bind_param('s', $email);
			if ($stmt->execute()) {
				
				
				$values = array();
				$stmt->bind_result(
					$values[UserColumns::_ID], 
					$values[UserColumns::VORNAME], 
					$values[UserColumns::NACHNAME], 
					$values[UserColumns::EMAIL],
					$values[UserColumns::PASSWORD]);
				
				if ($stmt->fetch()) {
					
					$stmt->close();
					return new UserDto();
				}
			}			
		} return null;	
	}
	
	
	public function currentTageseinheiten(UserDto $user) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = TageseinheitenTbl::STMT_CURRENT_TAGESLIMIT;
		if ($stmt->prepare($sql)) {
			
			$email 		= $user->getEmail();
			
			$stmt->bind_param('s', $email);
			$stmt->execute();
				
			$values = array();
			$stmt->bind_result(
				$values[TageseinheitenColumns::_ID], 
				$values[TageseinheitenColumns::U_ID], 
				$values[TageseinheitenColumns::ADDED_ON], 
				$values[TageseinheitenColumns::TAGESEINHEITEN]);
					
			if ($stmt->fetch()) {
				
				$stmt->close();
			
				return new TageseinheitenDto($values);
			} else $stmt->close();				
		}		
	}
	
	
	// public function productData($ean) {
// 		
		// $stmt = $this->m_db->stmt_init();
		// $sql = FoodTbl::STMT_PRODUCT_DATA;
		// if ($stmt->prepare($sql)) {
// 			
			// $stmt->bind_param('s', $ean);
			// $stmt->execute();
// 				
			// $values = array();
			// $stmt->bind_result( 
				// $values[FoodColumns::MARKENNAME], 
				// $values[FoodColumns::PRODUKT], 
				// $values[FoodColumns::EAN],
				// $values[FoodColumns::MENGE]);
// 					
			// if ($stmt->fetch()) {
// 				
				// $stmt->close();
// 			
				// return new FoodDto($values);
			// } else $stmt->close();				
		// }		
// 		
	// }
	
		
	public function synchronizeBodyweight(UserDto $user, $payload) {
		
		
		$this->m_db->autocommit(FALSE);	
		foreach ($payload as $index => $bodyweight) {
			
			$bw = new BodyweightDto();
			$bw->json_init($user, $bodyweight);
			$result = $this->insertBodyweight($bw);
			if ($result == -1) {
				
				$this->m_db->rollback();
				break 1;
			}
		}
		return $this->m_db->commit();
	}
	
	
	public function synchronizeBloodpressure(UserDto $user, $payload) {
		
		
		$this->m_db->autocommit(FALSE);	
		foreach ($payload as $index => $bodyweight) {
			
			$bp = new BloodpressureDto();
			$bp->json_init($user, $bodyweight);
			$result = $this->insertBloodpressure($bp);
			if ($result == -1) {
				
				$this->m_db->rollback();
				break 1;
			}
		}
		return $this->m_db->commit();
	}
	
	
	public function synchronizeMealenergy(UserDto $user, $payload) {
		
		
		$this->m_db->autocommit(FALSE);	
		
		$mealAr 	= $payload[0];
		$contentAr 	= $payload[1];
		
		$sync			= array();
		$meal_ids		= array();
		$content_ids 	= array();
		
		foreach ($mealAr as $index => $meal) {
			
			$me = new MealenergyDto();
			$me->json_init($user, $meal);
			
			$result = $this->insertMealenergy($me);
			if ($result != -1) {
				
				$me->m_id = $result;
				
				array_push($meal_ids, $meal[MealenergyColumns::_ID]);
				foreach ($contentAr[$index] as $mealContent) {
					
					$mec = new MealenergyContentDto();
					$mec->json_init($me, $mealContent);
					
					$result = $this->insertMealenergyContent($mec);
					if ($result != -1) {						
						
						array_push($content_ids, $mealContent[MealenergyContentColumns::_ID]);
		
					} else {
						
						$this->m_db->rollback();
					}
				}
				// $this->m_db->rollback()
				// break 1;
			} else {
				
				$this->m_db->rollback();
			}
		}
		
		$this->m_db->commit();
		
		$sync["meal"] = $meal_ids;
		$sync["content"] = $content_ids;
		return $sync;		
	}
	
	
	public function insertBodyweight(BodyweightDto $bw) {
		
		$stmt = mysqli_stmt_init($this->m_db);
		$sql = BodyweightTbl::STMT_INSERT_BODYWEIGHT;
		
		if ($stmt->prepare($sql)) {
			
			$u_id 		= $bw->getUserID();
			$date 		= new DateTime($bw->getAddedOn());
			$added_on 	= $date->format('Y-m-d H:i:s');
			$weight		= $bw->getWeight();
			$unit		= $bw->getUnit();
			
			$stmt->bind_param('isss', $u_id, $added_on, $weight, $unit);
			$stmt->execute();
			
			$stmt->close();
			return $this->m_db->insert_id;
			
		} else {
			
			return -1;
		}
		
	}
		
	
	public function insertBloodpressure(BloodpressureDto $bp) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = BloodpressureTbl::STMT_INSERT_BLOODPRESSURE;		
		if ($stmt->prepare($sql)) {			
			
			$u_id 		= $bp->getUserID();
			$date		= new DateTime($bp->getAddedOn());
			$added_on 	= $date->format('Y-m-d H:i:s');
			$diastolic	= $bp->getDiastolic();
			$systolic 	= $bp->getSystolic();
			$pulse 		= $bp->getPulse();
			
			$stmt->bind_param('issss', $u_id, $added_on, $diastolic, $systolic, $pulse);			
			$stmt->execute();
			
			$stmt->close();
			return $this->m_db->insert_id;
		} else {
			
			return -1;
		}
	}
	
	
	public function insertMealenergy(MealenergyDto $me) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = MealenergyTbl::STMT_INSERT_MEALENERGY;		
		if ($stmt->prepare($sql)) {			
			
			$u_id 		= $me->getUserID();
			$date		= new DateTime($me->getAddedOn());
			$added_on 	= $date->format('Y-m-d H:i:s');
						
			$stmt->bind_param('is', $u_id, $added_on);			
			$stmt->execute();
						
			$stmt->close();
			return $this->m_db->insert_id;;
		} else {
			
			return -1;
		}
	}
	
	
	public function insertMealenergyContent(MealenergyContentDto $mec) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = MealenergyContentTbl::STMT_INSERT_MEALENERGY_CONTENT;		
		if ($stmt->prepare($sql)) {			
			
			$meal_id 		= $mec->getMealID();
			$barcode		= $mec->getBarcode();
			$energie_kcal 	= $mec->getEnergieKcal();
			$weight			= $mec->getWeight();
						
			$stmt->bind_param('isis', $meal_id, $barcode, $energie_kcal, $weight);			
			$stmt->execute();
			
			$stmt->close();
			return $this->m_db->insert_id;
		} else {
			
			return -1;
		}
	}
	
	
	
	
}
?>

