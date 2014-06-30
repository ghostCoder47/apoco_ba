


<?php

class BloodpressureDto {
		
		
	public $m_id;
	public $m_uID;
	public $m_addedOn;
	public $m_diastolic;
	public $m_systolic;
	public $m_pulse;
	
	
	public function __construct() {}
	
	
	public function json_init(UserDto $user, $payload) {
		
		
		$this->m_uID 		= $user->m_id;
		$this->m_addedOn 	= $payload[BloodpressureColumns::ADDED_ON];
		$this->m_diastolic	= $payload[BloodpressureColumns::DIASTOLIC];
		$this->m_systolic	= $payload[BloodpressureColumns::SYSTOLIC];
		$this->m_pulse		= $payload[BloodpressureColumns::PULSE];
	}
	
	
	public  function array_init($array) {
		
		$this->m_id			= $array[BloodpressureColumns::_ID];
		$this->m_uID 		= $array[BloodpressureColumns::U_ID];
		$this->m_addedOn 	= $array[BloodpressureColumns::ADDED_ON];
		$this->m_diastolic	= $array[BloodpressureColumns::DIASTOLIC];
		$this->m_systolic	= $array[BloodpressureColumns::SYSTOLIC];
		$this->m_pulse		= $array[BloodpressureColumns::PULSE];
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
	
	
	public function getDiastolic() {
		
		return $this->m_diastolic;
	}
	
	
	public function getSystolic() {
		
		return $this->m_systolic;
	}
	
		
	public function getPulse() {
		
		return $this->m_pulse;
	}
	
		
}
?>