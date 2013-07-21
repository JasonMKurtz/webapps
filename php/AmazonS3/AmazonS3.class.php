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

			if ($name == -1) 
				$name = $file; 

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
	}

	$S3 = new AmazonS3("b1.aws"); 
	echo $S3->doUpload("terminals.png"); 
?> 
