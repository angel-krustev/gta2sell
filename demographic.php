<?php

if($mysqli->connect_errno > 0){
    err_log('Unable to connect to database [' . $mysqli->connect_error . ']',__FILE__);
    die('Unable to connect to database [' . $mysqli->connect_error . ']');
}
function demoOverView($zip,$colArray,$ot=true){
  global $mysqli;
  $is_first_cycle = true;
  $ret ='';
  $title = "";
  $inString="";
  $oArray = array();
  foreach ($colArray as $i => $value) {
     $inString .="'".$colArray[$i]."',";
  }
    $inString = rtrim($inString, ",");
          $query="select CENSUS_DATA.Total,MASK.Topic,MASK.Characteristic,MASK.col from CENSUS_DATA, MASK,POLY_ZIP  where  ZIP=? and MASK.col in (".$inString.") ";
           if( $ot){
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by CAST(Total as SIGNED INTEGER) desc" ;
          }else{
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by MASK.id" ;
          }
  $stmt = $mysqli->prepare($query);
 if( $stmt !== FALSE ) {
  $stmt->bind_param("s",$zip);
  $stmt->execute();
  $result = $stmt->get_result();
  if( $result != NULL ){
    while ($row = $result->fetch_assoc()) {
       $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);
        extract($escapedListing);
        if( $is_first_cycle ){
               echo "<div class=\"uk-grid\">\n";
               echo "<div class=\"uk-width-1-1\">
               The following demographic information will help you to have an overview of the neighbourhood where this property is located. The demographic data is based on the dissemination area as defined by Statistics Canada. A dissemination area contains, on average, approximately a population of 400 to 700 persons. Data is based on census data from <b>Statistics Canada</b>.
</br>
                </div";
        }
               $oArray[$col]="<div class=\"uk-width-1-2\"><span class=\"uk-text-bold\">".$Characteristic.":</span>&nbsp;".$Total."</div>";
               $is_first_cycle = false;
      }
                                         
    }    
	  foreach ($colArray as $i => $value) {
	     if (isset($oArray[$colArray[$i]]) ){
                 echo $oArray[$colArray[$i]];
             }
	  }
       if( !$is_first_cycle ){
               echo "</div>\n";
       }
  }
}

function drawBarThreshould($zip,$groups,$t=0,$head1='Title',$head2='Count',$ot=FALSE,$width=600,$height=450){
  global $mysqli;
  $aColor=array('#ff0000','#0066ff','#00cc00','#ff6450','#99ff99','#0000ff','#ffff00','#645066','#003366','#005ce6','#006666');
  $cColor = count($aColor);
  $is_first_cycle = true;
  $minThreshould = 0;
  $otherTotal = 0;
  $ret ='';
  $ret_h ='';
  $title = "";
  $n=0;
       if($t > 0){
          $query = "select sum(CENSUS_DATA.Total) as Totalsum from CENSUS_DATA, MASK,POLY_ZIP  where  ZIP=? and MASK.groups=? ";
          $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0" ;
          $stmt = $mysqli->prepare($query);
          if( $stmt !== FALSE ) {
               $stmt->bind_param("ss",$zip,$groups);
               $stmt->execute();
               $result = $stmt->get_result();
                   if ($result != NULL && $row = $result->fetch_assoc() ){
                         $minThreshould = intval (($row['Totalsum']/100)*$t);
                   }
          }

        }
          $query="select CENSUS_DATA.Total,MASK.Topic,MASK.Characteristic from CENSUS_DATA, MASK,POLY_ZIP  where  ZIP=? and MASK.groups=? ";
           if( $ot){
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by CAST(Total as SIGNED INTEGER) desc" ;
          }else{
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by MASK.id" ;
          }

          $stmt = $mysqli->prepare($query);
          if( $stmt !== FALSE ) {
              $stmt->bind_param("ss",$zip,$groups);
              $stmt->execute();
              $result = $stmt->get_result();
             if( $result != NULL ){
               while ($row = $result->fetch_assoc()) {
                     $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);
                     extract($escapedListing);
                     if( $is_first_cycle ){
                        #$title = $Topic;
                        $ret .="google.charts.setOnLoadCallback(drawBarChart);\n";
                        $ret .=" function drawBarChart() {\n";
                        $ret .="  var data = google.visualization.arrayToDataTable([\n";
                        $ret .=" ['".$head1."', '".$head2."', { role: 'style' } ],\n";
                      }
                    if( $Total > $minThreshould ){
                        $ret .= "\n   ['".$Characteristic."',".$Total.", '".$aColor[$n]."'],";
                     }else{
                        $otherTotal=intval($otherTotal+$Total);
                     }
                        $n=$n+1;
                        if($n >= $cColor){
                           $n=0;
                        }
                        $is_first_cycle = false;
                 }
                 if( ! $is_first_cycle ){
                        $ret =  rtrim($ret, ",");
                        $ret .="     ]);\n";
                        $ret .="  var view = new google.visualization.DataView(data);\n";
                        $ret .="  view.setColumns([0, 1,\n";
                        $ret .="  { calc: 'stringify',\n";
                        $ret .="  sourceColumn: 1,\n";
                        $ret .="  type: 'string',\n";
                        $ret .="  role: 'annotation' },\n";
                        $ret .="  2]);\n";
                        $ret .="        var options = {\n";
                        $ret .="          title: '".$title."',\n";
                        $ret .= "         backgroundColor: '#FAFAFA',\n";
                        $ret .="          width: ".$width.",\n";
                        $ret .="          height: ".$height.",\n";
                        $ret .="          bar: {groupWidth: '85%'},\n";
                        $ret .="          legend: { position: 'none' }\n";
                        $ret .="        };\n";
                        $ret .="             var chart = new google.visualization.BarChart(document.getElementById('barchart_values_".$groups."'));\n";
                        $ret .="             chart.draw(view, options);\n";
                        $ret .="}\n";
                  }
                }
              }
     return $ret;
}

