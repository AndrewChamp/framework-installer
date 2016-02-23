<?php
	
	class installer{
		
		public $zipUrl;
		public $installer;
		
		public function __construct($_zipUrl){
			$this->installer = 'install-'.time().'.zip';
			$this->zipUrl = $_zipUrl;
			
			$this->download();
			$this->unpack();
		}
		
		
		private function checkFile($url){
			if(fopen($url, 'r'))
				return true;
			
			return false;
		}
		
		
		public function download(){
			if($this->checkFile($this->zipUrl)):
				$fp = fopen($this->installer, 'w');
				$ch = curl_init($this->zipUrl);
				curl_setopt($ch, CURLOPT_FILE, $fp);
				$data = curl_exec($ch);
				curl_close($ch);
				fclose($fp);
			else:
				print __CLASS__.': File does not exist.';
			endif;
		}
		
		
		public function unpack(){
			if($this->checkFile($this->installer)):
				$zip = new ZipArchive();
				if($zip->open(dirname(__FILE__).'/'.$this->installer) === TRUE):
					$zip->extractTo(dirname(__FILE__).'/');
					$zip->close();
					unlink($this->installer);
					print __CLASS__.': Install Complete.';
				else:
					print __CLASS__.': Could not extract zip.';
				endif;
			else:
				print __CLASS__.': Installer zip does not exist.';
			endif;
		}
		
	}

?>
