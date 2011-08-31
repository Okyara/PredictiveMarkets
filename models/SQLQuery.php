<?php

/**
 *The connect() and disconnect() functions are fairly standard so I will not get
 *into too much detail. Let me specifically talk about the query class. Line 48
 *first executes the query. Let me consider an example. Suppose our SQL Query is
 *something like:
 *SELECT table1.field1 , table1.field2, table2.field3, table2.field4 FROM table1,
 *table2 WHERE ….
 *Now what our script does is first find out all the output fields and their
 *corresponding tables and place them in arrays - $field and $table at the same
 *index value. For our above example, $table and $field will look like

$field = array(field1,field2,field3,field4);
$table = array(table1,table1,table2,table2);

  The script then fetches all the rows, and converts the table to a Model name
 *(i.e. removes the plural and capitalizes the first letter) and places it in
 *our multi-dimensional array and returns the result. The result is of the form
 *$var['modelName']['fieldName']. This style of output makes it easy for us to
 *include db elements in our views.
 *
 */

require_once (ROOT . DS . 'PMarket\Application' . DS . 'models' . DS . 'Template.class.php');

class SQLQuery {

    protected $_dbHandle;
    protected $_result;

    /** Connects to database **/

    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = @mysql_connect($address, $account, $pwd);
        if ($this->_dbHandle != 0) {
            if (mysql_select_db($name, $this->_dbHandle)) {
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    /** Disconnects from database **/

    function disconnect() {
        if (@mysql_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }

    function selectAll()
    {
        $query = 'select * from `'.$this->_table.'`';

         return $this->query($query);
    }

    function selectByID($passed_id)
    {
        $id = '_id';
        $special_id = $this->_table.$id;

        //print($special_id);
    	$query = 'select * from `'.$this->_table.'` where `'.$special_id.'` = \''.mysql_real_escape_string($passed_id).'\'';

    	return $this->query($query, 1);
    }

    function selectByLogin($login) {

        //echo $id;
    	$query = 'select * from `'.$this->_table.'` where login = \''.mysql_real_escape_string($login).'\'';

        //print_r($this->query($query, 1));

        return $this->query($query, 1);
    }

    /** Custom SQL Query **/

	function query($query, $singleResult = 0) {

		$this->_result = mysql_query($query, $this->_dbHandle);

                if (mysql_errno() != 0) {
                        throw new Exception("mysql error: " . mysql_error() . " - sql = " . $query);
                }

		if (preg_match("/select/i",$query)) {
		$result = array();
		$table = array();
		$field = array();
		$tempResults = array();
		$numOfFields = mysql_num_fields($this->_result);
		for ($i = 0; $i < $numOfFields; ++$i) {
		    array_push($table,mysql_field_table($this->_result, $i));
		    array_push($field,mysql_field_name($this->_result, $i));
		}

			while ($row = mysql_fetch_row($this->_result)) {
				for ($i = 0;$i < $numOfFields; ++$i) {

                                       // $table[$i] = trim(ucfirst($table[$i]),"s");
					$table[$i] = trim(ucfirst($table[$i]));
                                        
					$tempResults[$table[$i]][$field[$i]] = $row[$i];
				}
				if ($singleResult == 1) {
		 			mysql_free_result($this->_result);
					return $tempResults;
				}
				array_push($result,$tempResults);
			}
			mysql_free_result($this->_result);

                       return($result);
		}

	}

    /** Get number of rows **/
    function getNumRows() {
        return mysql_num_rows($this->_result);
    }

    /** Free resources allocated by a query **/

    function freeResult() {
        mysql_free_result($this->_result);
    }

    /** Get error string **/

    function getError() {
        return mysql_error($this->_dbHandle);
    }
}
