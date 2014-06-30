


<?php

class UserDto {
		
	public $m_id;
	public $m_vorname;
	public $m_nachname;
	public $m_email;
	public $m_password;
	
	
	public function __construct() {}
	
	
	public function array_init($values) {
		
		$this->m_id = $values[UserColumns::_ID];
		$this->m_vorname = $values[UserColumns::VORNAME];
		$this->m_nachname = $values[UserColumns::NACHNAME];
		$this->m_email = $values[UserColumns::EMAIL];
		$this->m_password = $values[UserColumns::PASSWORD];
	}
	
	
	public function json_init() {
		
	}
	
	
	public function mysqli_result_init($result) {
		
		$this->m_id 		= $result->_id;
		$this->m_vorname 	= $result->vorname;
		$this->m_nachname 	= $result->nachname;
		$this->m_email 		= $result->email;
		$this->m_password 	= $result->password;
	}
	
	
	public function getID() {
		
		return $this->m_id;
	}
	
	
	public function getVorname() {
		
		return $this->m_vorname;
	}
	
	
	public function getNachname() {
		
		return $this->m_nachname;
	}
	
	
	public function getEmail() {
		
		return $this->m_email;
	}
	
	
	public function getPassword() {
		
		return $this->m_password;
	}
	
	
	public function toArray() {
		
		$result = array();
		$result[UserColumns::_ID] = $this->m_id;
		$result[UserColumns::VORNAME] = $this->m_vorname;	
		$result[UserColumns::NACHNAME] = $this->m_nachname;
		$result[UserColumns::EMAIL] = $this->m_email;
		$result[UserColumns::PASSWORD] = $this->m_password;
		return $result;
	}
	
	
	
}
?>