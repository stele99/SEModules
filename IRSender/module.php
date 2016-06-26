<?

	class IRSender extends IPSModule {
		
		public function Create() {
			//Never delete this line!
			parent::Create();
			
			$this->RegisterPropertyString("PORT", 0);
			$this->RegisterPropertyString("IP", "");
      $this->RegisterPropertyString("REMOTE", "");       
      $this->RegisterVariableBoolean("POWER", "Power", "~Switch");
      $this->EnableAction("POWER");
      
		}
	
		public function ApplyChanges() {
			//Never delete this line!
			parent::ApplyChanges();
		}
    private function iSend($command, $rep=2){
      $port = $this->ReadPropertyString("PORT");
      $host = $this->ReadPropertyString("IP");
      $remote = $this->ReadPropertyString("REMOTE");
      
      $fp = pfsockopen( "tcp://$host", $port, $errno, $errstr );
      $write = fwrite( $fp, "SEND_ONCE $remote $command | $rep" );
      fclose($fp);  
    }
    
    public function SendCommand($cmd, $repeat=2){
        $this->iSend($cmd,$repeat);
    }
    
    
    public function RequestAction($Ident, $value) {        
        switch($Ident) {
            case "POWER":
                          $this->iSend("KEY_POWER");
                break;
            default:
                throw new Exception("Invalid Ident");
        }
    }
}

?>