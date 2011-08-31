<?php

require_once (ROOT . DS . 'PMarket' . DS . 'config' . DS . 'config.php');

class BidderController extends Controller {


	function view($id,$name)
        {
               // echo "model is: " . $this->_model->select($id);
               // exit;
		//$this->set('title',$name.'Register');
		$this->set('market_db', $this->_model->selectByID($id));
                //$this->set('market_db',$this->bidder->select($id));
                //$this->set('market_db',$this->_model->selectAll());


	}

	function viewall() {

		$this->set('title','All bidders in my system.');
		$this->set('market_db',$this->_model->selectAll());
	}

	function add($login, $password) {

		$this->set('title','Success - View my bidders');

		$this->set('market_db',$this->_model->query('insert into bidder (login, password, money) values
                    
                (\''.mysql_real_escape_string($login).'\',
                 \''.mysql_real_escape_string($password).'\',
                 \''.mysql_real_escape_string(1000).'\')'));

        }


	function delete($id) {
		$this->set('title','Success - Deleted');
		$this->set('market_db',$this->_model->query('delete from bidder where bidder_id = \''.mysql_real_escape_string($id).'\''));
	}

        function login ()
        {
            //Start session
            //session_start();

           // session_cache_limiter('private');
           //$cache_limiter = session_cache_limiter();


            //Array to store validation errors
            $errmsg_arr = array ();

            //Validation error flag
            $errflag = false;

            //Sanitize the POST values
            $userid = $_POST['userid'];
            $password = $_POST['password'];

            //Input Validations
            if ($userid == '') {

                $errmsg_arr[] = 'Login ID missing';
                $errflag = true;
            }
            if ($password == '') {

                $errmsg_arr[] = 'Password missing';
                $errflag = true;
            }

           //If there are input validations, redirect back to the login form
           if ($errflag) {

               $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
               session_write_close();
               header("location: index.php");
               exit ();
            }

            //Create query
            $result = $this->_model->selectByLogin($userid);


            //Check whether the query was successful or not
            if ($result) {

                //Login Successful
                //session_regenerate_id();

                $_SESSION['SESS_MEMBER_ID'] = $result['Bidder']['bidder_id'];

                //echo $_SESSION['SESS_MEMBER_ID'];
                $_SESSION['SESS_FIRST_NAME'] = $result['Bidder']['login'];
                $_SESSION['SESS_LAST_NAME'] = $result['Bidder']['l_name'];

                session_write_close();

               // $this->set('market_db', $this->_model->selectByLogin($userid));

                header("location: ../");
                exit ();

            } else {
                
               // header("location: login-failed.php");
               // exit ();
        }

   }//end login

   function logout()
   {
        // destroy current session
        session_destroy();

        header("location: ../");
               
   }//end logout

   function register()
   {

       function clean($str) {
	$str = @ trim($str);
	if (get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
        }

        $login       = clean($_POST['login']);
        $password    = clean($_POST['password']);
        $re_password = clean($_POST['re_password']);

       

	if ($login=='')
	{
		$errors[] = 'Username is required.';

	}else if (!ctype_alpha($login)){

                $errors[] = 'Username must be alpha-numeric';
        }

	if ($password=='')
	{
		$errors[] = 'A password is required';

	}else if (ctype_alpha($password)){

                $errors[] = 'A password must be alpha-numeric';
        }

	if ($password != $re_password)
	{
		$errors[] = 'The two passwords must match';
	}

         $this->add($login, $password);

          header("location: ../");
          exit ();


   }//register

}

?>
