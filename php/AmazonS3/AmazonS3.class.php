#!/usr/bin/php
<?php
	require 'vendor/autoload.php'; 
	require 's3.conf.php'; 
	use Aws\S3\S3Client;
		
	class AmazonS3 {
		private $client, $bucket; 
		
		function __construct($bucket) { 
			$this->client = S3Client::factory(array('key' => S3Key, 'secret' => S3Secret)); 
			if (!$this->client->doesBucketExist($bucket)) { 
				die(sprintf("Bucket %s does not exist. Aborting.\n", $bucket)); 
			}
			$this->bucket = $bucket; 
		}

		function doUpload($file, $name = -1, $verbose = 0, $public = 'public-read') { 
			if (!is_file($file)) { 
				die(sprintf("File %s does not exist.\n", $file)); 
			}

			$ext = pathinfo($file, PATHINFO_EXTENSION); 

			if ($name == -1) 
				$name = sprintf("%s.%s", $this->GenRand(25), $ext); 

			try {
				$this->client->upload($this->bucket, $name, fopen($file, 'r'), $public); 
			} catch (S3Exception $e) { 
				die(sprintf("Couldn't upload %s to %s. Aborting.\n", $file, $this->bucket)); 
			}
			if ($verbose) { 
				return sprintf("Upload complete. %s (saved as %s) to %s bucket.", $file, $name, $this->bucket); 
			} else {
				return sprintf("https://s3.amazonaws.com/%s/%s", $this->bucket, $name); 
			}
		}

		private function GenRand($len = 10) {
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

				$value.=chr($rand);
			}

			return $value;
		}
	}

	$S3 = new AmazonS3("b1.aws"); 
	echo $S3->doUpload("terminals.png"); 
?> 
