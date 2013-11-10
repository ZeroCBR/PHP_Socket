<?php
	class tasks {

		private $task_list;
		private $time_list;
		private $flag;
		function __construct(){
			$this->task_list = array();
			$this->time_list = array();
			$this->clock_start();
			//$this->clocker();
		}

		function add_task($task){
			$this->task_list[] = $task;
			$this->time_list[] = $task['time'];
		}	
		
		function list_task(){
			print_r($this->task_list);	
		}
		
		function list_time(){
			print_r($this->time_list);
		}
	
		function get_task($index){
			return $this->task_list[$index];
		}
		
		function watch_time($time){
			$list = array();
			$counter=0;
			foreach($this->time_list as $t){
				if($t===$time){
					$list[] = $counter;	
				}
				$counter++;
			}
			return $list;
		}		

		function clock_start(){
			$this->flag = true;
		}
			
		function clock_stop(){
			$this->flag = false;
		}	
	
		function clocker(){
			while($this->flag){
				$time = date("Y-m-d G:i:s",strtotime('now'));
				echo $time."\n";
				$list = $this->watch_time($time);
				$this->do_it($list);
				sleep(1);
			}
		}

		function do_it($indexes){
			if(!count($indexes))return false;
			echo "Do It\n";
			foreach($indexes as $index){
				$task = $this->get_task($index);
				printf("%2s %2s %2s %2s\n",$task['name'],$task['machine_name'],$task['param'],$task['time']);
			}
		}
		
	}
	$a = array(
		array("name"=>'a','machine_name'=>'machine','param'=>'d/s','time'=>'2013-11-09 16:26:00'),
		array("name"=>'b','machine_name'=>'machine','param'=>'d/s','time'=>'2013-11-09 16:26:10'),
		array("name"=>'c','machine_name'=>'machine','param'=>'d/s','time'=>'2013-11-09 16:26:01'),
		);		

	$tasks = new tasks();
	foreach($a as $task){
		$tasks->add_task($task);
	}
	$tasks->clocker();
//	$tasks->list_time();
?>
