<?php
/**
 * @name:     db.php
 * @author:   alessandro
 * @version:  2.0
 */
 
class db
{
	var $conn;  // connection object.

	/* Function:	  db() !! Constructor !!                                                      *\
	\* Description:   Set up the connection object.                                               */
	function db(){
		$db = parse_url(conn_string);
		$this->conn = mysql_connect($db['host'], $db['user'], $db['pass']) or die("Couldn't connect to database.");
		mysql_select_db(substr($db['path'], 1), $this->conn);
	}
	
	/* Function:	  select()                                                                    *\
	 * Description:   Run an SQL querry defined in $q and return it results according to $type.   *
	 * Parameters:	  $q = Query to be executed.                                                  *
	 *				  $type  = The type of resutlt to return:                                     *
	 *					    	 - array (default): returns the result into an array.             *
	 *						     - result: return the $result var as a mysql object.              *
	 *						     - total: return the total rows found.                            *
	\* Returns:	      Return data coording to $type.                                              */
	function select($q, $type='array'){
		$result = mysql_query($q);
		switch($type)
		{
			default:
				$return = array();
				if(!$result || (mysql_num_rows($result) < 1)){
					return false;
				}else{
					while($row = mysql_fetch_array($result)){
						array_push($return, $row);
					}
				}
				return $return;
			break;
			case 'result':
				if (!$result) {
					die('Invalid query: ' . mysql_error());
				}else{
					return $result;
				}
			break;
			case 'count':
				if (!$result) {
					die('Invalid query: ' . mysql_error());
				}else{
					return mysql_num_rows($result);
				}
			break;
		}
	}
	
	/* Function:	  update()                                                                    *\
	 * Description:   Run an 'UPDATE' query defined in $q.                                        *
	 * Parameters:	  $q = Query to be executed.                                                  *
	\* Returns:	      true or false if success                                                    */
	function update($q){
		$result = mysql_query($q);
		if (!$result) {
			return false;
		}else{
			return true;
		}
	}
	
	/* Function:	  insert()                                                                    *\
	 * Description:   Run an 'INSERT' query defined in $q.                                        *
	 * Parameters:	  $q = Query to be executed.                                                  *
	\* Returns:	      It returns the last 'auto_increment' id, or false.                          */
	function insert($q){
		$result = mysql_query($q);
		if (!$result) {
			return 0;
		}else{
			return mysql_insert_id($this->conn);
		}
	}
	
	/* Function:	  delete()                                                                    *\
	 * Description:   Run an 'DELETE' query defined in $q.                                        *
	 * Parameters:	  $q = Query to be executed.                                                  *
	\* Returns:	      true or false if success                                                    */
	function delete($q){
		$result = mysql_query($q);
		if (!$result) {
			return false;
		}else{
			return true;
		}
	}
}
$db = new db();

?>