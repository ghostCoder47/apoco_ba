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
		$this->m_addedOn	= $meal[MealenergyColumns::ADDED_ON];		
	}
	
	
	public function array_init($values) {
		
		$this->m_id	= $values[MealenergyColumns::_ID];
		$this->m_uID = $values[MealenergyColumns::U_ID];
		$this->m_addedOn = $values[MealenergyColumns::ADDED_ON];
	}
	
	
	public function toArray() {
		
		$result = array();
		$result[MealenergyColumns::_ID]			= $this->m_id;
		$result[MealenergyColumns::U_ID]		= $this->m_uID;
		$result[MealenergyColumns::ADDED_ON]	= $this->m_addedOn;
		return $result;
	}
}
?>