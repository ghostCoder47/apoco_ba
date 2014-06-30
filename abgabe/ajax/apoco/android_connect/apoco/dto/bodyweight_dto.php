


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
	
		
}
?>