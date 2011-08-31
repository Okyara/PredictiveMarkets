<?php
/**
 * Description of TradeController
 *
 * @author Oksana
 */

class TradeController extends Controller
{
   function bid($market, $end_date)
   {
       
        $bid_qty = $_POST['bid_qty'];
        $bid_price = $_POST['bid_price'];

        $bidder_id = $_SESSION['SESS_MEMBER_ID'];

        $count = 0;

        //generate random number which will be used to indicate a group_trade on trades.
        //Example: the generate drand value is 15. We executed three  trades. Each
        //trade stores a group_trade = 15 so when we need to generate a group_trade we will search
        //for matching value of group_trade field.
        $group_trade = rand(0, 1000);

        //check if trade can be executed.
        $ask_result = $this->_model->query("select * from ask where market='$market'
                                            and ask_price <= $bid_price order by ask_price, order_time");

        //print_r($ask_result);

        if($ask_result != null)
        {
          // echo"inside if there are results";

           foreach ($ask_result as $row)
           {
              if($count != $bid_qty)
              {
                 if($row['Ask']['ask_qty'] == $bid_qty - $count )
                 {
                     $this->doTrade($row['Ask']['bidder_id'], $bidder_id, $market,
                                    $row['Ask']['ask_price'], $row['Ask']['ask_qty'], $group_trade);

                     //remove this record from the ask table.
                     $delete_from_ask = $this->_model->query("delete from ask
                                                where
                                                ask_id='".$row['Ask']['ask_id']."'");

                     //$count = $count + ($ask_qty - $count);
                     $count = $bid_qty;

                    // echo "case 1: $count, ";



                }else if($row['Ask']['ask_qty'] > $bid_qty - $count){


                    $this->doTrade($row['Ask']['bidder_id'], $bidder_id, $market,
                                    $row['Ask']['ask_price'], $bid_qty-$count, $group_trade);

                     //update number of shares fo rthis record in the ask table.
                     $update_ask = $this->_model->query("update ask
                                           set ask_qty = ask_qty - ('$bid_qty'-'$count')
                                           where ask_id='".$row['Ask']['ask_id']."'");

                     //$count = $count + ($ask_qty - $count);
                       $count = $bid_qty;

                     //echo "case 2: $count, ";


                }else if($row['Ask']['ask_qty'] < $bid_qty - $count){


                      $this->doTrade($bidder_id, $row['Ask']['bidder_id'], $market,
                                     $row['Ask']['ask_price'], $row['Ask']['ask_qty'], $group_trade);

                      //remove ask record from the ask table.
                      $delete_from_ask = $this->_model->query("delete from ask
                                                 where ask_id='".$row['Ask']['ask_id']."'");

                      $count = $count + $row['Ask']['ask_qty'];

                      //echo "Case 3: $count, ";


                 }//else if
             }//end if(($count != $ask_qty))
         }//end for loop
    }//end outter if

    //-----------------partially traded----------------------------------------
    if ($count != 0 && $count != $bid_qty)
    {
      $qty = $bid_qty - $count;

      //insert into the bid table
      $bid_result = $this->_model->query("insert into bid (bidder_id, market, bid_price, bid_qty, expire_time)
                                          values
                                          ('$bidder_id','$market', '$bid_price', '$qty', '$end_date') ");

       //Output trade information to the view. The $count = number of shares traded at this time.
       $this->set('title', 'You just bought '.$count.' Oscars and '.$qty.' more are in the queue.');
       $this->viewCurrentTrades($market);

    //-----------------trade did not execute------------------------------------
    }else if ($count == 0)
    {
       //insert into the bid table
       $bid_result = $this->_model->query("insert into bid
                                           (bidder_id, market, bid_price, bid_qty, expire_time)
                                           values
                                           ('$bidder_id','$market', '$bid_price', '$bid_qty', '$end_date') ");

       $this->set('title', 'You placed '.$bid_qty.' Oscars in the queue.');
    }
    //------------------You have exchanged all shares---------------------------
    if($count == $bid_qty)
    {
       //Output trade information to the view.
       $this->set('title', 'You bought '.$count.' Oscars.');
       $this->viewCurrentTrades($market);

    }//end if


}//end bid



   function add($seller_id, $bidder_id, $market, $trade_price, $traded_shares, $group_trade)
   {
         //echo"$seller_id,  $bidder_id,  $market,  $trade_price,  $traded_shares";

         $this->set('market_db',$this->_model->query

        ('insert into trade (seller_id, buyer_id, market, trade_price, traded_shares, group_trade)
         values

        (\''.mysql_real_escape_string($seller_id).'\',
         \''.mysql_real_escape_string($bidder_id).'\',
         \''.mysql_real_escape_string($market).'\',
         \''.mysql_real_escape_string($trade_price).'\',
         \''.mysql_real_escape_string($traded_shares).'\',
         \''.mysql_real_escape_string($group_trade).'\')'));


    }//end add



    function ask($market, $end_date)
    {
    $ask_qty = $_POST['ask_qty'];
    $ask_price = $_POST['ask_price'];
    $bidder_id = $_SESSION['SESS_MEMBER_ID'];

    //register count variable.
    $count = 0;

    //generate random number which will be used to indicate a group_trade on trades.
    //Example: the generate drand value is 15. We executed three  trades. Each
    //trade stores a group_trade = 15 so when we need to generate a group_trade we will search
    //for matching value of group_trade field.
    $group_trade = rand(0, 1000000);

    //fetch record from the bid table.
    $bid_result = $this->_model->query("select * from bid 
                                        where
                                        market='$market'
                                        and
                                        bid_price >= '$ask_price'
                                        order by
                                        bid_price DESC, order_time");
   
    if($bid_result != null)
    {
      foreach ($bid_result as $row)
      {
        if($count != $ask_qty)
        {
         if($row['Bid']['bid_qty'] == $ask_qty - $count )
         {
             $this->doTrade($bidder_id, $row['Bid']['bidder_id'], $market,
                            $row['Bid']['bid_price'], $row['Bid']['bid_qty'], $group_trade);

             //remove this record from the bid table.
             $delete_from_bid = $this->_model->query("delete from bid
                                        where
                                        bid_id='".$row['Bid']['bid_id']."'");
             $count = $ask_qty;

         }else if($row['Bid']['bid_qty'] > $ask_qty - $count){

            $this->doTrade($bidder_id, $row['Bid']['bidder_id'], $market,
                            $row['Bid']['bid_price'], $ask_qty-$count, $group_trade);

             //update number of shares fo rthis record in the bid table.
             $update_bid = $this->_model->query("update bid
                                   set bid_qty = bid_qty - ('$ask_qty'-'$count')
                                   where bid_id='".$row['Bid']['bid_id']."'");
             $count = $ask_qty;

          }else if($row['Bid']['bid_qty'] < $ask_qty - $count){

             $this->doTrade($bidder_id, $row['Bid']['bidder_id'], $market,
                            $row['Bid']['bid_price'], $row['Bid']['bid_qty'], $group_trade);

              //remove bid record from the bid table.
              $delete_from_bid = $this->_model->query("delete from bid
                                         where bid_id='".$row['Bid']['bid_id']."'");

              $count = $count + $row['Bid']['bid_qty'];
           }//else if
         }//end if(($count != $ask_qty))
       }//end for loop
    }//end outter if

    
    //-----------------partially traded----------------------------------------
    if ($count != 0 && $count != $ask_qty)
    {
      $qty = $ask_qty - $count;

      //insert into the ask table
      $ask_result = $this->_model->query("insert into ask (bidder_id, market, ask_price, ask_qty, expire_time)
                                          values
                                          ('$bidder_id','$market', '$ask_price', '$qty', '$end_date') ");

       //Output trade information to the view. The $count = number of shares traded at this time.
       $this->set('title', 'You just sold '.$count.' Oscars and '.$qty.' more are in the queue.');
       $this->viewCurrentTrades($market);
   
    //-----------------trade did not execute------------------------------------
    }else if ($count == 0)
    {
       //insert into the ask table
       $ask_result = $this->_model->query("insert into ask
                                           (bidder_id, market, ask_price, ask_qty, expire_time)
                                           values
                                           ('$bidder_id','$market', '$ask_price', '$ask_qty', '$end_date') ");

       $this->set('title', $ask_qty.' Oscars are in the queue.');
    }
    //------------------You have exchanged all shares---------------------------
    if($count == $ask_qty)
    {
       //Output trade information to the view.
       $this->set('title', 'You just sold '.$count.' Oscars.');
       $this->viewCurrentTrades($market);
       
    }//end if
   
     
}//end ask function


function doTrade($seller_id, $buyer_id, $market, $price, $qty, $group_trade)
{
   //add into trade table
   $this->add($seller_id, $buyer_id, $market, $price, $qty, $group_trade);

   //update trade price in the market table
   $update_price = $this->_model->query("update market
                                         set
                                         initial_bid_price = '$price'
                                         where market='$market'");

   //update number of shares in the market table.
   $update_shares = $this->_model->query("update market
                                          set
                                          shares = '$qty'
                                          where market='$market'");

 }//end doTrade


 function viewCurrentTrades($market)
 {
     $this->set('trade','ture');
     $this->set('market_db', $this->_model->query("select * from trade
                                                where
                                                seller_id = '".$_SESSION['SESS_MEMBER_ID']."'
                                                and market = '$market'
                                                and trade_time = NOW()"));
 }//end viewCurrentTrades.

 function viewAll()
 {
   //find single trades. One - to - one
   $this->set('market_db', $this->_model->query("select traded_shares, 
                                                         trade_price,
                                                         group_trade, 
                                                         seller_id, 
                                                         buyer_id, 
                                                         market, 
                                                         trade_time,  
                                                 COUNT(group_trade) AS NumOccurrences 
                                                 FROM trade group by group_trade 
                                                 HAVING ( COUNT(group_trade) = '1');"));

   //find group trades. One - to - many
   $this->set('group', $this->_model->query("select sum(traded_shares),
                                                    sum(trade_price),
                                                    group_trade,
                                                    seller_id,
                                                    buyer_id,
                                                    market,
                                                    trade_time,
                                             COUNT(group_trade) AS NumOccurrences
                                             FROM trade group by group_trade
                                             HAVING ( COUNT(group_trade) > '1')"));

 }

  function delete($id)
  {
	$this->set('title','Success - Deleted');
	$this->set('market_db',$this->_model->query('delete from trade where bidder_id = \''.mysql_real_escape_string($id).'\''));
  
  }//end delete



}//end class

?>
