<?php
	if(!function_exists("packing")){
		function packing($arr){
			$mess = "";
			if(count($mess)>0){
				$mess = implode(", ",$arr);
			}
			return $mess;
		}
	}

	if(!function_exists("unpacking_login")){
		function unpacking_login($packing){
			$arr = explode(', ',$packing);
			$mess = array("email"=>$arr[0]);
			$mess += array("password"=>$arr[1]);
			return $mess;
		}
	}
	
	if(!function_exists("mess_unpacking")){
		function mess_unpacking($packing){
                        if(isset($packing)){
                                $arr = explode(', ',$packing);
                                $mess = array(
                                        'c_id' => $arr[0],
                                        'token' => $arr[1],
                                        'param' => $arr[2],
                                        'task_id' => $arr[3],
                                        'time' => $arr[4]
                                        );
                        }
                        return $mess;
                }	
	
	}


?>
