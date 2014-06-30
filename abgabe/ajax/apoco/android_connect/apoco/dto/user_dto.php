


<?php

class UserDto {
		
	public $m_id;
	public $m_vorname;
	public $m_nachname;
	public $m_email;
	public $m_password;
	
	
	public function __construct(&$post) {
		
		if (isset($post[UserColumns::_ID])) {
			
			$this->m_id = $post[UserColumns::_ID];
		} else $this->m_id = -1;
		$this->m_vorname = $post[UserColumns::VORNAME];
		$this->m_nachname = $post[UserColumns::NACHNAME];
		$this->m_email = $post[UserColumns::EMAIL];
		$this->m_password = $post[UserColumns::PASSWORD];
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
	
	
}
?>