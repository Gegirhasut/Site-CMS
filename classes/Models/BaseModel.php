<?php
require_once('configs/dbconfig.php');

class Database
{
  private static $db_connect = null;

  private function __construct() {
  }

  public static function connectToDatabase()
  {
    if (!isset(self::$db_connect)) {
      self::$db_connect = mysql_connect(
      $GLOBALS['db_config']['server'],
      $GLOBALS['db_config']['user'],
      $GLOBALS['db_config']['password']
      ) or die ('Error connecting to mysql');

      mysql_select_db($GLOBALS['db_config']['database'], self::$db_connect);
      mysql_set_charset('utf8', self::$db_connect);
    }

    return self::$db_connect;
  }
}

class BaseModel
{
  private static $db_connect = null;

  function executeQuery($query)
  {
      $db_connect = Database::connectToDatabase();
      $result = mysql_query($query, $db_connect);
      if (!$result) {
      	  $mysql_error = mysql_error();
      	  if (strpos($mysql_error, 'Duplicate entry') === false) {
      	  	if ($_SERVER['SERVER_NAME'] == 'localhost') {
          		echo '<b>Could not run query:</b> ' . $query . '<br/><b>Error message</b>: ' . $mysql_error;
      	  	} else {
          		mail('max077@mail.ru', '[arktida] SQL error', $query . print_r($_SERVER, true) . print_r(debug_backtrace(), true) . print_r($_COOKIE, true) );
      	  	}
      	  }
    	  return false;
      }
      return $result;
  }
  
  function _executeQuery($query)
  {
    $db_connect = Database::connectToDatabase();
    $time1 = time();
    $result = $this->executeQuery($query);
    $time2 = time();
    $dtime = $time2 - $time1;
    //echo "$query, time = $dtime<br/>";
    if ($result === false) {
//      echo 'Could not run query: ' . $query . mysql_error();
      exit;
    }
    return $result;
  }
   
  function fetchRow($query)
  {
  		$result = $this->executeQuery($query);
  		$row = mysql_fetch_assoc($result);
  		mysql_free_result($result);
  		return $row;
  }
   
  function fetchAll($query, $identity)
  {
  		$result = $this->_executeQuery($query);
  		$rows = array();

  		while($row = mysql_fetch_assoc($result))
  		{
          if (is_null($identity)) {
  		    $rows[] = $row;
          } else {
            $rows[$row[$identity]] = $row;
          }
  		}
  		mysql_free_result($result);
  		return $rows;
  }
   
  function getInsertedId()
  {
  		$db_connect = Database::connectToDatabase();
  		return mysql_insert_id($db_connect);
  }
   
  function getRowsCount()
  {
    $db_connect = Database::connectToDatabase();
    $result = mysql_query("SELECT FOUND_ROWS()", $db_connect);
    $num_rows = mysql_result($result, 0);
    return $num_rows;
  }
}