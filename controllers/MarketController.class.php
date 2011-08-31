<?php
/**
 * Description of Market
 *
 * @author Oksana
 */
class MarketController extends Controller
{
    function testSlider()
    {
        $this->set('market_db',$this->_model->selectAll());
    }

    function test()
    {
        echo $_POST['value'];
      /*
       if( $_POST['firstname'] != "undefined" &&  $_POST['lastname'] != "undefined")
       {
            echo "Hey {$_POST['firstname']} {$_POST['lastname']},
                               you rock!";
        }
       *
       */
       //if(isset($_GET['firstname']) &&  isset($_GET['lastname']))
       //{
        //    echo "Hey {$_GET['firstname']} {$_GET['lastname']},
        //                     you rock!";
       //}

    }//test
    
    function horizontalViewAll()
    {
        $this->set('market_db',$this->_model->selectAll());

    }
    
    function view($id)
    {
        //$this->set('title',$name.' - My Todo List App');
        $this->set('market_db', $this->_model->selectByID($id));

    }

    function viewall($queryString)
    {
        //$this->set('title','All bidders in my system.');
        $this->set('market_db',$this->_model->selectAll());
    }

    function add()
    {
        $bidder_id = $_SESSION['SESS_MEMBER_ID'];

        $market    = $_POST['market'];

        $end_date  = $_POST['end_date'];

        $market_classified = 'Category';

        $initial_ask       = 0.0;
        $initial_bid       = 0.5;
        $shares            = 0;

        //$this->set('title','Success - View my bidders');

        $this->set('market_db',$this->_model->query('insert into market

                  (bidder_id, market_classified, market, end_date, initial_ask_price,
                  initial_bid_price, shares) values

        (\''.mysql_real_escape_string($bidder_id).'\',
         \''.mysql_real_escape_string($market_classified).'\',
         \''.mysql_real_escape_string($market).'\',
         \''.mysql_real_escape_string($end_date).'\',
         \''.mysql_real_escape_string($initial_ask).'\',
         \''.mysql_real_escape_string($initial_bid).'\',
         \''.mysql_real_escape_string($shares).'\')'));

    }


    function delete($market)
    {
            $this->set('title','Success - Deleted');
            $this->set('market_db',$this->_model->query('delete from market where market = \''.mysql_real_escape_string($market).'\''));
    }

}
?>
