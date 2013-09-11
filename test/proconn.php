<?php

$mesg_key = ftok(__FILE__, 'm');
$mesg_id = msg_get_queue($mesg_key, 0666);
 
function fetchMessage($mesg_id){
 
 if(!is_resource($mesg_id)){
 
 print_r("Mesg Queue is not Ready\n");
 
 }
 
 if(msg_receive($mesg_id, 0, $mesg_type, 1024, $mesg, false, MSG_IPC_NOWAIT)){
 
 print_r("Process got a new incoming MSG: $mesg \n");
 
 }
 
}
 
register_tick_function("fetchMessage", $mesg_id);
 
declare(ticks=2){
 
 $i = 0;
 
 while(++$i < 100){
 
 if($i%5 == 0){
 
 msg_send($mesg_id, 1, "Hi: Now Index is :". $i);
 }
 }
}?>
