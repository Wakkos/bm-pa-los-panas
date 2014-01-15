<?php
/**
 * @name:     ums.php
 * @author:   alessandro
 * @version:  2.0
 */

/*  Description:                                                                              *\
 *	This class an all included classes are released under the GNU license.                     *
 *	Please fill free to change any of the source code according to the GNU license.            *
\*	This is the main class. here we set up all the function we use.                            */

	include_once("inc/settings.php");
	include_once("inc/db.php");
	include_once("inc/sess.php");
	include_once("inc/secure.php");
	include_once("inc/mail.php");
	include_once("inc/err.php");

class ums
{
	var $uname; //Username:	The current user Username. (Empty if not logged in).
	var $id;    //String:	The current user ID. (0 if not logged in).
	var $logged;//Boolean:	TRUE if the user is logged in.
	
	/* Constructor: called each time the class is called.  */
	function ums()
	{
		$this->uname = (isset($_SESSION['user']['uname']))? $_SESSION['user']['uname'] : '' ;
		$this->id = (isset($_SESSION['user']['id']))? $_SESSION['user']['id'] : '' ;
		$this->logged = (isset($_SESSION['logged']))? $_SESSION['logged'] : 0 ;
		if(isset($_GET['act']) && $_GET['act']=='activate'){ $this->activate(); }
	}
	
	/* Function:	getOnlineUsers()                                                              *\
	 * Description:	This function retrive the number of the currently logged users. For           *
	\*				more info please refer to $ses->getOnlineUsers().                             */
	public function getOnlineUsers(){
		global $ses, $db, $eml, $err;
		return $ses->getOnlineUsers();
	}
	
	/* Function:	  login()                                                                     *\
	 * Description:   Main function to Login the user.                                            *
	 * Parameters:	$uname = Username                                                             *
	 *				$pass  = Password                                                             *
	 * 				$remember = boolean, if the username should be saved in a cookie or not.      *
	 * Returns:	   TRUE if logged in;                                                             *
	 *				2 if password is not correct;                                                 *
	\*				3 if the username is not in the DB.                                           */
	public function login($uname, $pass, $remember=0){
		global $ses, $db, $eml, $err;
		//check if user exist
		$exist = $this->user_exist($uname);
		if($exist){
			//check password
			$stored_pass = $db->select("SELECT `pass` FROM `users` WHERE `uname`='$uname' OR `email`='$uname' LIMIT 1");
			if(md5($pass)==$stored_pass[0][0]){
				//user ok now save sessions/cookies
				$uinfo = $db->select("SELECT `id` FROM `users` WHERE `uname`='$uname' OR `email`='$uname' LIMIT 1");
				
				$this->uname = $_SESSION['user']['uname'] = $uname;
				$this->id = $_SESSION['user']['id'] = $uinfo[0]['id'];
				$this->logged = $_SESSION['logged'] = 1;
				
				if($remember==1){
					setcookie("u_uname",  $uname, time()+60*60*24*30);
					//setcookie("u_id",  $uinfo[0]['id'], time()+60*60*24*30);
				}
				$err->clear("login");
				return true;
			}else{
			$err->set("login", "Password not correct");
				return 2;
			}
		}else{
			$err->set("login", "User name doesn't exist");
			return 3;
		}
	}
	
	/* Function:	  logout()                                                                     *\
	 * Description:   Main function to logout the user.                                            *
	\* Returns:	   TRUE;                                                                           */
	public function logout(){
		global $ses, $db, $eml, $err;
		$this->uname = '';
		$this->id = '';
		$this->logged = 0;
		unset($_SESSION['user']);
		unset($_SESSION['logged']);
		setcookie("u_uname",  '', time()-60*60*24*30);
		return true;
	}

