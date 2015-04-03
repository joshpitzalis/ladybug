<?php
	######################################################################################################
	#	DO NOT TOUCH ANYTHING INSIDE THIS SMALL CODE-BLOCK, THIS COULD BREAK UP THE WHOLE iProtect SYS   #
	######################################################################################################

	class systemConfig {
		public $mAuthUser = array();
		public $mRedirectionUrl = null;
		public $mActiveTime = 0;
		
		public function appendUser($mUser, $mPass) {
			$this->mAuthUser[strtolower($mUser)] = $mPass;
		}
	}
	
	global $systemConfig;
	$systemConfig = new systemConfig();
	$s = &$systemConfig;
	
	######################################################################################################
	# FROM NOW ON YOU WILL SEE BELOW SOME CONFIGURATION CODES STARTING WITH $s-> - You should edit them! #
	######################################################################################################
	
			/*	**********************************
				* CONFIGURATION STARTS FROM HERE *
				**********************************	*/
				
				// This is the URL where the users will be redirected after authentificating, if you enter "self" it will refresh the page after a successful authentification
				// You are also able to enter here something like /me or http://google.de or mydashboard.php, it will also work! :-)
				$s->mRedirectionUrl = "self";
				
				// This is the time in seconds how long a session after a successful authentification will be active
				// Currently it's set to 300, that equals 5 minutes (300 / 60 = 5). If you want to increase or decrease it, feel free to change it! (You can also use a infinite amount like 99999999 which will make the session permanent active until he closes the site/browser :-)
				// We recommended for a garantued security 300 seconds, if you think it's annoying to authentificate each 5 minutes, feel again free to change it! :-)
				$s->mActiveTime = 1;
			
				// This is the main part now, adding user combinations to your iProtect system!
				// 1) Copy this code and add it below the last $s->appendUser code: $s->appendUser("user", "pass");
				// 2) Change the parameter "user" to any username you want to use, per example to dominik
				// 3) Change the parameter "pass" to any password you want to use, per example to lol123
				// Result: Now it should look like $s->appendUser("dominik", "lol123");
				
				/*
					Per example for more accounts the code-structur would be like this:
					
						$s->appendUser("demo1", "demo1");
						$s->appendUser("demo2", "demo2");
						$s->appendUser("anyotheracc", "lol123");
						$s->appendUser("dominik", "lol123");
				
				*/
				// Remember: The password-input is case sensitive, the username is not sensitive! So you would be able to login with these following combinations:
				
				/*
					Username: DeMo1 | Password: demo1 = would work!
					Username: deMO1 | Password: Demo1 = would NOT work because the password is case-sensitive!
					Username: anyOTHERacc | Password: lol123 = would work!
					
					Did you understand it? Not? Just try it out, you'll understand it very fast, but I guess you did! :-D
				*/
				
				###############################################
				#         USER ACCOUNTS FOR IPROTECT          #
				###############################################
				
					$s->appendUser("", "21)KSKhgnajB0-at2");
					// $s->appendUser("anotheruser", "password");
				
				###############################################
			
			/*	**********************************
				*     CONFIGURATION ENDS HERE    *
				**********************************	*/
				
				// For any further help write me an email to dominik.ganic@gmail.com or add me in skype: fantasy.xd
				// Thank you very much for buying my product! :-)
?>