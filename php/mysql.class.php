<?php
	require_once("config.inc.php"); 

	Class MySQL {
			private $username = '', $password = '', $hostname = '', $database = ''; 
			private $query = ''; 
			private $status = 0; 
			private $result = array();  
			private $mysqli; 
			private $query_count = 0;
			private $num_rows;  
			private $table_prefix; 
			private $error; 
			private $last_query; 
			private $Logger; 

			static function &GetInstance() { 
				static $me; 
				if (is_object($me))
					return $me; 
				
				global $config; 
				$me = new MySQL($config['MYSQL_USER'], $config['MYSQL_PASSWORD'], $config['MYSQL_HOST'], $config['MYSQL_DATABASE']); 
				return $me; 
			}

			function __construct($user = "", $pass = "", $host = "", $db = "") {
				global $config; 
				$this->username = ($user != "" ? $user : $config['MYSQL_USER']); 
				$this->password = ($pass != "" ? $pass : $config['MYSQL_PASSWORD']); 
				$this->hostname = ($host != "" ? $host : $config['MYSQL_HOST']); 
				$this->status = 1; 

				if (is_object($this->mysqli)) 
					die("Trying to connect to an already connected socket...\n"); 
			
				$this->mysqli = new mysqli($this->hostname, $this->username, $this->password); 
				if ($this->mysqli->errno != 0) 
					die("MYSQL connection error: " . $this->mysqli->connect_error); 

				if ($db != "") {
					$this->mysqli->select_db($db); 
					$this->db = $db; 
				} else { 
					$this->mysqli->select_db($config['MYSQL_DATABASE']); 
					$this->db = $config['MYSQL_DATABASE']; 
				}

				
				return $this; 
			}

			function __destruct() { 
				$this->Disconnect();  
			}

			function SetHost($host) {
				if ($this->hostname != $host)
					$this->hostname = $host; 
			}
		
			function Disconnect() {
				if (isset($this->mysqli) && $this->IsConnected()) {
					$this->mysqli->kill($this->mysqli->thread_id);
				}
				$this->status = 0; 
			}

			private function IsConnected() { 
				if (!is_object($this->mysqli)) 
					return 0; 

				return ($this->mysqli ? 1 : 0); 
			}

			function Query($q) {
				unset($this->result); 
				$this->query_count++; 
				$queryStr = $q; 
				//$queryStr = str_replace('[x]', MYSQL_PREFIX . '_', $queryStr); // select * from [x]blah becomes select * from tblprefix_blah
				$queryStr = $this->mysqli->real_escape_string($queryStr); 
				$queryStr = stripslashes($queryStr); 
				$this->last_query = $queryStr; 

				$select = explode(" ", $queryStr); 
				$select = (strtolower($select[0]) == "select" ? TRUE : FALSE); 

				if ($select)
					$queryStr = str_replace('@','\@',$queryStr); 

				$query = $this->mysqli->Query($queryStr);
				if ($this->mysqli->error) { 
					//AddError("SQL error:\n".$q."\n".$this->mysqli->error, FALSE); 
					//$error = sprintf("%s: %s", $queryStr, $this->mysqli->error); 
					//$id = trigger_error($error); 
					//die($id);
					$this->error = $this->mysqli->error; 
					__error($this->FullError());  
				}
				if ($select) { 
					while ($row = $query->fetch_assoc())
						$this->result[] = $row; 
				}

				if ($this->mysqli->affected_rows == -1)
					//trigger_error("No affected rows", E_USER_ERROR); 
					die($this->mysqli->error); 

				$this->query = $q;  
				$this->num_rows = $this->mysqli->affected_rows; 
				return $this; 
			}

			function LastQuery() { 
				return $this->last_query; 
			}

			function FullError() { 
				if ($this->error == "") 
					return; 
				return "\nError: " . ($this->last_query != "" ? $this->last_query : NULL) . "\n" . ($this->error != "" ? $this->error : NULL) . "\n"; 
			}

			function Count($item) { 
				switch (strtolower($item)) {
					default:
					case "rows": 
						return $this->num_rows; 
					case "query": 
						return $this->query_count; 
				}
			}

			function NumRows() { 
				return $this->Count("rows"); 
			}

			function QueryCount() { 
				return $this->Count("query"); 
			}

			// return data either as an array or as an object (0 = array, 1 = object)
			// TODO: set up access as MySQL::Get(), MySQL::Get(<row>)->field

			function Get() { 
				$args = func_get_args(); 
				$row = -1; 
				if (isset($args[0])) 
					$row = $args[0]; 

				$ret = array(); 
				// $this->result[<row>][<field>]
				if ($row > -1) {
					$ret = $this->result[$row]; 
				} else {
					foreach ($this->result as $row) { 
						$ret[] = $row; 
					}
				}
				return (object) $ret; 
					
			}				
				
			function GetData($type = 1) {
				if (!is_array($this->result))
					return; 

				return ($type == 0 ? $this->result : (object) $this->result); 
				//return (is_array($this->result) ? $this->result : NULL);  
			}
				
			function GetAllRow($item) {
				if (!isset($this->result) || !is_array($this->result)) 
					return; 
				$a = array(); 

				/*
				foreach ($this->GetArray() as $row) 
					$a[] = $row[$item]; 
				*/ 

				$array = $this->GetArray(); 
				for ($i = 0; $i < count($array); $i++) 
					foreach ($array[$i] as $row) 
						$a[] = $row; 
		
				return $a; 
			}

			function EscapeString($string) { 
				return $this->mysqli->real_escape_string($string); 
			}
	}

?>