	/* Function:	  register()                                                                  *\
	 * Description:   Main function to register a new user.                                       *
	 * Parameters:	$uname = New username                                                         *
	 *				$pass  = New password                                                         *
	 * 				$email = New email.                                                           *
	 * 				$level = number, eventually a level number, default 1.                        *
	 * Returns:	   TRUE if registered in;                                                         *
	\*			   FALSE if the choosen username is already in use;                               */
	public function register($uname, $pass, $email, $level=1){
		global $ses, $db, $eml, $err;
		$exist = $this->user_exist($uname);
		if($exist){
			$err->set("register", "User already exist!");
			return false;
		}
		if(EMAIL_REGISTRATION){
			$id = $db->insert("INSERT INTO `users` (`uname`,`pass`,`email`,`date`,`active`,`level`) VALUES ('".$uname."', '".md5($pass)."', '".$email."', '".time()."','0','".$level."' ); ");
			if($id!==0){
				$this->eml_registration($id, $email, $level);
				$err->clear("register");
				return true;
			}
		}else{
			$db->insert("INSERT INTO `users` (`uname`,`pass`,`email`,`date`,`active`,`level`) VALUES ('".$uname."', '".md5($pass)."', '".$email."', '".time()."','1','".$level."' ); ");
		}
	}
	
	/* Function:	  update()                                                                    *\
	 * Description:   Main function to update any user's info.                                    *
	 * Parameters:	$uname = Username                                                             *
	 *				$pass  = Password                                                             *
	 * 				$email = Email.                                                               *
	 * Returns:	   TRUE if success;                                                               *
	\*			   FALSE if username choosen is already in use;                                   */
	public function update($uname, $pass, $email){
		global $ses, $db, $eml, $err;
		$exist = $this->user_exist($uname);
		$uname_c = $this->getUser('this', 'uname');
		$email_c = $this->getUser('this', 'email');
		$pass_c = $this->getUser('this', 'pass');
		if($exist && $uname!=$uname_c[0]){
			$err->set("update", "The new Username you selected is already in use.");
			return false;
		}else{
			$q='UPDATE `users` SET  ';
			if($uname!='' && $uname!=$uname_c[0]){ $q .= "`uname` =  '".$uname."', "; }
			if($email!='' && $email!=$email_c[0]){ $q .= "`email` =  '".$email."', "; }
			if($pass!='' && $pass!=$pass_c[0]){ $q .= "`pass` =  '".md5($pass)."', "; }
			$q .= " `id`='".$this->id."' WHERE `id` ='".$this->id."';";
			$db->update($q);
			if($uname!='' && $uname!=$this->uname){
				$this->uname = $_SESSION['user']['uname'] = $uname;
			}
			return true;
		}
	}

	/* Function:	  activate()                                                                  *\
	 * Description:   Checks that the user came from the earlier sent email (the url must contain *
	 *				  the email as md5(). then activate the user.                                 *
	\* Returns:	      Redirects to site_root.                                                     */
	public function activate(){
		global $ses, $db, $eml, $err;
		if(isset($_GET['u']) && $_GET['u']!='' && isset($_GET['c']) && $_GET['c']!=''){
			$user_email = $db->select("SELECT `email` FROM `users` WHERE `id`='".$_GET['u']."'");
			if(md5($user_email[0]['email'])== $_GET['c']){
				$db->update("UPDATE `users` SET `active` = '1' WHERE `id`='".$_GET['u']."'");
				$err->clear("activate");
			}else{
				$err->set("activate", "Parameters are wrong!");
			}
		}else{
			$err->set("activate", "Parameters are missing!");
		}
			header('Location: '.site_root);
	}
	
	/* Function:	  recover()                                                                    *\
	 * Description:   This function sends an email to the user with a new temporary password.      *
	 * Parameters:	  $user = Either the Username or the Email                                     *
	 * Returns:	      TRUE if success;                                                             *
	\*			      FALSE if User doesen't exist;                                                */
	public function recover($user){
		global $ses, $db, $eml, $err;
		$exist = $this->user_exist($user);
		if(!$exist){
			$err->set("recover", "User doesen't exist!");
			return false;
		}else{
			$email_c = $this->getUser($user,'email');
			$uname_c = $this->getUser($user,'uname');
			$p = $this->password_gen();
			$db->update("UPDATE `users` SET `pass` = '".md5($p)."' WHERE `uname`='".$uname_c[0]."'");
			$this->eml_recover($uname_c[0], $email_c[0], $p);
			$err->clear("recover");
			return true;
		}
	}
	
