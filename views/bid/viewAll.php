<style type="text/css">
  td {font-family: arial; font-size:12px;
       vertical-align: text-bottom}
</style>
<?
//register index to trace over images.
$i=0;

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

echo'<table>
    <tr style="font-family: arial; font-size:12px;" align="left">
          <td>Movie</td>
          <td>Deal</td>
          <td>Cost</td>
    <tr>';

foreach ($market_db as $todoitem):
 
  if($_SESSION['SESS_MEMBER_ID'] ==  $todoitem['Bid']['bidder_id'])
  {
  ?>
      <tr>
        <td>
            <!--Read a movie image-->
            <? foreach($img_arr as $img):
                 if($img == $todoitem['Bid']['market'])
                  {
                     echo"<img src='images/movies/".$img."' width='30' height='40' />
                          ........";
                     $i++;
                  }
              endforeach;
            ?>
        </td>
        <td>
              <?echo $todoitem['Bid']['bid_qty']?>
                          ........
        </td>
        <td>
             <?echo $todoitem['Bid']['bid_price']?>
        </td>
     </tr>
<?
    }//end if
    
   endforeach;
  }//end if open dir.
?>
