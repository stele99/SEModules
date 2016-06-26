<?

	class IRSender extends IPSModule {
		
		public function Create() {
			//Never delete this line!
			parent::Create();
			
			$this->RegisterPropertyString("PORT", 0);
			$this->RegisterPropertyString("IP", "");
		}
	
		public function ApplyChanges() {
			//Never delete this line!
			parent::ApplyChanges();
		}
    private function iSend($remote, $command, $rep){
      $host = $this->ReadPropertyString("PORT");
      $port = $this->ReadPropertyString("IP");
      
      $fp = pfsockopen( "tcp://$host", $port, $errno, $errstr );
      $write = fwrite( $fp, "SEND_ONCE pioneer $cmd | $rep" );
      fclose($fp);  
    }
    
    public function SendCommand($remote, $command, $repeat = 2){
           $this->iSend($remote,$command, $repeat);
    }
		
	}

?>