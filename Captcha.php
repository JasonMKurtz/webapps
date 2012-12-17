<?php 
	class Captcha { 
		private $width, $height; 
		private $image; 
		private $bgColor; // color object
		private $fgColor; // color object
		private $key; // the captcha we generate

		function __construct($len = 4, $width = 150, $height = 20) { 
			$this->width  = $width; 
			$this->height = $height; 
			$this->image  = imagecreate($width, $height); 
			$this->key    = $this->GenRand($len, " "); 
			return $this; 
		}

		function ColorBG($red, $green, $blue) { 
			$this->bgColor = imagecolorallocate($this->image, $red, $green, $blue); 
			return $this; 
		}

		function Text($message, $size = 5, $red = 255, $green = 255, $blue = 255) { 
			$this->fgColor = imagecolorallocate($this->image, $red, $green, $blue); 
			$text_width    = imagefontwidth($size) * strlen($message); 
			$text_height   = imagefontheight($size); 
			$x_center      = ceil($this->width / 2); 
			$y_center      = ceil($this->height / 2); 
			$x             = $x_center - (ceil($text_width/2)) + 10; 
			$y             = $y_center - (ceil($text_height/2)) + 15;  

			imagettftext($this->image, 11, 0, $x, $y, $this->fgColor, "font/lego.ttf", $message);
			imagesetthickness($this->image, 5); 
			return $this; 
		}

	        function GenRand($len = 10, $seperator = NULL) {
        	        if (@is_readable('/dev/urandom')) {
                	        $f=fopen('/dev/urandom', 'r');
                        	$urandom=fread($f, $len);
	                        fclose($f);
        	        }

                	$value='';

	                for ($i=0;$i<$len;++$i) {

        	                if (!isset($urandom)) {
                	                if ($i%2==0) {
                        	                mt_srand(time()%2147 * 1000000 + (double)microtime() * 1000000);
                                	}

	                                $rand=48+mt_rand()%64;
        	                } else {
                	                $rand=48+ord($urandom[$i])%64;
                        	}

	                        if ($rand>57)
        	                        $rand+=7;
                	        if ($rand>90)
                        	        $rand+=6;

	                        if ($rand==123)
        	                        $rand=45;
                	        if ($rand==124)
                        	        $rand=46;

	                        $value.=chr($rand) . $seperator;

        	       }

	               return $value;
        	}

		function Generate() {
			if (!isset($this->colorBG)) 
				$this->ColorBG(0, 0, 255); 
			$this->Text(strtoupper($this->key)); 

			imagepng($this->image); 
			header("Content-type: image/png"); 
			imagecolordeallocate($this->image, $this->bgColor); 
			imagecolordeallocate($this->image, $this->fgColor); 
			imagedestroy($this->image); 

		}

		function GetKey() { 
			return str_replace(" ", "", $this->key); 
		}
	}
?>