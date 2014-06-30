


<?php

class FoodDto {
		
		
	public $m_hersteller;
	public $m_markenname;
	public $m_produkt;
	public $m_gluten;
	public $m_lactose;
	public $m_krebstiere;
	public $m_eierprodukte;
	public $m_fisch;
	public $m_erdnuesse;
	public $m_soja;
	public $m_milch;
	public $m_nuesse;
	public $m_sellerie;
	public $m_senf;
	public $m_sesam;
	public $m_schwefeldioxid;
	public $m_basis_energie;
	public $m_basiseinheit_energie;
	public $m_zutaten;
	public $m_bild;
	public $m_EAN;
	public $m_kann_gluten;
	public $m_kann_lactose;
	public $m_kann_krebstiere;
	public $m_kann_eierprodukte;
	public $m_kann_fisch;
	public $m_kann_erdnuesse;
	public $m_kann_soja;
	public $m_kann_milch;
	public $m_kann_nuesse;
	public $m_kann_sellerie;
	public $m_kann_senf;
	public $m_kann_sesam;
	public $m_kann_schwefeldioxid;
	public $m_inhaltsstoff;
	public $m_menge;
	public $m_masseinheit;
	
	
	public function __construct(&$post) {
		
		// $this->m_hersteller 			= $post[FoodColumns::HERSTELLER];
		$this->m_markenname 			= $post[FoodColumns::MARKENNAME];
		$this->m_produkt 				= $post[FoodColumns::PRODUKT];
		// $this->m_gluten 				= $post[FoodColumns::GLUTEN];
	 	// $this->m_lactose 				= $post[FoodColumns::LACTOSE];
	 	// $this->m_krebstiere 			= $post[FoodColumns::KREBSTIERE];
	 	// $this->m_eierprodukte 			= $post[FoodColumns::EIERPRODUKTE];
	 	// $this->m_fisch 					= $post[FoodColumns::FISCH];
	 	// $this->m_erdnuesse 				= $post[FoodColumns::ERDNUESSE];
	 	// $this->m_soja 					= $post[FoodColumns::SOJA];
	 	// $this->m_milch 					= $post[FoodColumns::MILCH];
	 	// $this->m_nuesse 				= $post[FoodColumns::NUESSE];
	 	// $this->m_sellerie 				= $post[FoodColumns::SELLERIE];
	 	// $this->m_senf 					= $post[FoodColumns::_ID];
	 	// $this->m_sesam 					= $post[FoodColumns::_ID];
	 	// $this->m_schwefeldioxid 		= $post[FoodColumns::_ID];
	 	// $this->m_basis_energie 			= $post[FoodColumns::_ID];
	 	// $this->m_basiseinheit_energie 	= $post[FoodColumns::_ID];
	 	// $this->m_zutaten 				= $post[FoodColumns::_ID];
	 	// $this->m_bild 					= $post[FoodColumns::_ID];
	 	$this->m_EAN 					= $post[FoodColumns::EAN];
	 	// $this->m_kann_gluten 			= $post[FoodColumns::_ID];
	 	// $this->m_kann_lactose 			= $post[FoodColumns::_ID];
	 	// $this->m_kann_krebstiere 		= $post[FoodColumns::_ID];
	 	// $this->m_kann_eierprodukte 		= $post[FoodColumns::_ID];
	 	// $this->m_kann_fisch 			= $post[FoodColumns::_ID];
	 	// $this->m_kann_erdnuesse 		= $post[FoodColumns::_ID];
	 	// $this->m_kann_soja 				= $post[FoodColumns::_ID];
	 	// $this->m_kann_milch 			= $post[FoodColumns::_ID];
	 	// $this->m_kann_nuesse 			= $post[FoodColumns::_ID];
	 	// $this->m_kann_sellerie 			= $post[FoodColumns::_ID];
	 	// $this->m_kann_senf 				= $post[FoodColumns::_ID];
	 	// $this->m_kann_sesam 			= $post[FoodColumns::_ID];
	 	// $this->m_kann_schwefeldioxid 	= $post[FoodColumns::_ID];
	 	// $this->m_inhaltsstoff 			= $post[FoodColumns::_ID];
	 	$this->m_menge 					= $post[FoodColumns::MENGE];
	 	// $this->m_masseinheit 			= $post[FoodColumns::_ID];
	}
	
	
	public function getMarkenname() {
		
		return $this->m_markenname;
	}
	
	
	public function getProdukt() {
		
		return $this->m_produkt;
	}
	
	
	public function getBarcode() {
		
		return $this->m_EAN;
	}
	
	
	public function getEnergie() {
		
		return $this->m_menge;
	}
	
	
	public function toArray() {
		
				
		$result = array();
		$result[FoodTbl::MARKENNAME] 	= utf8_encode($this->m_markenname);
		$result[FoodTbl::PRODUKT] 		= utf8_encode($this->m_produkt);
		$result[FoodTbl::EAN] 			= $this->m_EAN;		
		
		$tokens = explode("/", $this->m_menge);		
		
		$result[FoodTbl::MENGE] 		= $tokens[1];		
		return $result;
	}
	
	
	
}
?>