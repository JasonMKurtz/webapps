<?php
	class API { 
		private $url, $type, $curl, $curlopts, $datatype; 
		private $data = array(), $reply; 

		// receiveData signifies the type of data that will be returned. 
		// 0 = associative array, 1 = object
		function __construct($url, $receiveData = 1, $data = "", $type = "POST") {
			if ($data != "") { 
				$this->data = $this->FormatData($data); 
			}
			$this->url      = $url; 
			$this->type     = strtoupper($type); 			
			$this->curl	= curl_init($this->url); 
			$this->curlopts = array(); 
			$this->datatype = $receiveData; 
			return $this;
		}

		// takes in the data as a string, returns an associative array, separated by &
		private function FormatData($data) { 
			$da = explode("&", $data);
			if (count($da) <= 1)
				return $da; 
			foreach ($da as $data) {
				$data = explode("=", $data);
				$da[$data[0]] = $data[1];
			}
			return $da; 
		}



		function SetOpt() {
			$args = func_get_args();  
			if (!isset($args[1]) && !is_array($args[0])) 
				return; 

			if (is_array($args[0])) {
				foreach ($args[0] as $key => $value) {
					$lkey = floatval($key); 
					if (!isset($this->curlopts[$key])) {
						curl_setopt($this->curl, $lkey, $value); 
						$this->curlopts[$key] = $value; 
					}
				}
			} else {
				if (!isset($this->curlopts[$args[0]])) {
					$larg0 = floatval($args[0]); 
					curl_setopt($this->curl, $larg0, $args[1]);
					$this->curlopts[$args[0]] = $args[1]; 
				} 
			} 
		}

		function GetOpts() { 
			return $this->curlopts; 
		}			 

		function Send($data = "") { 
			if ($this->data == "") {
				if ($data != "") 
					$this->data = $this->FormatData($data); 
				else
					return "DATA-1"; 
			}
			$this->SetOpt(CURLOPT_URL, $this->url); 
			$this->SetOpt(CURLOPT_RETURNTRANSFER, true);
			$this->SetOpt(CURLOPT_CUSTOMREQUEST, $this->type);
	                $this->SetOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        	        $this->SetOpt(CURLOPT_SSL_VERIFYHOST, FALSE);

			$this->SetOpt(CURLOPT_POSTFIELDS,http_build_query($this->data));
			$this->reply = curl_exec($this->curl);
			return $this->Get(); 
		}

		function Get() { 
			if (!isset($this->reply) || $this->reply == "")
				return "REPLY-1"; 
			$decode = json_decode($this->reply);
			if ($decode != NULL) 
				return $decode;
			else {  
				if (is_object($decode)) 
					return ($this->datatype == 1 ? $decode : (array) $decode); 

				// if we haven't returned by now, it's a string, that might be spliced by &'s
				// we can make an assoc array out of that, just like our data. 
	                        $da = explode("&", $this->reply);
				foreach ($da as $data) { 
					$data = explode("=", $data); 
					$da[$data[0]] = $data[1]; 
				}
				return ($this->datatype == 1 ? (object) $da : $da); 
			} 
		}
	}		
?>