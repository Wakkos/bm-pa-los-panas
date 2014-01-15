<?php
/**
 * @name:     mail.php
 * @author:   alessandro
 * @version:  1.0
 */
 
 
class email
{
	var $from;      //email address from wicth the email is sent.
	var $headers;   //Email headers (important to send html format emails).

	/* Function:	  email() !! Constructor !!                                                   *\
	 * Description:   populate $from (try to get it from php.ini, or set a fake one), and         *
	\* 				  $headers with a defalut html header                                         */
	function email(){
		if(ini_get('sendmail_from')!=''){
			$this->from =ini_get('sendmail_from');
		}else{
			$this->from = 'noemail@localhost';
		}
		$this->headers =  "From: ".$this->from."\r\n"."Content-type: text/html\r\n";
	}

	/* Function:	  send()                                                                          *\
	 * Description:   Main function to send emails.                                                   *
	 * Parameters:	$subject = The subject of the email                                               *
	 *				$message  = The body of the email                                                 *
	\* 				$to = email to wicth the email is sent. If not setted it will send to the sender. */
	function send($subject, $message, $to='default'){
		$to = ($to=='default')? $this->from : $to ;
		if(!mail($to, $subject, $message, $this->headers)){
		die($message); // this will heml local hosts. the Mail function can't work on local version of Apache.
		               // please delete this before you go live.
		}
	}
	
}

$eml = new email();

?>