<?php
/**
 * @name:     secure.php
 * @author:   alessandro
 * @version:  2.1
 */

class Secure
{	
	/* Function:	  Secure() !! Constructor !!                                                  *\
	 * Description:   runs secureGET or securePOST to each entry in $_GET and $_POST.             *
	\* Parameters:	$uname = Username                                                             */
	function Secure()
	{
		array_walk($_GET, array($this, 'secureGET'));
		array_walk($_POST, array($this, 'securePOST'));
	}
	
	/* Function:	  secureGET()                                                                     *\
	\* Description:   Run basic secure functions to each &$value.                                     */
	function secureGET(&$value, $key)
	{
		$_GET[$key] = htmlspecialchars(stripslashes($_GET[$key]));
		$_GET[$key] = str_ireplace("<script", "<-s-c-r-i-p-t", $_GET[$key]);
		$_GET[$key] = mysql_escape_string($_GET[$key]);
		return $_GET[$key];
	}
	
	/* Function:	  securePOST()                                                                     *\
	\* Description:   Run basic secure functions to each &$value.                                     */
	function securePOST(&$value, $key)
	{
		$_POST[$key] = htmlspecialchars(stripslashes($_POST[$key]));
		$_POST[$key] = str_ireplace("<script", "<-s-c-r-i-p-t", $_POST[$key]);
		$_POST[$key] = mysql_escape_string($_POST[$key]);
		return $_POST[$key];
	}
}
$secure = new Secure();

?>