function drawChartThreshould($zip,$groups,$t,$ot=true,$width=600,$height=450){
  global $mysqli;
  $is_first_cycle = true;
  $minThreshould = 0;
  $otherTotal = 0;
  $ret ='';
  $title = "";
     if($t > 0){
          $query = "select sum(CENSUS_DATA.Total) as Totalsum from CENSUS_DATA, MASK,POLY_ZIP  where  ZIP=? and MASK.groups=? ";
          $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0" ;
          $stmt = $mysqli->prepare($query);
          if( $stmt !== FALSE ) {
               $stmt->bind_param("ss",$zip,$groups);
               $stmt->execute();
               $result = $stmt->get_result();
                   if ($result != NULL && $row = $result->fetch_assoc() ){
                         $minThreshould = intval (($row['Totalsum']/100)*$t);
                   }
          } 

     }
          $query="select CENSUS_DATA.Total,MASK.Topic,MASK.Characteristic from CENSUS_DATA, MASK,POLY_ZIP  where  ZIP=? and MASK.groups=? ";
           if( $ot){
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by CAST(Total as SIGNED INTEGER) desc" ;
          }else{
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by MASK.id" ;
          }

          $stmt = $mysqli->prepare($query);
          if( $stmt !== FALSE ) {
              $stmt->bind_param("ss",$zip,$groups);
              $stmt->execute();
              $result = $stmt->get_result();
             if( $result != NULL ){
              while ($row = $result->fetch_assoc()) {
                      $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);
                     extract($escapedListing);
                     if( $is_first_cycle ){
                 	#$title = $Topic;
                 	$ret .= " google.charts.setOnLoadCallback(drawChart_".$groups.");\n";
                	$ret .= " function drawChart_".$groups."() { \n"; 
                	$ret .= "   var data = new google.visualization.DataTable(); \n"; 
                	$ret .= "       data.addColumn('string', 'Characteristic'); \n"; 
       	                $ret .= "       data.addColumn('number', 'Total'); \n"; 
                	$ret .= "       data.addRows([ \n";
                     } 
                     if( $Total > $minThreshould ){
                 	$ret .= "\n         ['".$Characteristic."', ".$Total."],";
                     }else{
                        $otherTotal=intval($otherTotal+$Total);
                     }

                     $is_first_cycle = false;
            } 
            if( $otherTotal > 0 ){
                 $ret .= "\n         ['Other', ".$otherTotal."],";
            }
                 if( ! $is_first_cycle ){
        $ret =  rtrim($ret, ",");
       	$ret .= "         ]);\n";
       	$ret .= "   var options = { 'title':'".$title."',\n";
        $ret .= "       is3D: true,\n";
        $ret .= "      backgroundColor: '#FAFAFA',\n";
        $ret .= "      'width':".$width.",\n";
        $ret .= "      'height':".$height."};\n";
        $ret .= "     var chart = new google.visualization.PieChart(document.getElementById('chart_div_".$groups."'));\n";
        $ret .= "     chart.draw(data, options);\n";
        $ret .= "  }\n";
                 }
        }
     }
    return $ret;
}
function drawChart($zip,$groups,$ot=FALSE,$width=600,$height=450){
  global $mysqli;
  $is_first_cycle = true;
  $ret ='';
  $title = "";
          $query="select CENSUS_DATA.Total,MASK.Topic,MASK.Characteristic from CENSUS_DATA, MASK,POLY_ZIP  where  ZIP=? and MASK.groups=? ";
           if( $ot){
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by CAST(Total as SIGNED INTEGER) desc" ;
          }else{
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by MASK.id" ;
          }
  $stmt = $mysqli->prepare($query);
 if( $stmt !== FALSE ) {
  $stmt->bind_param("ss",$zip,$groups);
  $stmt->execute();
  $result = $stmt->get_result();
  if( $result != NULL ){
    while ($row = $result->fetch_assoc()) {
   $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);

        extract($escapedListing);
        if( $is_first_cycle ){
                #$title = $Topic;
                $ret .= " google.charts.setOnLoadCallback(drawChart_".$groups.");\n";
                $ret .= " function drawChart_".$groups."() { \n";
                $ret .= "   var data = new google.visualization.DataTable(); \n";
                $ret .= "       data.addColumn('string', 'Characteristic'); \n";
                $ret .= "       data.addColumn('number', 'Total'); \n";
                $ret .= "       data.addRows([ \n";
        }
        $ret .= "\n         ['".$Characteristic."', ".$Total."],";
        $is_first_cycle = false;
      }
      if( ! $is_first_cycle ){
        $ret =  rtrim($ret, ",");
        $ret .= "         ]);\n";
        $ret .= "   var options = { 'title':'".$title."',\n";
        $ret .= "      'width':".$width.",\n";
        $ret .= "      'height':".$height.",\n";
        $ret .= "      backgroundColor: '#FAFAFA',\n";
        $ret .= "       is3D: true,\n";
        $ret .= "      'legend': 'center'};\n";
        $ret .= "     var chart = new google.visualization.PieChart(document.getElementById('chart_div_".$groups."'));\n";
        $ret .= "     chart.draw(data, options);\n";
        $ret .= "  }\n";
      }
     }
   }
   return $ret;
}
#$array = array(1, 2, 3, 4, 5);
function drawChartList($zip,$colArray,$chn='dc',$ot=true,$width=600,$height=450){
  global $mysqli;
  $is_first_cycle = true;
  $ret ='';
  $title = "";
  $inString="";
  foreach ($colArray as $i => $value) {
     $inString .="'".$colArray[$i]."',";
  }  
    $inString = rtrim($inString, ",");
    $groups = $chn;

          $query="select CENSUS_DATA.Total,MASK.Topic,MASK.Characteristic from CENSUS_DATA, MASK,POLY_ZIP  where  ZIP=? and MASK.col in (".$inString.") ";
           if( $ot){
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by CAST(Total as SIGNED INTEGER) desc" ;
          }else{
             $query .= "and CENSUS_DATA.col = MASK.col and CENSUS_DATA.Geo_Code = POLY_ZIP.DAUID and Total > 0 order by MASK.id" ;
          }
  $stmt = $mysqli->prepare($query);
 if( $stmt !== FALSE ) {
  $stmt->bind_param("s",$zip);
  $stmt->execute();
  $result = $stmt->get_result();
  if( $result != NULL ){
     while ($row = $result->fetch_array()) {

       $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);
        extract($escapedListing);
        if( $is_first_cycle ){
                #$title = $Topic;
                $ret .= " google.charts.setOnLoadCallback(drawChart_".$groups.");\n";
                $ret .= " function drawChart_".$groups."() { \n";
                $ret .= "   var data = new google.visualization.DataTable(); \n";
                $ret .= "       data.addColumn('string', 'Characteristic'); \n";
                $ret .= "       data.addColumn('number', 'Total'); \n";
                $ret .= "       data.addRows([ \n";
        }
        $ret .= "\n         ['".$Characteristic."', ".$Total."],";
        $is_first_cycle = false;
      }
       if( ! $is_first_cycle ){
        $ret =  rtrim($ret, ",");
        $ret .= "         ]);\n";
        $ret .= "   var options = { 'title':'".$title."',\n";
        $ret .= "      width:".$width.",\n";
        $ret .= "      height:".$height.",\n";
        $ret .= "      backgroundColor: '#FAFAFA',\n";
        $ret .= "      is3D: true,\n";
        $ret .= "      legend: 'center'};\n";
        $ret .= "     var chart = new google.visualization.PieChart(document.getElementById('chart_div_".$groups."'));\n";
        $ret .= "     chart.draw(data, options);\n";
        $ret .= "  }\n";
      }
     }
   }
   return $ret;
}

