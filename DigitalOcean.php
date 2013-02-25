<?php
	require_once("api.class.php"); 
        DEFINE('CLIENT_ID', "");
        DEFINE('API_KEY', "");

	class DigitalOcean { 
		private $client_id; 
		private $api_key; 
		private $api; 
		private $reply; 

		function __construct() { 
			$this->client_id = CLIENT_ID;
			$this->api_key   = API_KEY; 
			$this->base_url  = "https://api.digitalocean.com/"; 
			$this->params    = sprintf("?client_id=%s&api_key=%s", $this->client_id, $this->api_key); 
		}

		function BuildURL($method, $params = "") { 
			$url = $this->base_url . $method . $this->params . ($params != "" ? "&" . $params : ""); 
			$this->api = new API($url, 1, null, "GET"); 
		}

		function Status($full = true) { 
			$this->BuildURL("droplets"); 
			$this->reply = $this->api->Send(); 
		
			$ret = array(); 
			$i = 0; 
			foreach ($this->reply->droplets as $droplet) { 
				$location = $this->Region($droplet->region_id); 
				$size     = $this->Size($droplet->size_id);
				$image    = $this->Image($droplet->image_id);  
				if ($full) { 
					echo sprintf("%s (%s), built using \"%s\" with %s memory, in %s, is currently %s.\n", 
						$droplet->name, $droplet->ip_address, $image, $size, $location, $droplet->status); 
				} else { 
					$ret[$i]['name'] = $droplet->name; 
					$ret[$i]['ip_address'] = $droplet->ip_address; 
					$ret[$i]['image']      = $image; 
					$ret[$i]['memory']     = $size; 
					$ret[$i]['location']   = $location; 
					$ret[$i]['status']     = $droplet->status; 
				}
				$i++; 
			}
			echo ($full == false ? json_encode((object) $ret) : ""); 
		}

		function Region($location) { 
			$this->BuildURL("regions"); 
			$this->reply = $this->api->Send(); 

			foreach ($this->reply->regions as $region) { 
				if ($region->id == $location) 
					return $region->name; 
			}	
		}

		function Size($mem) { 
			$this->BuildURL("sizes"); 
			$this->reply = $this->api->Send(); 

			foreach ($this->reply->sizes as $size) { 
				if ($size->id == $mem) 
					return $size->name; 
			}

		}

		function Images($all = true) { 
			if ($all) { 
				$this->BuildURL("images"); 
			} else { 
				 $this->BuildURL("images", "filter=my_images"); 
			}
			$this->reply = $this->api->Send(); 

			foreach ($this->reply->images as $image) { 
				echo sprintf("%s Image \"%s\" (%s) \n", $image->distribution, $image->name, $image->id); 
			}
		}

		function Image($id) { 
			$this->BuildURL("images"); 
			$this->reply = $this->api->Send(); 
	
			foreach ($this->reply->images as $image) {
				if ($image->id == $id) 
					return $image->name; 
			}
		}
			
	}

	$DO = new DigitalOcean(); 
	$DO->Status(true); 
	$DO->Images(false); 
?>
