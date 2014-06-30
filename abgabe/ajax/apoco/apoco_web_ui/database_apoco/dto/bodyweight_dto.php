


<?php

class BodyweightDto {
		
		
	public $m_id;
	public $m_uID;
	public $m_addedOn;
	public $m_weight;
	public $m_unit;
	
	
	public function __construct() {}
	
	
	public function json_init(UserDto $user, $payload) {
		
		
		$this->m_uID 		= $user->m_id;
		$this->m_addedOn 	= $payload[BodyweightColumns::ADDED_ON];
		$this->m_weight 	= $payload[BodyweightColumns::WEIGHT];
		$this->m_unit 		= $payload[BodyweightColumns::UNIT];
	}
	
	
	public function array_init($array) {
				
		$this->m_id 		= $array[BodyweightColumns::_ID];
		$this->m_uID	 	= $array[BodyweightColumns::U_ID];
		$this->m_addedOn	= $array[BodyweightColumns::ADDED_ON];
		$this->m_weight 	= $array[BodyweightColumns::WEIGHT];
		$this->m_unit	 	= $array[BodyweightColumns::UNIT];
	}
	
	
	public function mysqli_result_init($result) {
		
		$this->m_id = $result->id;
		$this->m_uID = $result->u_id;
		$this->m_added_on = $result->added_on;
		$this->m_weight = $result->weight;
		$this->m_unit = $result->unit;
	}
	
	
	
	public function getID() {
		
		return $this->m_id;
	}
	
	
	public function getUserID() {
		
		return $this->m_uID;
	}
	
	
	public function getAddedOn() {
		
		return $this->m_addedOn;
	}
	
	
	public function getWeight() {
		
		return $this->m_weight;
	}
	
	
	public function getUnit() {
		
		return $this->m_unit;
	}
	
	
	public function toArray() {
		
		$result = array();
		$result[BodyweightColumns::_ID] = $this->m_id;
		$result[BodyweightColumns::U_ID] = $this->m_uID;	
		$result[BodyweightColumns::ADDED_ON] = $this->m_addedOn;
		$result[BodyweightColumns::WEIGHT] = $this->m_weight;
		$result[BodyweightColumns::UNIT] = $this->m_unit;
		return $result;
	}
	
		
}
?>