	/* Function:	  getUser()                                                                    *\
	 * Description:   This function sends an email to the user with a new temporary password.      *
	 * Parameters:	  $user = Either the Username or the Email or the id, by defalut the current   *
	 *						  logged user.                                                         *
	 * 				  $info = String containing the fields tyo retrive, defalut *=all.             *
	\* Returns:	      TRUE Selected data;                                                          */
	public function getUser($user='this', $info='*'){
		global $ses, $db, $eml, $err;
		$user_info = ($user=='this')? $this->id : $user ;
		$info = ($info=='*')? '*' : $info ;
		$return = $db->select("SELECT ".$info." FROM `users` WHERE `id`='".$user_info."' OR  `uname`='".$user_info."' OR  `email`='".$user_info."' LIMIT 1");
		return $return[0];
	}
	
	
	
	
	
	/* Private function returing 1 or 0 is the users exhist or not. */
	private function user_exist($u){
		global $ses, $db, $eml, $err;
		return ($db->select("SELECT `id` FROM `users` WHERE `uname`='$u' OR `id`='$u' OR `email`='$u' LIMIT 1", "count")>=1)? 1 : 0 ;
	}
	/* Private function sending email to the user after registration, containg a link to activcate the account. */
	private function eml_registration($u, $e, $l){
		global $ses, $db, $eml, $err;
		$link = site_root."/index.php?act=activate&u=$u&c=".md5($e);
		$eml->send("UMS user confirmation", "Click on the link to confirm registration:<br />".$link, $e);
		return true;
	}
	/* Private function sending email to the user with the new temporary password. */
	private function eml_recover($u, $e, $p){
		global $ses, $db, $eml, $err;
		$link = site_root."/index.php#login";
		$eml->send("UMS Password recovery", "We have sent you a temporary password. Click on the link to login with the new credentials:<br />
		<br />
		".$link."<br />
		<br />
		Username: ".$u."<br />
		Password: ".$p." <br />
		<br />
		After login you may change the password.", $e);
		return true;
	}
	/* Private function generating a random and easy to remember password. */
	private function password_gen($syllables = 3, $use_prefix = false){
		if (!function_exists('ae_arr')){function ae_arr(&$arr) { return $arr[rand(0, sizeof($arr)-1)];}}
		$prefix = array('aero', 'anti', 'auto', 'bi', 'bio',
						'cine', 'deca', 'demo', 'dyna', 'eco',
						'ergo', 'geo', 'gyno', 'hypo', 'kilo',
						'mega', 'tera', 'mini', 'nano', 'duo');
		$suffix = array('dom', 'ity', 'ment', 'sion', 'ness',
						'ence', 'er', 'ist', 'tion', 'or'); 
		$vowels = array('a', 'o', 'e', 'i', 'y', 'u', 'ou', 'oo'); 
		$consonants = array('w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j', 
							'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'qu');
		$password = $use_prefix?ae_arr($prefix):'';
		$password_suffix = ae_arr($suffix);
		for($i=0; $i<$syllables; $i++){
			$doubles = array('n', 'm', 't', 's');
			$c = ae_arr($consonants);
			if (in_array($c, $doubles)&&($i!=0)) {if (rand(0, 2) == 1){$c .= $c; } }
			$password .= $c;
			$password .= ae_arr($vowels);
			if ($i == $syllables - 1){ if (in_array($password_suffix[0], $vowels)){$password .= ae_arr($consonants);} }
		}
		$password .= $password_suffix;
		return $password;
	}
}
/* Setting up the variable $ums as caller for the class. */
$ums = new ums();

?>