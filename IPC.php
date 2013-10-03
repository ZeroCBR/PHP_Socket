<?php
	class IPC_CONN implements SplSubject{
		private $IPC_KEY;
		private $IPCname;
		private $observer;
		private $mess;
		private $_LISTEN;
		function __construct(){
			$this->IPCname = "IPC Robot";
			$this->IPC_KEY =ftok("/home/john/temp/key",'a');
			$this->_LISTEN = true;
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
		
		public function notify(){
			$this->observer->update($this);
		}

		public function set_mess($mess){
			$this->mess = $mess;
		} 

		public function get_mess(){
			return $this->mess;
		}

		public function get_name(){
			return $this->name;
		}
		
		public function listen_IPC(){
			$this->mess = "";
			$message_queue = msg_get_queue($this->IPC_KEY, 0666);
			var_dump($message_queue);
			while($this->_LISTEN){
				@msg_receive($message_queue,0,$msg_type,1024,$this->mess,true,MSG_IPC_NOWAIT);
				if(!empty($this->mess)){
					$this->notify();
					$this->_LISTEN = false;
				}
				usleep(500);
			}	

		}		

	}
?>
