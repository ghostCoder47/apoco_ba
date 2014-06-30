<?php

class TageseinheitenDto {
		
		
	public $m_id;
	public $m_uID;
	public $m_addedOn;
	public $m_tageseinheiten;
	
	
	public function __construct() {}
	
	
	public function json_init() {}
	
	
	public function array_init($values) {
		
		$this->m_id 				= $values[TageseinheitenColumns::_ID];
		$this->m_uID 				= $values[TageseinheitenColumns::U_ID];
		$this->m_addedOn 			= $values[TageseinheitenColumns::ADDED_ON];
		$this->m_tageseinheiten 	= $values[TageseinheitenColumns::TAGESEINHEITEN];
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
	
	
	public function getTageseinheiten() {
		
		return $this->m_tageseinheiten;
	}
	
	
	public function toArray() {
		
		$result = array();
		$result[TageseinheitenColumns::_ID] = $this->m_id;
		$result[TageseinheitenColumns::U_ID] = $this->m_uID;
		$result[TageseinheitenColumns::ADDED_ON] = $this->m_addedOn;
		$result[TageseinheitenColumns::TAGESEINHEITEN] = $this->m_tageseinheiten;		
		return $result;
	}
	
	
}
?>