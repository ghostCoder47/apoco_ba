


<?php

require_once __DIR__ . '/tbl/user_tbl.php';
require_once __DIR__ . '/tbl/tageseinheiten_tbl.php';
require_once __DIR__ . '/tbl/food_tbl.php';
require_once __DIR__ . '/tbl/bodyweight_tbl.php';
require_once __DIR__ . '/tbl/bloodpressure_tbl.php';
require_once __DIR__ . '/tbl/mealenergy_tbl.php';
require_once __DIR__ . '/tbl/mealenergy_content_tbl.php';
require_once __DIR__ . '/tbl/wunschgewicht_tbl.php';
require_once __DIR__ . '/dto/food_dto.php';
require_once __DIR__ . '/dto/bodyweight_dto.php';
require_once __DIR__ . '/dto/bloodpressure_dto.php';
require_once __DIR__ . '/dto/mealenergy_dto.php';
require_once __DIR__ . '/dto/mealenergy_content_dto.php';
require_once __DIR__ . '/dto/wunschgewicht_dto.php';

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
					return new UserDto($values);
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
	
	
	public function currentWunschgewicht(UserDto $user) {
		
		$stmt = $this->m_db->stmt_init();
		$sql = WunschgewichtTbl::STMT_CURRENT_WUNSCHGEWICHT;
		if ($stmt->prepare($sql)) {
			
			$email 		= $user->getEmail();
			
			$stmt->bind_param('s', $email);
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
			
				return new WunschgewichtDto($values);
			} else $stmt->close();				
		}		
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

