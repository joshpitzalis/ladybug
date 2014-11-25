<?php
	require_once("class.core.php");
	
	global $systemCore;
	$c = &$systemCore;
	
	global $systemConfig;
	$s = &$systemConfig;
	
	$mPong = array();
	$a = &$mPong;
	$a["redirectionUrl"] = $s->mRedirectionUrl;

	if(isset($_POST)) {
		$mAuthentificationUsername = strtolower($_POST["authUser"]);
		$mAuthentificationPassword = $_POST["authPass"];
		
		$u = &$mAuthentificationUsername;
		$p = &$mAuthentificationPassword;
		
		$a["isValid"] = $c->authUser($u, $p) ? true : "Die authentifizierung ist fehlgeschlagen da der Benutzername oder das Passwort ungültig sind!";
		
		if($a["isValid"] == true) {
			global $systemSession;
			$x = &$systemSession;
			
			$x->createSession();
		}
	}
	
	echo json_encode($mPong);
?>