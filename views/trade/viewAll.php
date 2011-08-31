<style type="text/css">
  td {font-family: arial; font-size:12px;
          vertical-align: text-bottom}
</style>

<?

$i = 0;

if ($handle = opendir('images/movies') )
{
  while (false !== ($file = readdir($handle)))
  {
    //place images inside the array.
    if ($file != "." && $file != "..")
    {
        $img_arr[$i] = $file;
        $i++;
    }
  }

//Reset index. This index will be used for tracing the array on images.
$i=0;

?>

<table>
  <tr align="left">
    <td>Movie</td>
    <td>Deal</td>
    <td>Cost</td>
  </tr>

<!--Display group trades-->
<? if($group != null)
{
     foreach($group as $row):

     if($_SESSION['SESS_MEMBER_ID'] ==  $row['Trade']['seller_id']) { ?>
  <tr>
    <td>
        <!--Read a movie image-->
        <? foreach($img_arr as $img):
             if($img ==$row['Trade']['market'])
              {
                echo"<img src='images/movies/".$img."' width='30' height='40' />
                      ........";
                $i++;
              }
           endforeach;
        ?>
    </td>
    <td>
           <? echo $row['']['sum(traded_shares)']."........"?>
    </td>
    <td>  
           <? echo $row['']['sum(trade_price)']." <p style=\"color:red\">Group trade</p>" ?>
           
    </td>
 </tr>
<?
     }//end if
   endforeach;
}//end if group != null

   //Dispaly single trades.
   foreach($market_db as $row):

     if($_SESSION['SESS_MEMBER_ID'] == $row['Trade']['seller_id']) { ?>
   
  <tr>
    <td>
        <!--Read a movie image-->
        <? foreach($img_arr as $img):
             if($img == $row['Trade']['market'])
              {
                echo"<img src='images/movies/".$img."' width='30' height='40' />
                      ........";
                $i++;
              }
           endforeach;
        ?>
    </td>
    <td>
           <?echo $row['Trade']['traded_shares']."........"?>
    </td>
    <td>
           <? echo $row['Trade']['trade_price']."<p style=\"color:blue\">Single trade</p>"?>
    </td>
</tr>
<?
       }//end if
   endforeach;
}//end if open dir.
?>

</table>

