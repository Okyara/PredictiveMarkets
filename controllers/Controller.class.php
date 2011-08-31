<?php
/**
 * Description of controller
 *
 * @author Oksana
 */

class Controller {

	protected $_model;
	protected $_controller;
	protected $_action;
	protected $_template;

        

	function __construct($modelName, $controller, $action)
        {
            $model=null;

                if($modelName && $modelName != "Index")
                {
                   // echo"--$modelName--";

                    $model = new $modelName();
                    
                    $this->_controller = $controller;
                    $this->_action = $action;
                    $this->_model = $model;
                    $this->_template = new Template($controller,$action);
                }else
                {
                    $this->_controller = $controller;
                    $this->_action = $action;
                    $this->_model = $model;
                    $this->_template = new Template($controller,$action);
                }
        }

	function set($name,$value) {
		$this->_template->set($name,$value);
	}

	function __destruct() {
			$this->_template->render();
	}

}//end of class controller
?>
