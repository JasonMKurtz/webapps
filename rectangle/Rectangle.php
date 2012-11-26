<?php
	class Rectangle { 
		private $width, $height; 
	
		function __construct($width, $height) { 
			$this->width  = $width; 
			$this->height = $height; 
		}

		function CalcArea() { 
			return $this->width * $this->height; 
		}

		function CalcDiagonal() { 
			$a = $this->width  * $this->width; 
			$b = $this->height * $this->height; 
			$c = $a + $b; 
			return sqrt($c); 
		} 
	}
?>