?>
    <!--Div that will hold the pie chart-->
    <div class="uk-width-1-1" >
    	<div class="uk-panel uk-panel-box uk-panel-header">
        	<h3 class="uk-panel-title" ><b>Overview</b></h3>
                 <?php $ovArray = array('po1','po7','po4','ag17','ag18','fa18','ho44'); ?>
                 <?php demoOverView($zip,$ovArray,$ot=false); ?>

    	</div>
    </div>

    <div class="uk-small-remove uk-width-1-1"> &nbsp; </div>
    <div class="uk-width-1-1" align="center" >
         <div class="uk-panel uk-panel-box "  >
                    <h3 class="uk-panel-title"  ><b>Detailed Mother Tongue</b></h3>
                    <div align="center" id="chart_div_det2">&nbsp;</div>
         </div>
    </div>
    <div class="uk-small-remove uk-width-1-1"> &nbsp; </div>
    <div class="uk-width-1-1" align="center" >
         <div class="uk-panel uk-panel-box "  >
                    <h3 class="uk-panel-title"  ><b>Mother tongue - Summary</b></h3>
                    <div align="center" id="chart_div_dc">&nbsp;</div>
         </div>
    </div>

    <div class="uk-small-remove uk-width-1-1"> &nbsp; </div>
    <div class="uk-width-1-1" align="center">
         <div class="uk-panel uk-panel-box uk-panel-header">
        	    <h3 class="uk-panel-title"  ><b>Marital Status</b></h3>
     		    <div align="center" id="chart_div_ma"></div>
         </div>
    </div>
    
    <div class="uk-small-remove uk-width-1-1"> &nbsp; </div>
    <div class="uk-width-1-1" align="center">
         <div class="uk-panel uk-panel-box">
        	    <h3 class="uk-panel-title"  ><b>Family Size</b></h3>
                    <div class="uk-width-1-1" align="center" id="chart_div_fa1">&nbsp;</div>
         </div>
    </div>

    <div class="uk-small-remove uk-width-1-1"> &nbsp; </div>
    <div class="uk-width-1-1" align="center">
         <div class="uk-panel uk-panel-box">
                    <h3 class="uk-panel-title"  ><b>Total children in families in private households</b></h3>
                    <div align="center" id="chart_div_fa2">&nbsp;</div>
         </div>
    </div>

    <div class="uk-small-remove uk-width-1-1"> &nbsp; </div>
    <div class="uk-width-1-1" align="center">
         <div class="uk-panel uk-panel-box">
        	    <h3 class="uk-panel-title"  ><b>Total population by age groups</b></h3>
                    <div align="center" id="barchart_values_ag">&nbsp;</div> 
         </div>
    </div>

    <div class="uk-small-remove uk-width-1-1"> &nbsp; </div>
    <div class="uk-width-1-1" align="center">
         <div class="uk-panel uk-panel-box">
        	    <h3 class="uk-panel-title"  ><b>Knowledge of official languages</b></h3>
                    <div  align="center" id="chart_div_kn">&nbsp;</div>
         </div>
    </div>

     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
     <script type="text/javascript">
      google.charts.load("current", {packages:['table', 'gauge', 'corechart']});
      <?php echo drawChart($zip,'ma',true);?>
      <?php echo drawChart($zip,'fa1');?>
      <?php echo drawChart($zip,'fa2');?>
      <?php echo drawChart($zip,'kn',true);?>
      <?php echo drawBarThreshould($zip,'ag');?>
      <?php $colArray = array('det45','det56','det67','det9','det10','det12'); ?>
      <?php echo drawChartList($zip,$colArray,'dc',true,600,450);?>
      <?php echo drawChartThreshould($zip,'det2',2,true);?>
     </script>
