<?php
	class IPC_CONN implements SplSubject{
i		private IPC_KEY;
		public $IPCname;
		public $observer;
		public $mess;
	
		function __construct(){
			$this->IPCname = "IPC Robot";
			$this->IPC_KEY ="/home/john/temp/Key";
			$this->observers = array();
			print_r("[IPC INITIALIZED]\n");
		}
		
		public function attach(SplObserver $observer){
			$this->observer = $observer;
		} 		

		public function detach(SplObserver $observer){
			if($this->observer === $observer){
				unset($observer);
			}
		}
		
		public notify(){
			$this->observer - >update($this);
		}

		public set_mess($mess){
			$this->mess = $mess;
		} 

		public get_mess(){
			return $this->mess;
		}

		public get_name(){
			return $this->name;
		}
		

	}
?>
