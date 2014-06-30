
<?php

class WunschgewichtDTO {
	
	public $_id;
	public $u_id;
	public $added_on;
	public $wunshcgewicht;
	public $unit;

	
	public function __construct() {}
	
	
	public function array_init($array) {
		
		$this->_id 				= $array[WunschgewichtColumns::_ID];		
		$this->u_id 			= $array[WunschgewichtColumns::U_ID];
		$this->added_on 		= $array[WunschgewichtColumns::ADDED_ON];
		$this->wunschgewicht 	= $array[WunschgewichtColumns::WUNSCHGEWICHT];
		$this->unit			 	= $array[WunschgewichtColumns::UNIT];
	}
	
	
	public function json_init() {
		
	}
	
	
	public function mysqli_result_init($result) {
		
		$this->_id 				= $result->_id;
		$this->u_id 			= $result->u_id;
		$this->added_on 		= $result->added_on;
		$this->wunschgewicht 	= $result->wunschgewicht;
		$this->unit			 	= $result->unit;
	}
	
	
	public function toArray() {
		
		$result = array();
		$result[WunschgewichtColumns::_ID] 				= $this->_id;
		$result[WunschgewichtColumns::U_ID] 			= $this->u_id;	
		$result[WunschgewichtColumns::ADDED_ON] 		= $this->added_on;
		$result[WunschgewichtColumns::WUNSCHGEWICHT] 	= $this->wunschgewicht;	
		$result[WunschgewichtColumns::UNIT			] 	= $this->unit;		
		return $result;
	}
	
}


?>