<?

	class IRSender extends IPSModule {
		
		public function Create() {
			//Never delete this line!
			parent::Create();
			
      // Variablenprofile
      if(!IPS_VariableProfileExists("SE_IRButtons")){
        IPS_CreateVariableProfile("SE_IRButtons", 1);
        IPS_SetVariableProfileAssociation("SE_IRButtons", 0, "Power", "", 0xFFFFFF);
        IPS_SetVariableProfileAssociation("SE_IRButtons", 1, "Lauter", "", 0xFFFFFF);
        IPS_SetVariableProfileAssociation("SE_IRButtons", 2, "Leiser", "", 0xFFFFFF);
        IPS_SetVariableProfileAssociation("SE_IRButtons", 3, "Mute", "", 0xFFFFFF);
      }
      if(!IPS_VariableProfileExists("SE_IRInput")){
        IPS_CreateVariableProfile("SE_IRInput", 1);
        IPS_SetVariableProfileAssociation("SE_IRInput", 0, "CD", "", 0xFFFFFF);
        IPS_SetVariableProfileAssociation("SE_IRInput", 1, "Tuner", "", 0xFFFFFF);
        IPS_SetVariableProfileAssociation("SE_IRInput", 2, "Audio", "", 0xFFFFFF);
        IPS_SetVariableProfileAssociation("SE_IRInput", 3, "Aux", "", 0xFFFFFF);
        IPS_SetVariableProfileAssociation("SE_IRInput", 4, "Radio", "", 0xFFFFFF);
      }      
      $this->RegisterVariableInteger("BUTTONS", "Befehl", "SE_IRButtons");
      $this->EnableAction("BUTTONS");

      $this->RegisterVariableInteger("INPUT", "Input", "SE_IRInput");
      $this->EnableAction("INPUT");
      
			$this->RegisterPropertyString("PORT", 0);
			$this->RegisterPropertyString("IP", "");
      $this->RegisterPropertyString("REMOTE", "");       

      
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
      	#Map
      	 $MapInput[0] = "KEY_CD";
      	 $MapInput[1] = "KEY_TUNER";
      	 $MapInput[2] = "KEY_AUDIO";
      	 $MapInput[3] = "KEY_AUX";
      	 $MapInput[4] = "KEY_RADIO";
      	 
      	 $MapButton[0] = "KEY_POWER";
      	 $MapButton[1] = "KEY_VOLUMEUP";
      	 $MapButton[2] = "KEY_VOLUMEDOWN";
      	 $MapButton[3] = "KEY_MUTE";     
         
        switch($Ident) {
            case "BUTTONS":
                          $this->iSend($MapButtons[$value]);
                break;
            
            case "INPUT":
                          $this->iSend($MapInput[$value]);
                break;



            default:
                throw new Exception("Invalid Ident");
        }
    }
}

?>