<?php

class WunschgewichtDto {
		
		
	public $m_id;
	public $m_uID;
	public $m_addedOn;
	public $m_wunschgewicht;
	public $m_unit;
	
	
	public function __construct($post) {
		
		$this->m_id 				= $post[WunschgewichtColumns::_ID];
		$this->m_uID 				= $post[WunschgewichtColumns::U_ID];
		$this->m_addedOn 			= $post[WunschgewichtColumns::ADDED_ON];
		$this->m_wunschgewicht 	= $post[WunschgewichtColumns::WUNSCHGEWICHT];
		$this->m_unit				= $post[WunschgewichtColumns::UNIT];
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
	
	
	public function getWunschgewicht() {
		
		return $this->m_wunschgewicht;
	}
	
	
	public function toArray() {
		
		$result = array();
		$result[WunschgewichtColumns::_ID] = $this->m_id;
		$result[WunschgewichtColumns::U_ID] = $this->m_uID;
		$result[WunschgewichtColumns::ADDED_ON] = $this->m_addedOn;
		$result[WunschgewichtColumns::WUNSCHGEWICHT] = $this->m_wunschgewicht;	
		$result[WunschgewichtColumns::UNIT] = $this->m_unit;	
		return $result;
	}
	
	
}
?>