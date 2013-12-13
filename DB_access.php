<?php
	class DB_access{
		private $DB_conn;
		function __construct(){
			$this->DB_conn = mysql_connect("localhost","root","12345");
			if(!$this->DB_conn){
				die("DB Connect Failed:".mysql_error());	
			}
			mysql_select_db("smarthome",$this->DB_conn);
		}		

		function get($table,$key){
			$result = $this->where($table,array("id"=>$id));
			return $result[$key];
		}		

		function where($table, $criteria = NULL,$order = "id"){
			$query ="";
				
			if(isset($table)&&strlen($table)>0){
				$query = "select * from ".$table;
			}
			
			if(count($criteria)>0){
				$query .=" where "; 
				while($key = key($criteria)){
					$query .= $key."= '".$criteria[$key]."'";
					if(next($criteria)){
						$query .= " and ";
					} 
				}
			}
			$result = mysql_fetch_array(mysql_query($query));
			return $result;
		}	
	}
		
?>
