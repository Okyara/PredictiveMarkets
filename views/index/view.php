<script  type="text/JavaScript">

    //alert($);

    $(document).ready(function() {
      $('#slideshow').load('market/horizontalViewAll?header=0&signed_request=<?=OKSANA?>');
      
});

</script>
<script src="slider.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function setSliderVal(value)
{
	xmlHttp=getXMLHTTP();
	if (xmlHttp==null)
 	 {
 	 	alert ("Your browser does not support AJAX!");
 		return;
 	 }

	xmlHttp.onreadystatechange=function()
	{
	  if (req.readyState == 4) { // only if "OK"
		if (req.status == 200) {
			//dont do any thing here we just need to save the valued in the database
		} else {
			alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
		}
	}
	var queryString = "?sliderval=" + value.substring(0,value.length-2); //stripping last two letter which is px
	xmlHttp.open("GET","trade/bid/"+queryString+"?signed_request=<?=OKSANA?>" , true);
	xmlHttp.send(null);

}

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{
			try{
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				req = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}

		return xmlhttp;
	}

</script>
    

<style type="text/css">
    #comments td {vertical-align: text-top}
</style>

<div id="screen2">
    <div id="buttons">
                <a class="prev" href="#">Previous</a>
                <a class="next" href="#">Next</a>
                <br class="clear" />
    </div>
    <div id="slideshow">
    </div>
 </div>
 

<!--
<table id="comments">
  <tr>
    <td>
       <script src="http://connect.facebook.net/en_US/all.js#appId=166944470008450&amp;xfbml=1"></script>
        <fb:comments url="http://apps.facebook.com/predictoscar"
                     simple="1"  css="http://www.pullprediction.dreamhosters.com/koko.css?36"
                     title="Predict Oscar" xid="avatar"
                     numposts="3" width="200" publish_feed="true">
        </fb:comments>
   </td>
   <td width="40"/>
    <td>
    <script src="http://connect.facebook.net/en_US/all.js#appId=166944470008450&amp;xfbml=2"></script>
        <fb:comments url="http://apps.facebook.com/predictoscar"
                     simple="1"  css="http://www.pullprediction.dreamhosters.com/koko.css?35"
                     title="Predict Oscar" xid="blackswan"
                     numposts="3" width="200" publish_feed="true">
        </fb:comments>
    </td>
    <td width="40"/>
    <td>
     <script src="http://connect.facebook.net/en_US/all.js#appId=166944470008450&amp;xfbml=3"></script>
        <fb:comments url="http://apps.facebook.com/predictoscar"
                     simple="1"  css="http://www.pullprediction.dreamhosters.com/koko.css?35"
                     title="Predict Oscar" xid="inception"
                     numposts="3" width="200" publish_feed="true">
        </fb:comments>
   </td>
  </tr>
</table>

-->

     





