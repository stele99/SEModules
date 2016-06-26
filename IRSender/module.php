<?

	class IRSender extends IPSModule {
		
		public function Create() {
			//Never delete this line!
			parent::Create();
			
			$this->RegisterPropertyString("Port", 0);
			$this->RegisterPropertyString("IP", "");
		}
	
		public function ApplyChanges() {
			//Never delete this line!
			parent::ApplyChanges();
		}
		
	}

?>