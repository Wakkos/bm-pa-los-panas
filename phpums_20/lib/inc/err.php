<?php
/**
 * @name:     err.php
 * @author:   alessandro
 * @version:  2.0
 */

class error
{
	var $errs;  // array containing all the errors


	/* Function:	  error() !! Constructor !!                                                   *\
	 * Description:   populate $errs.                                                             */
	function error(){
		if(isset($_SESSION['err'])){
			$this->errs = $_SESSION['err'];
		}else{
			$this->errs = $_SESSION['err'] = array();
		}
	}

	/* Function:	  get()                                                                       *\
	 * Description:   Get errors accordingt to $cat.                                              *
	 * Parameters:	  $cat = Sub category to show. Default (all) will retrives all subcategories. *
	\* Returns:	      Errors accordingt to $cat                                                   */
	function get($cat="all"){
		$err = (is_array($_SESSION['err']))? array_filter($_SESSION['err']) : $_SESSION['err'];
		if($cat=="all"){
			$return='';
			foreach($err as $n=>$v){
			$return .= $v."<br/>\n";
			}
			$this->clear("all");
		}else{
			$return = (array_key_exists($cat, $err))? $err[$cat] : '' ;
			$this->clear($cat);
		}
		return ($return!="")? "<div class=\"error\">".$return."</div>" : "";
	}
	
	/* Function:	  set()                                                                       *\
	 * Description:   Set errors accordingt to $cat.                                              *
	 * Parameters:	  $cat = Sub category in witch the error is saved.                            *
	\* Parameters:	  $val = Actual error message.                                                */
	function set($cat, $val){
		$_SESSION['err'][$cat] =  $val;
		$this->errs = $_SESSION['err'];
	}
	
	/* Function:	  clear()                                                                     *\
	 * Description:   Clear errors accordingt to $cat.                                            *
	\* Parameters:	  $cat = Sub category to clear. Default (all) will clear all errors.          */
	function clear($cat='all'){
		if($cat=='all'){
			$this->errs = $_SESSION['err'] = array();
		}else{
			unset($_SESSION['err'][$cat]);
			$this->errs = $_SESSION['err'];
		}
	}
}

$err = new error();

?>