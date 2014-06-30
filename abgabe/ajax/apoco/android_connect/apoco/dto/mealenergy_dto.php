<?php

class MealenergyDto {
		
		
	public $m_id;
	public $m_uID;
	public $m_addedOn;
	
	
	public function __construct() {}
	
	
	public function getID() {
		
		return $this->m_id;
	}
	
	
	public function getUserID() {
		
		return $this->m_uID;
	}
	
	
	public function getAddedOn() {
		
		return $this->m_addedOn;
	}
	
	
	public function json_init(UserDto $user, $meal) {		
		
		$this->m_uID 		= $user->getID();
		$this->m_addedOn	= $meal[BloodpressureColumns::ADDED_ON];		
	}
	
		
}
?>