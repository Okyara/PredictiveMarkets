<?php
/**
 * Description of BidController
 *
 * @author Oksana
 */
class BidController extends Controller{

    function horizontalViewAll()
    {
        $this->set('market_db',$this->_model->selectAll());

    }

    function view($id,$name)
    {
        //$this->set('title',$name.' - My Todo List App');
        $this->set('market_db', $this->_model->selectByID($id));

    }

	function viewall() {

		//$this->set('title','All bidders in my system.');
		$this->set('market_db',$this->_model->selectAll());
	}

	function add() {

                $bidder_id = $_POST['bidder_id'];

		$market    = $_POST['market'];

                $end_date  = $_POST['end_date'];

                $market_classified = 'Category';
                $create_date       = '';
                $initial_ask       = 0.0;
                $initial_bid       = 0.5;
                $shares            = 100;

                //$this->set('title','Success - View my bidders');

		$this->set('market_db',$this->_model->query('insert into market

                            (bidder_id, market_classified, market, create_date, end_date, initial_ask_price,
                             initial_bid_price, shares) values

                (\''.mysql_real_escape_string($bidder_id).'\',
                 \''.mysql_real_escape_string($market_classified).'\',
                 \''.mysql_real_escape_string($market).'\',
                 \''.mysql_real_escape_string($create_date).'\',
                 \''.mysql_real_escape_string($end_date).'\',
                 \''.mysql_real_escape_string($initial_ask).'\',
                 \''.mysql_real_escape_string($initial_bid).'\',
                 \''.mysql_real_escape_string($shares).'\')'));

        }


	function delete($id) {
		$this->set('title','Success - Deleted');
		$this->set('market_db',$this->_model->query('delete from market where market = \''.mysql_real_escape_string($id).'\''));
	}

}
?>
