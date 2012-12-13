<?php
	class API { 
		private $url, $type, $curl; 
		private $data = array(), $reply; 

		function __construct($url, $data = "", $type = "POST") {
			if ($data != "") { 
				$this->data = $this->FormatData($data); 
			}
			$this->url      = $url; 
			$this->type     = strtoupper($type); 			
			$this->curl	= curl_init($this->url); 
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



		function SetOpt($opt, $value) { 
			curl_setopt($this->curl, $opt, $value); 
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
			//die(var_dump($this->reply)); 
			$decode = json_decode($this->reply);
			if ($decode != NULL) 
				return $decode;
			else {  
				if (is_object($decode)) 
					return (array) $decode; 

				// if we haven't returned by now, it's a string, that might be spliced by &'s
				// we can make an assoc array out of that, just like our data. 
	                        $da = explode("&", $this->reply);
				foreach ($da as $data) { 
					$data = explode("=", $data); 
					$da[$data[0]] = $data[1]; 
				}
				return $da; 
			} 
		}
	}		
?>