<?php

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(DB_NAME, $con);

if(isset($trade))
{

?>

<table style="text-align: center">
  <tr>
    <th colspan="4" style="font-family: arial; font-size:12px;">
      <?echo '<p>'.$title.'</p>'?>
      <br/>
    </th>
  </tr>
  <tr>
      <td></td>
      <td style="text-align: left; font-family: arial; font-size:12px;">
            Movie
      </td>
      <td style="text-align: left; font-family: arial; font-size:12px;">
            Deal
      </td>
      <td style="text-align: left; font-family: arial; font-size:12px;">
            Cost
      </td>
  </tr>
  <tr>
    <? $number = 0?>
      <? foreach ($market_db as $todoitem):?>
      <td width="50px" height="50px">
            <img src='https://graph.facebook.com/<?$todoitem['Trade']['buyer_id']?>/picture/'>
      </td>
      <td style="font-family: arial; font-size:12px;">
            <? $result = mysql_query("select f_name from bidder where bidder_id = '".$todoitem['Trade']['buyer_id']."' ") ?>
            <? $name = mysql_fetch_array($result)?>
            <?     echo "<p>".$name[0]."..................................</p>
                    </td>
                    <td>
                         <p>".$todoitem['Trade']['traded_shares']."................................</p>
                    </td>
                    <td>
                         <p>".$todoitem['Trade']['trade_price']."</p>
                    </td>"
            ?>
    </tr>
 <?php endforeach?>
 </table>
  
<?
}
else
{
    echo'
        <br/>
        <p><a class="big" target="_top" href="' . $facebook->getLoginUrl(array('next'=>APP_ROOT_URL)) . '>
        Your ask successfully placed. Click here to go back.
        </a></p>';
}

?>



