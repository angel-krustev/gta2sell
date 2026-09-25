<?php
include '../../config/config.php';
include '../../config/legacy_helpers.php';
$FEAT="FEATURED";
// print state select box
// convert country code to country name
$smax=0;
$sorder=0;
$ostring="";
         $squery = "SELECT ml_num,addr,lorder FROM $FEAT order by lorder DESC ";
         $sresult = mysql_query($squery);
         while( $row_result = mysql_fetch_array($sresult)) {
           $sml_num = $row_result["ml_num"];
           $saddr = $row_result["addr"];
           $sorder = $row_result["lorder"];
           if( $smax <= $sorder) { 
                     $smax=$sorder+1;
           }
            $ostring .= "\n<option value='$sorder' >$sorder</option>";
         }
            echo "<option value='$smax' selected='selected'>Top</option>\n";
            echo $ostring;
            echo "<option value='0' selected='selected'>Bottom</option>\n";
?>
