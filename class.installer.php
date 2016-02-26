<?php

	/**
	 *	EXAMPLES OF USE
	 *************************************
	 *
	 *	Download and unzip your custom framework.  Then create the database connection file.
	 *
	 *	$install = new installer();
	 *	$install->download('http://your-domain.com/framework.zip');
	 *	$install->unpack();
	 *	$cred = array(
	 *		'DB_HOST' => 'localhost', 
	 *		'DB_DATABASE' => 'user_db12', 
	 *		'DB_USER' => 'user_kewl', 
	 *		'DB_PASSWORD' => 'abc123456'
	 *	);
	 *	$install->create($cred, 'config.php');
	 *	
	 *	
	 *	...OR...
	 *	
	 *	
	 *	Download and unzip Wordpress (or a framework of your choosing).
	 *
	 *	$install = new installer($url);
	 *	$install->download($install->framework['wordpress']);
	 *	$install->unpack();
	 *	 
	 **/
	 

	class installer{
		
		public $installer;
		public $framework = array(
			'wordpress' => 'https://wordpress.org/latest.zip',
			'joomla' => 'https://github.com/joomla/joomla-cms/releases/download/3.4.8/Joomla_3.4.8-Stable-Full_Package.zip',
			'druplal' => 'https://ftp.drupal.org/files/projects/drupal-8.0.4.zip',
			'concrete5' => 'https://www.concrete5.org/download_file/-/view/85780/',
			'opencart' => 'https://codeload.github.com/opencart/opencart/zip/2.1.0.2'
		);

		
		public function __construct(){
			$this->installer = 'install-'.time().'.zip';
			$this->zipUrl = $_zipUrl;
		}
		
		
		private function checkFile($url){
			if(fopen($url, 'r'))
				return true;
			
			return false;
		}
		
		
		public function download($url){
			if($this->checkFile($url)):
				$fp = fopen($this->installer, 'w');
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FILE, $fp);
				$data = curl_exec($ch);
				curl_close($ch);
				fclose($fp);
			else:
				print __CLASS__.': File does not exist.'."\n";
			endif;
		}
		
		
		public function unpack(){
			if($this->checkFile($this->installer)):
				$zip = new ZipArchive();
				if($zip->open(dirname(__FILE__).'/'.$this->installer) === TRUE):
					$zip->extractTo(dirname(__FILE__).'/');
					$zip->close();
					unlink($this->installer);
					print __CLASS__.': Install Complete.'."\n";
				else:
					print __CLASS__.': Could not extract zip.'."\n";
				endif;
			else:
				print __CLASS__.': Installer zip does not exist.'."\n";
			endif;
		}
		
		
		public function create($inputs=array(), $filename='db_config.php'){
			$config = '<?php'."\n\n";
			foreach($inputs as $k=>$v):
				$config .= "\tdefine('".strtoupper($k)."', '".$v."');\n";
			endforeach;
			$config .= "\n".'?>';
			file_put_contents($filename, $config);
		}
		
		
	}

?>