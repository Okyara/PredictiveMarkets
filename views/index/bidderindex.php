<?

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db(DB_NAME, $con);

$result = mysql_query("select money from bidder where f_id = '100001648569863'");
$bidder_money = mysql_fetch_array($result);

if($bidder_money['money'] == null)
{
   $bidder_money = 'You run out of money! Get more credit.';
}
?>
<script  type="text/JavaScript">

    $(document).ready(function() {
    $('#ask_view').load('ask/viewAll?header=0');
    $('#bid_view').load('bid/viewAll?header=0');
    $('#trade_view').load('trade/viewAll?header=0');

});

</script>
<script src="http://code.jquery.com/jquery-1.4.4.js"></script>

<style type="text/css">
  th {text-align: left}
  #order {color: brown}
  #ask_view, #bid_view, #trade_view {border-right:0.1px ridge lightgray;
                                     border-top:0.1px ridge lightgray;}
  #menu {border: 0.1px ridge lightgray;}
  #tac { vertical-align: text-top}
  #container {display: inline-table}

</style>

<div id="container" style="width:100%;">
    <table style="width:30%;">
       <tr>
         <th colspan=2 style="font-size:8px;" align="left">
            Welcome <? echo $_SESSION['SESS_FIRST_NAME'] ?>
         </th>
       </tr>
       <tr>
         <td width=\"50px\" height=\"50px\">
            <img src="https://graph.facebook.com/<? echo $_SESSION['SESS_MEMBER_ID']?>/picture" />
        </td>
        <td style="font-size:8px; vertical-align: top;">
            You have:
            <br/>
            <img src="images/user-money(3).gif" /><?= $bidder_money['money']?>.00
        </td>
      <!--<td rowspan=2 width="500px" style="vertical-align: top;" align="center">
         <!-- <h1 style="font-family: arial; font-size:16px;" align="center">Predict Oscar 2011</h1>-->
          <!--<p style="font-family: arial; font-size:12px;">Predict Oscar 2011 nominations and be the best Predictor among your friends
              <br>Make a bet before poll is closed on January 14, 2011</p>
      </td>-->
       </tr>
    </table>

    <table id="tac" style="width:70%;">
       <tr>
            <th><p>Placed Orders</p></th>
            <th/>
            <th/>
            <th/>
            <th><p>Recent Deals</p></th>
       </tr>
       <tr>
            <th><p id="order">Buy</p></th>
            <th/>
            <th><p id="order">Sell</p></th>
            <th/>
            <th/>
       </tr>
       <tr>
           <td id="activity">
               <div id ="bid_view"></div>
           </td>
           <td width="20px">
               <!--<img src="images/line.png"/>-->
           </td>
           <td id="activity">
               <div id ="ask_view"></div>
           </td>
           <td width="40px">
           <td id="activity">
               <div id ="trade_view"></div>
           </td>
       </tr>
    </table>
</div>