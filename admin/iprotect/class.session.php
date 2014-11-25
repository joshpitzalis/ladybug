<?php
	class systemSession {
		public function __construct() {
			session_start();
		}
		
		public function createSession() {
			$_SESSION["authTime"] = time();
		}
		
		public function loopSession($mInterval) {
			if($this->activeSession()) {
				if(($_SESSION["authTime"] + $mInterval) < time())
					$this->stopSession();
			}
		}
		
		public function stopSession() {
			unset($_SESSION["authTime"]);
		}
		
		public function activeSession() {
			return isset($_SESSION["authTime"]);
		}
	}
	
	global $systemSession;
	$systemSession = new systemSession();
?>