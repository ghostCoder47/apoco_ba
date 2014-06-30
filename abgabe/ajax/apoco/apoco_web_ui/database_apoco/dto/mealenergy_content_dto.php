

<?php

class MealenergyContentDto {
		
		
	public $m_id;
	public $m_mealID;
	public $m_barcode;
	public $m_energieKcal;
	public $m_weight;
	
	
	public function __construct() {}
	
	
	public function getID() {
		
		return $this->m_id;
	}
	
	
	public function getMealID() {
		
		return $this->m_mealID;
	}
	
	
	public function getBarcode() {
		
		return $this->m_barcode;
	}
	
	
	public function getEnergieKcal() {
		
		return $this->m_energieKcal;
	}
	
	
	public function getWeight() {
		
		return $this->m_weight;
	}
	
	
	public function json_init(MealenergyDto $meal, $mealContent) {		
		
		$this->m_mealID 		= $meal->getID();
		$this->m_barcode		= $mealContent[MealenergyContentColumns::BARCODE];
		$this->m_energieKcal	= $mealContent[MealenergyContentColumns::ENERGIE_KCAL];	
		$this->m_weight			= $mealContent[MealenergyContentColumns::WEIGHT];
				
	}
	
		
}
?>