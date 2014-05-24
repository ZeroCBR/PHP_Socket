<?php
class machineTask{
		private $title;
		private $annotation;
		private $parameter;
		private $machine_id;
		private $runtime;
		private $task_id;
		private $user_id;
		private $status="pending";

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

		function setStatus(){
			$this->status="done";
		}		
	}
?>
