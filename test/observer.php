<?php
 
class DemoSubject implements SplSubject{
 
	private $observer, $value;
	
	public function __construct(){
		$this->observers = array();
	}
	
	public function attach(SplObserver $observer){
		$this->observers[] = $observer;
	}
	
	public function detach(SplObserver $observer){
		if(($idx = array_search($observer, $this->observers, true)) !== false){
			unset($this->observers[$idx]);
		}
	}
	
	public function notify(){
		foreach($this->observers as $observer){
			$observer->update($this);
		}
	}
	
	public function setValue($value){
		$this->value = $value;
		$this->notify();
	}
	
	public function getValue(){
		return $this->value;
	}
}
 
class DemoObserver implements SplObserver {
 
	public function update(SplSubject $subject){
		echo 'This is the value :- '. $subject->getValue();
	}
	
}
 
$subject = new DemoSubject();
$observer = new DemoObserver();
$subject->attach($observer);
$subject->setValue(5);
$subject->detach($observer);
$subject->setValue(10);
