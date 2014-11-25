<?php
	class systemCore {
		private $mCoreFiles = array("config", "session");
	
		public function __construct() {
			foreach($this->mCoreFiles as $mCoreFile)
				require_once(vsprintf("class.%s.php", $mCoreFile));
		}
		
		public function authUser($mUser, $mPass) {
			global $systemConfig;
			$s = &$systemConfig;
				
			return array_key_exists($mUser, $s->mAuthUser) ? $s->mAuthUser[$mUser] == $mPass : false;
		}
		
		public function authCheck() {
			global $systemSession;
			$x = &$systemSession;
			
			if(!$x->activeSession() && !strpos($_SERVER["REQUEST_URI"], "ajax.authentificate.php"))
				die(file_get_contents("iprotect/tpl.auth.html"));
		}
	}
	
	global $systemCore;
	$systemCore = new systemCore();
	
	global $systemSession;
	$x = &$systemSession;
	
	global $systemConfig;
	$s = &$systemConfig;
	
	$systemCore->authCheck();
	
	$x->loopSession($s->mActiveTime);
?>