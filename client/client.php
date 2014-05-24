<?php 
	include_once("package_helper.php");
	include_once("noti_helper.php");

	class machineTask{
		private $title;
		private $annotation;
		private $parameter;
		private $machine_id;
		private $runtime;
		private $task_id;
		private $user_id;

		function __construct($title,$annotation,$parameter,$machine_id,$runtime,$task_id,$user_id){
			$this->title= $title;
			$this->annotation= $annotation;
			$this->parameter= $parameter;
			$this->machine_id= $machine_id;
			$this->runtime= $runtime;
			$this->task_id= $task_id;
			$this->user_id= $user_id;
		}

		function getTitle(){
			return $this->title;
		}

		function getAnnotation(){
			return $this->annotation;
		}

		function getParameter(){
			return $this->parameter;
		}

		function getMachine_id(){
			return $this->machine_id;
		}

		function getRuntime(){
			return $this->runtime;
		}

		function getTask_id(){
			return $this->task_id;
		}	

		function getUser_id(){
			return $this->user_id;
		}		
	}
	
	class client {

		private $socket;
		private $user_info;
		private $mess;
		private $login_flag;
		private $machineTaskList=array();

		function __construct(){
			$this->login_flag = false;
		        date_default_timezone_set('Asia/Hong_Kong');
			$this->conn();
		 	set_time_limit (0);
		}
		
		function login(){
			$packing = packing($this->user_info);
			socket_write($this->socket,$packing,1024);
			$this->mess=socket_read($this->socket,1024);
			echo $this->mess;
			if($this->mess === "succeed\n"){
				$this->login_flag = true;
				login_successfully();
				$this->listen();
			}
			else{
				login_failed();
				$this->conn();
			}
		}

		function get_user_info(){
			$pass = false;
			while(!$pass){
				unset($this->user_info);
				fwrite(STDOUT,"Email: ");
				$this->user_info = array('email'=>trim(fgets(STDIN)));
				fwrite(STDOUT,"Password(More Than 5 Number): ");
  				$this->user_info += array('password'=>trim(fgets(STDIN)));
				$pass = $this->checkout_user_info($this->user_info);
			}
		}
		
		function checkout_user_info($info){	
			if(!isset($info))
				return false;
			else if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$info['email'])){
				if(strlen($info['password'])>=6){
					return true;
				}
				email_error();
				return false;
			}
			password_error();
			return false;	
		}	

		function splitData($data){
			$str=explode(",",$data);
			$task = new machineTask($str[0],$str[1],$str[2],$str[3],$str[4],$str[5],$str[6]);
			return $task;
		}

		
		function send_mess($mess){
			if($mess!=""){
				echo"Send Message to Server: ".$mess."\n";
				if(!socket_write($this->socket,$mess,1024)){
					echo "Write failed\n";
				}
			}
		}
		
		function listen(){
			$mac=null;
			socket_set_nonblock($this->socket);				
			print_r(date("Y-m-d H:i:s"));
			while(1){			
				if (($data = @socket_read($this->socket,1024))) {
            				print_r("Message From Server: ".$data."\n");
					$task=$this->splitData($data);
					array_push($this->machineTaskList, $task);
					print_r($this->machineTaskList);					
				} 
										
				foreach ($this->machineTaskList as $index=>$task){
					$time=date(" Y-m-d H:i:s");
					$time=strtotime($time);
					$runtime=strtotime($task->getRuntime());
					if($runtime==$time){				
						$doc = new DOMDocument();
						$doc->load( 'mac_table.xml' );
						$items = $doc->getElementsByTagName( "item" );
						foreach( $items as $item )
						{
							if(strcmp($item->getElementsByTagName("machine_id")->item(0)->nodeValue,$task->getMachine_id())==0){
								$mac=$item->getElementsByTagName("mac")->item(0)->nodeValue;
								break;
							}
							else{
								$mac="00:13:04:10:09:72";
							}
						}
						$this->send_mess($data);
						print_r("Task id: ".$task->getTask_id()." finish on ".$task->getRuntime()."\n");
						unset($this->machineTaskList[$index]);
						print_r($this->machineTaskList);													
						system('python arduino.py '.$mac);
						break;
					}
				}
			}
		}		

		function conn(){
			$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$this->get_user_info();
			if(@socket_connect($this->socket, 'localhost', 10008)){
				conn_successfully();
				$this->login();
			} 
			else{
				socket_close($this->socket);
			}
		}
	}
		
	$client = new client();
?>
