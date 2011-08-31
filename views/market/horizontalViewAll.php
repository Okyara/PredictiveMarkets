<script type='text/javascript' src='init.js'></script>
<link href="slider.css" rel="stylesheet" type="text/css" />

<ul>

<?

$i = 0;

if ($handle = opendir('images/movies') )
{
  while (false !== ($file = readdir($handle)))
  {
    if ($file != "." && $file != "..")
    {
        $img_arr[$i] = $file;
        $i++;
        //echo $i;
    }
  }

$i = 0;

 foreach ($market_db as $todoitem)
 {
     $date = new DateTime($todoitem['Market']['end_date']);

  ?>
     <li>
         <span>
        <!--<? foreach($img_arr as $img):
             if($img == $todoitem['Market']['market'])
             {?>
                <a href="<?=$todoitem['Market']['imdb']?>" target="_blank">
                   
                    <img src='images/movies/<?=$img?>' width='100' height='150' />
                    
                </a>

              <?}
           endforeach;
         ?>-->

         <DIV class=carpe_slider_group style="display: inline; float: left;">
                <DIV class=carpe_vertical_slider_display_combo>
                  <DIV class=carpe_slider_display_holder>
                    <!-- Default value: 0 -->
                    <input name="Input" class=carpe_slider_display id="display1" value="<? echo $todoitem['Market']['slider_val']?>" />
                  </DIV>
                  <DIV class=carpe_vertical_slider_track>
                    <DIV class=carpe_slider_slit></DIV>
                    <DIV class=carpe_slider id=slider1 display="display1" style="top:<?=$todoitem['Market']['slider_val']?>px"></DIV>
                  </DIV>
                </DIV>
                <DIV class=carpe_vertical_slider_display_combo></DIV>
                <DIV class=carpe_vertical_slider_display_combo></DIV>
                <DIV class=carpe_vertical_slider_display_combo></DIV>
         </DIV>
             </span>

     </li>
 <?

  }//foreach
}//if

?>
</ul>
        
   
 