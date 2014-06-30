

<?php


class MealcontentDTO {
	
	
	public $barcode;
	public $added_on;
	public $energie_kcal;
	public $weight;
	
	
	public function __construct() {}
	
	
	public function json_init() {}
	
	
	public function array_init($array) {
		
		$this->barcode = $array["barcode"];
		$this->added_on = $array["added_on"];
		$this->energie_kcal = $array["energie_kcal"];
		$this->weight = $array["weight"];
	}
	
	
	public function mysqli_result_init($result) {}
	
	
	public function toArray() {
		
		$result = array();
		$result["barcode"] = $this->barcode;
		$result["added_on"] = $this->added_on;
		$result["kcal"] = $this->energie_kcal;
		$result["weight"] = $this->weight;
		return $result;
	}
}


?>