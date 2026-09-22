<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('connect.php')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javaScript" type="text/javascript">
function getXMLHTTP() { //function to return the xml http object
      var xmlhttp=false;   
      try{
         xmlhttp=new XMLHttpRequest();
      }
      catch(e)   {     
         try{         
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
         }
         catch(e){
            try{
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch(e1){
               xmlhttp=false;
            }
         }
      }
         
      return xmlhttp;
    }

function getState(codeId)
{
   var strURL="statecall.php?countrycode="+codeId;
   var req = getXMLHTTP();
   if (req)
   {
     req.onreadystatechange = function()
     {
      if (req.readyState == 4)
      {
    // only if "OK"
    if (req.status == 200)
         {
       document.getElementById('statediv').innerHTML=req.responseText;
    } else {
         alert("There was a problem while using XMLHTTP:\n" + req.statusText);
    }
       }
      }
   req.open("GET", strURL, true);
   req.send(null);
   }
}
</script>
<title>Untitled Document</title>
</head>

<body>
<tr>
      <td align="left" valign="middle"><label for="country">State:&nbsp;&nbsp;</label>
        <select name="country" id="country" onChange="getState(this.value);">
          <option value="--Please Select Country--">--Please Select Country--</option>
      <?php  // print category combo box
         $sql = "SELECT name , ccode FROM countries ORDER BY name ASC";
         $result = mysql_query($sql);
         while ($result_row = mysql_fetch_array($result)) {
         $cname = $result_row["name"];
         $cid = $result_row["ccode"];
         echo "<option value='$cid'";
         if ($usercountry==$cid) { echo " selected='selected'";
         }
         echo ">$cname</option>\n";
         }
         ?>
     </select>&nbsp;&nbsp;<font face="Geneva, Arial, Helvetica, sans-serif" color="#FF0000"><b>R</b></font></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><label for="state">&nbsp;State:&nbsp;&nbsp;</label><div id="statediv"><?php include('statecall.php'); ?></div></td>
    </tr>
</body>

</html>
