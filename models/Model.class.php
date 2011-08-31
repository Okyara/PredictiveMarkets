<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model
 *
 * @author Oksana
 */
require_once (ROOT . DS . 'PMarket\Application' . DS . 'models' . DS . 'SQLQuery.php');

class Model extends SQLQuery {

	protected $_model;

	function __construct() {

		$this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$this->_model = get_class($this);
                $this->_table = strtolower($this->_model);
	}

	function __destruct() {
	}

}
?>
