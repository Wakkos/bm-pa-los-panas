<?php
/**
 * @name:     sess.php
 * @author:   alessandro
 * @version:  2.0
 */
 
class Sess
{
	var $sid;    //session id;
	var $time;   //current time;
	
	/* Constructor: called each time the class is called.  */
	function Sess()
	{ 
		session_start();
		if($this->sid==''){
			$this->sid = session_id();
		}else{
			session_id($this->sid);
		}
		$this->time = time();
		define("MAX_IDLE_TIME", 180);
	}

	/* Function:	  getOnlineUsers()                                                                     *\
	 * Description:   This function retrive the number of the current visitors. Be aware that this         *
	 *				  function may not work if the path to the session folder is not specifiend in php.ini *
	 *				  If you want to specify your own path in php.ini then please follor instruction in    *
	\*				  http://www.php.net/session.save-path                                                 */
	function getOnlineUsers() {
		$directory_handle = @opendir(@session_save_path());
		$count = 0;
		while($file = @readdir($directory_handle)) {
			if(!((time()- @fileatime(session_save_path() . '/' . $file) > MAX_IDLE_TIME) || $file == '.' || $file == '..')) { 
			$count++;
			}
		}
		return ($count==0)? 'Couldn\'t calculate' : $count ;
	}
	
}

$ses = new Sess();

?>