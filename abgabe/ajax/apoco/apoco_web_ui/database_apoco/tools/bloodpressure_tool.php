<?php

require_once __DIR__ . '/../dto/bloodpressure_dto.php';

class Bloodpressure {
		
	const OPTIMAL = 0; 
	const NORMAL = 1;
	const HOCHNORMAL = 2;
	const HYPERTONIE_GRAD1 = 3;
	const HYPERTONIE_GRAD2 = 4;
	const HYPERTONIE_GRAD3 = 5;
	const ISOLIERTE_SYSTOLISCHE_HYPERTONIE = 6;
}

class BlutdruckAnalyse {
	
	private $sys_average;
	private $dia_average;
	private $pulse_average;
	private $systolic;
	private $diastolic;
	private $isReady = false;
	
	public function average($bloodpressure) {
		
		$dia = 0;
		$sys = 0;
		$pls = 0;
		
		foreach ($bloodpressure as $key => $value) {
			
			$dia += $value->getDiastolic();
			$sys += $value->getSystolic();
			$pls += $value->getPulse();
		}
		
		$this->dia_average = $dia / sizeof($bloodpressure);
		$this->sys_average = $sys / sizeof($bloodpressure);
		$this->pulse_average = $pls / sizeof($bloodpressure);
		$this->analyse();
	}
	
	
	public function analyse() {
		
		if ($this->dia_average < 80) {
			
			$this->diastolic = Bloodpressure::OPTIMAL;
		} else if ($this->dia_average < 85) {
			
			$this->diastolic = Bloodpressure::NORMAL;
		} else if ($this->dia_average < 90) {
			
			$this->diastolic = Bloodpressure::HOCHNORMAL;
		} else if ($this->dia_average < 100) {
			
			$this->diastolic = Bloodpressure::HYPERTONIE_GRAD1;
		} else if ($this->dia_average < 110) {
			
			$this->diastolic = Bloodpressure::HYPERTONIE_GRAD2;
		} else if ($this->dia_average >= 110) {
			
			$this->diastolic = Bloodpressure::HYPERTONIE_GRAD3;
		}
		
		
		if ($this->sys_average < 120) {
			
			$this->systolic = Bloodpressure::OPTIMAL;
		} else if ($this->sys_average < 130) {
			
			$this->systolic = Bloodpressure::NORMAL;
		} else if ($this->sys_average < 140) {
			
			$this->systolic = Bloodpressure::HOCHNORMAL;
		} else if ($this->sys_average >= 140 && $this->dia_average < 90) {
			
			$this->systolic = Bloodpressure::ISOLIERTE_SYSTOLISCHE_HYPERTONIE;
		} else if ($this->sys_average < 160) {
			
			$this->systolic = Bloodpressure::HYPERTONIE_GRAD1;
		} else if ($this->sys_average < 180) {
			
			$this->systolic = Bloodpressure::HYPERTONIE_GRAD2;
		} else if ($this->sys_average >= 180) {
			
			$this->systolic = Bloodpressure::HYPERTONIE_GRAD3;
		}
		
		$this->isReady = true;
	}


	public function getSysAverage() {
		
		if ($this->isReady) return $this->sys_average;
	}
	
	
	public function getDiaAverage() {
		
		if ($this->isReady) return $this->dia_average;
	}
	
	
	public function getSystolic() {
		
		if ($this->isReady) return $this->systolic;
	}
	
	
	public function getDiastolic() {
		
		if ($this->isReady) return $this->diastolic;
	}
	
	public function toArray() {
		
		$result = array();
		$result["systolic_avg"] = $this->sys_average;
		$result["diastolic_avg"] = $this->dia_average;
		$result["pulse_avg"] = $this->pulse_average;
		$result["systolic"] = $this->systolic;
		$result["diastolic"] = $this->diastolic;
		
		if ($this->isReady) return $result;
	}
	
	
	public function analyseToString($systolicl) {
		
		switch ($systolic) {
			
			case 0:
				
				return "optimal";
				break;
			case 1:
				
				return "normal";
				break;
			case 2:
				
				return "hochnormal";
				break;
			case 3:
				
				return "hypertonie grad 1";
				break;
			case 4:
				
				return "hypertonie grad 2";
				break;
			case 5:
				
				return "hypertonie grad 3";
				break;
			case 6:
				
				return "isolierte systolische hypertonie";
				break;
		}
	}
}

?>