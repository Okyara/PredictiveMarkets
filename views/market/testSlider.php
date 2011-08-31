 <script type='text/javascript' src='http://code.jquery.com/jquery-1.4.2.js'></script>
 <script type='text/javascript' src='../slider.js'></script>
 <link href="../slider.css" rel="stylesheet" type="text/css" />

 <script language="javascript" type="text/javascript">
     function setSliderVal(value, market)
     {        // get the form values
              //var field_a = $('#field_a').val();
              //var field_b = $('#field_b').val();
              
         alert(value);


             $.ajax({
               type: "POST",
               url: "../market/test",
               //data: "firstname="+field_a+"&lastname="+field_b,
               data: "value="+value+"&market="+market,
               success: function(data)
               {
                   alert('div '+market);
                   $("#market" +Id).html(data);

                // we have the response
                 //alert("Oksana Listen, Server said:\n '" + resp + "'");
               },
               error: function(e)
               {
                alert('Error: ' + e);
               }
               });
        }

       
        doAjaxPost();
    </script>
 
First Name:
  <input type="text" id="field_a" value="">
  Last Name:
  <input type="text" id="field_b" value="">
  <input type="button" value="Ajax Request" onClick="doAjaxPost()">

  <div id ="some_div"></div>

 <?foreach ($market_db as $todoitem)
{
//  if ($todoitem['Market']['market_id'] == 26)
 //{?>
      <DIV class=carpe_slider_group>
                <DIV class=carpe_horizontal_slider_display_combo>
                  <DIV class=carpe_slider_display_holder>
                    <!-- Default value: 0 -->
                    <input name="Input" class=carpe_slider_display id="<?=$todoitem['Market']['market_id']?>" value="<?=$todoitem['Market']['slider_val']?>" />
                  </DIV>

                  <DIV class=carpe_horizontal_slider_track >
                    <DIV class=carpe_slider_slit></DIV>
                    <DIV class=carpe_slider id="<?=$todoitem['Market']['market']?>" display="<?=$todoitem['Market']['market_id']?>" style="left:<?=$todoitem['Market']['slider_val']?>px"></DIV>
                  </DIV>
                </DIV>
                <DIV class=carpe_horizontal_slider_display_combo></DIV>
                <DIV class=carpe_horizontal_slider_display_combo></DIV>
                <DIV class=carpe_horizontal_slider_display_combo></DIV>
      </DIV>

<?//}
}
 foreach ($market_db as $todoitem)
 {?>
      <div style="border: 3px coral solid;" id="<?=$todoitem['Market']['market']?>"></div><br/>
 <?}

?>




