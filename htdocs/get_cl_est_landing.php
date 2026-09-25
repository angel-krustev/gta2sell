<?php
#include '../config/config.php';
#include '../config/legacy_helpers.php';
#include '../config/array_column.php';
#require_once 'signup/includes/main.php';
#$_POST['tk']="19b0843e0fc7cd8ce7415c3e0e6d098e8c5b1946";
#$_POST['tk']="e669ed717549598757f338d83b1d2059ab216764";
#$_POST="";
#$cashback=.0075; # 30%
$cashback=.005; # 20%
#$cashback=.003752; # 15%
#$cashback=.0025; # 10%
$_SERVER['HTTP_X_REQUESTED_WITH']="-";
$MBACK=3;
$sorry="Sorry. We don't have enough data to estimate the price of your property.<br> Please change the address, number of bedrooms/baths and etc. and try again. Sorry for the unconvinience.";
// Start XML file, create parent node
#est section
if( !isset($_POST['tk']) || strlen ($_POST['tk']) != 40 ){
               die(" Sorry, this link has expired. Please submit the evaluation request again.");
} 
       $g_token = $_POST['tk'];
       $query = "select count(*) c from evaluations where token = ? ";
       if ($cstmt = $mysqli->prepare($query) ){
           $cstmt->bind_param('s',$g_token);
       }
       $cstmt->execute();
       $result = $cstmt->get_result();
       if ($erow = $result->fetch_assoc()) {
          if( $erow['c'] <> 1 ){
              ?>
               <script type="text/javascript"> setTimeout("window.location='<?php echo $base_url.'/404' ?>'",10); </script>
              <?php
               die("Sorry, this link has expired. Please submit the  evaluation request again.");
          }
       }

     $query = "select * from evaluations where token = ? ";
     if ($cstmt = $mysqli->prepare($query) ){
           $cstmt->bind_param('s',$g_token);
     }
     $cstmt->execute();
     $result = $cstmt->get_result();

if ($erow = $result->fetch_assoc()) {

                $ulat = htmlspecialchars(isset($erow['lat']) && ( is_float($erow['lat']) || is_numeric($erow['lat']))?$erow['lat']:'', ENT_QUOTES);
                $ulon = htmlspecialchars(isset($erow['lon'])  && ( is_float($erow['lon']) || is_numeric($erow['lon']))?$erow['lon']:'', ENT_QUOTES);
                $rtype = htmlspecialchars(isset($erow['type'])?$erow['type']:'', ENT_QUOTES);
                $s_r = htmlspecialchars(isset($erow['s_r'])?$erow['s_r']:'Sale', ENT_QUOTES);
                $addr_info = htmlspecialchars(isset($erow['address'])?$erow['address']:'',  ENT_QUOTES);
                $bed = htmlspecialchars(isset($erow['br']) && is_numeric($erow['br'])?$erow['br']:'0', ENT_QUOTES);
                $bath = htmlspecialchars(isset($erow['bath']) && is_numeric($erow['bath'])?$erow['bath']:'0', ENT_QUOTES);
                $isqft = htmlspecialchars(isset($erow['sqf'])?$erow['sqf']:'500-500', ENT_QUOTES);
                $pr_spaces= $gar_spaces = htmlspecialchars(isset($erow['gr'])?$erow['gr']:0, ENT_QUOTES);
                #  type_own_srch in ('T.','E.', 'W.', '2.' , 'C.' ,'P.','T.','H.') ";
                $range=.3;
                #$ulat='43.566456';
                
                #email section
                $tp =  htmlspecialchars($erow['tp'], ENT_QUOTES);
                $em = htmlspecialchars(isset($erow['em'])?$erow['em']:'-', ENT_QUOTES);
                $fn = htmlspecialchars(isset($erow['fn'])?$erow['fn']:'-', ENT_QUOTES);
                $cph = htmlspecialchars(isset($erow['cph'])?$erow['cph']:'-', ENT_QUOTES);
                $msg = htmlspecialchars(isset($erow['msg'])?$erow['msg']:'Call back request in regards of interest in customized price estimation of a property for sale.', ENT_QUOTES);
                $type = htmlspecialchars(isset($erow['type'])?$erow['type']:'-', ENT_QUOTES);
                $frm = htmlspecialchars($erow['frm'], ENT_QUOTES);
               # $na='n/a'; 
               # $ulat='43.566456';
                #$ulon='-79.693807';
                #$ulon='-79.55770129999996';
                #$ulat='43.6573378';
               # $rtype='house';
               # $isqft = '0-1500' ;
                #$gar_spaces = 1;
                #$bath = 1 ;
                #$bed = 1;
                $min_lp_dol=$max_lp_dol=0;
                $max_gr=$max_br=0;
                $sqft='500';
               $sqfArray=preg_split('/[^a-z0-9]/i', $isqft);
                $val0=$sqft=0;
                if(is_numeric(trim($sqfArray[0])) ){
                  $val0=$sqfArray[0];
                }
                if(is_numeric(trim($sqfArray[1])) ){
                  $sqft=$sqfArray[1];
                }
                if($sqft > 0 && $val0 > 0 ){
                 if($val0 > $sqft){
                    $val=$val0 ;
                    $val0=$sqft;
                    $sqft=$val ;
                 }
                }else if($val0 > 0){
                     $sqft=$val0;
                     $val0=0;
                }


try{
      if( !isset($ulat)  || !isset($ulon) || !isset($addr_info) || $addr_info  == '' ){
                         err_log("No lat , long, addr",__FILE__ );
                         $xmldom = new DOMDocument("1.0");
                         $node = $xmldom->createElement("results");
                         $parnode = $xmldom->appendChild($node);
                         $node = $xmldom->createElement("result");
                         $newnode = $parnode->appendChild($node);
                         $newnode->setAttribute("sale", "");
                         $newnode->setAttribute("error", "Please enter a valid address.");
                         echo $xmldom->saveXML();
                         exit;
      }


      if( !empty($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) ){
        $err="";
                        rate_limit($_SERVER['REMOTE_ADDR']);
                        rate_limit_tick($_SERVER['REMOTE_ADDR'], $em);

                        #$result = send_email($fromEmail, $toEmail, $subject, $message);

                        if(!$result){
                                    err_log("No results.".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$isqft.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                                    $xmldom = new DOMDocument("1.0");
                                    $node = $xmldom->createElement("results");
                                    $parnode = $xmldom->appendChild($node);
                                    $node = $xmldom->createElement("result");
                                    $newnode = $parnode->appendChild($node);
                                    $newnode->setAttribute("sale", "");
                                    $newnode->setAttribute("error",".");
                                    $newnode->setAttribute("error","There is not enough data for this address. Please try with different address or try later.");
                                    echo $xmldom->saveXML();
                                    exit;

                        }
              }else{
                             err_log("Contact email skipped.".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$isqft.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
              }
                                                                                                         
$rStep=.3;
$thresh=5;

    $total_rows ="";
    $bwhere=" and created >= DATE_SUB(CURDATE(), INTERVAL $MBACK month) ";
    $twhere="";
    include 'rtype.php';
    if($s_r == 'Sale'){
        $where="where s_r='Sale'  and maxsqf > 0  and br > 0 and bath_tot > 0 and lp_dol > 80000 ";
    }else{
        $where="where s_r='Lease' and maxsqf > 0 and br > 0 and  bath_tot > 0 and lp_dol > 40 ";
    }

     if( $stmt = $mysqli->prepare($sql) ){
        $todayd=date("Y-m-d H:i:s");
        $stmt->execute();
        $result = $stmt->get_result();
     }
if( $ulat !='' && $ulon != ''){
        $Xt=array();
        $X=array();
        $h=array();
        $ht=array();
        $average=0;
        $average_br=0;
        $average_bath=0;
        $average_maxsqf=0;
        $average_gar_spaces=0;
        $average_pr_spaces=0;
        $average_dom_sold=0;
        $average_dom_sale=0;
         do{
           $range=$range+$rStep;
           $sql  ="   select count(distinct addr) c,avg(lp_dol) average,avg(br) average_br,avg(bath_tot) average_bath,avg(gar_spaces) average_gar_spaces,avg(park_spcs) average_pr_spaces, avg(maxsqf) average_maxsqf,avg(dom_sale) average_dom_sale,avg(dom_sold) average_dom_sold from ( ";
           $sql .="   select lp_dol, ml_num, addr,br,bath_tot, front_ft,depth,minsqf,maxsqf , gar_spaces,park_spcs,dom as dom_sale, '' as dom_sold, ( ";
           $sql .="   6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )     * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance FROM RES   $where $twhere ";
           $sql .="   HAVING distance <= $range";
           $sql .="   UNION  ";
           $sql .="   select lp_dol, ml_num, addr,br,bath_tot,front_ft,depth,minsqf,maxsqf,gar_spaces,park_spcs,'' as dom_sale,dom as dom_sold,  ( ";
           $sql .="   6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )  * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance FROM history_res  $where $twhere $bwhere";
           $sql .="    HAVING distance <= $range";
           $sql .="   ) t";
           $row=array();
           $row['c']=0;
           if( $stmt = $mysqli->prepare($sql) ){
               $stmt->execute();
               $result = $stmt->get_result();
               $row = $result->fetch_assoc() ;
               $average=round($row['average'],0);
               $average_br=round($row['average_br'],0);
               $average_bath=round($row['average_bath'],0);
               $average_maxsqf=round($row['average_maxsqf'],0);
               $average_gar_spaces=$row['average_gar_spaces'];
               $average_pr_spaces=$row['average_pr_spaces'];
               $average_dom_sold=$row['average_dom_sold'];
               $average_dom_sale=$row['average_dom_sale'];
               err_log("Count: ".$row['c']." Average: ".$average." BR:".$average_br." SQF:".$average_maxsqf." Bath:".$average_bath." GR:".$average_gar_spaces,$average_pr_spaces ,__FILE__ );
	    }else{
               err_log("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error.":".$ulat." Lon:".$ulon." Bed:".$bed." Bath:".$bath." G:".$gar_spaces." SQF:".$isqft." SQL:".$sql ,__FILE__ );
                         $xmldom = new DOMDocument("1.0");
                         $node = $xmldom->createElement("results");
                         $parnode = $xmldom->appendChild($node);
                         $node = $xmldom->createElement("result");
                         $newnode = $parnode->appendChild($node);
                         $newnode->setAttribute("sale", "");
                         $newnode->setAttribute("error","Sorry1. There was unexpected error. Our support team is notified. Please try again later.");
                         echo $xmldom->saveXML();
                         exit;


            }
         }while( $row['c'] < $thresh &&  $range < $rStep*20  );
         if($range > $rStep*20 ){
	     err_log("Not enough data - range > ".$rStep*20 ,__FILE__ );
                         $xmldom = new DOMDocument("1.0");
                         $node = $xmldom->createElement("results");
                         $parnode = $xmldom->appendChild($node);
                         $node = $xmldom->createElement("result");
                         $newnode = $parnode->appendChild($node);
                         $newnode->setAttribute("sale", "");
                         $newnode->setAttribute("error","There is not enough data for this address. Please change the address and try again later.");
                         echo $xmldom->saveXML();
                         exit;

         } 
               $one_br=$average_br!=0?$average/$average_br:0;
               $one_bath=$average_bath!=0?$average/$average_bath:0;
               $one_maxsqf=$average_maxsqf!=0?$average/$average_maxsqf:0;
               $one_gar_spaces=$average_gar_spaces!=0?$average/$average_gar_spaces:0;
               $one_pr_spaces=$average_pr_spaces!=0?$average/$average_pr_spaces:0;
}else{
       err_log("missing lat,long,addr",__FILE__ );
       $xmldom = new DOMDocument("1.0");
       $node = $xmldom->createElement("results");
       $parnode = $xmldom->appendChild($node);
       $node = $xmldom->createElement("result");
       $newnode = $parnode->appendChild($node);
       $newnode->setAttribute("sale", "");
       $newnode->setAttribute("error","Please enter a valid address.");
       echo $xmldom->saveXML();
       exit;
} 
           $sql  ="   select * from ( ";
           $sql .="   select lp_dol, ml_num, addr,br,bath_tot, front_ft,depth,minsqf,maxsqf ,gar_spaces,park_spcs, ( ";
           $sql .="   6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )     * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance FROM RES   $where $twhere ";
           $sql .="   group by (addr)  HAVING distance <= $range";
           $sql .="   UNION  ";
           $sql .="   select lp_dol, ml_num, addr,br,bath_tot,front_ft,depth,minsqf,maxsqf,gar_spaces,park_spcs, ( ";
           $sql .="   6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )  * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance FROM history_res  $where $twhere $bwhere ";
           $sql .="  group by (addr)  HAVING distance <= $range";
           $sql .="   ) t";
        $min_lp_dol=$max_lp_dol=0;
        $max_gr=$max_br=0;
	$isqft_array = array();
	$bath_array = array();
	$bed_array = array();
	$gar_spaces_array = array();
	$park_spcs_array = array();

     if( $stmt = $mysqli->prepare($sql) ){
        $todayd=date("Y-m-d H:i:s");
        $stmt->execute();
        $result = $stmt->get_result();
        $br_result="[['Beds','Price'],";
        $bath_result="[['Baths','Price'],";
        $gr_result="[['Garage','Price'],";
        while ($row = $result->fetch_assoc() ){
          $br_result .= "[".$row['br'].",".$row['lp_dol']."],";
          $bath_result .= "[".$row['bath_tot'].",".$row['lp_dol']."],";
          $gr_result .= "[".$row['gar_spaces'].",".$row['lp_dol']."],";
          $park_spcs .= "[".$row['park_spcs'].",".$row['lp_dol']."],";
          $bath_array[] = $row['bath_tot'];
          $bed_array[] = $row['br'];
          $gar_spaces_array[] =  $row['gar_spaces'];
          $park_spcs_array[] =  $row['park_spcs'];
          $isqft_array[] = round(( $row['minsqf'] + $row['maxsqf'] )/2 );
          if($max_bath_tot < $row['bath_tot'] ){
               $max_bath_tot = $row['bath_tot'] ;
          }
          if($max_br < $row['br'] ){
               $max_br = $row['br'] ;
          }
          if($max_gr < $row['gar_spaces'] ){
               $max_gr = $row['gar_spaces'] ;
          }
          if($max_pr < $row['park_spcs'] ){
               $max_pr = $row['park_spcs'] ;
          }
          if($max_lp_dol < $row['lp_dol'] ){
               $max_lp_dol = $row['lp_dol'] ;
          }
        }
       $br_result=rtrim($br_result, ",");
       $br_result.="]";
       $bath_result=rtrim($bath_result, ",");
       $bath_result.="]";
       $gr_result=rtrim($gr_result, ",");
       $gr_result.="]";
       $pr_result=rtrim($pr_result, ",");
       $pr_result.="]";
      }
    if( $bed == 0 || $bath  == 0 || $isqft == '0-0' ){
       $med_bed = round(calculate_median($bed_array),0,PHP_ROUND_HALF_DOWN);
       $med_bath = round(calculate_median($bath_array),0,PHP_ROUND_HALF_DOWN);
       $med_isqft = round(calculate_median($isqft_array),0,PHP_ROUND_HALF_DOWN);
       $med_gar_spaces = round(calculate_median($gar_spaces_array),0,PHP_ROUND_HALF_DOWN);
       $med_pr_spaces = round(calculate_median($park_spcs_array),0,PHP_ROUND_HALF_DOWN);
    }else{
       $med_bed = $bed;
       $med_bath = $bath ;
       $med_pr_spaces = $med_gar_spaces  = $gar_spaces ;
       $sqfArray=preg_split('/[^a-z0-9]/i', $isqft);
       $val0=$sqft=0;
       if(is_numeric(trim($sqfArray[0])) ){
            $val0=$sqfArray[0];
       }
       if(is_numeric(trim($sqfArray[1])) ){
            $sqft=$sqfArray[1];
       }
       if($sqft > 0 && $val0 > 0 ){
       if($val0 > $sqft){
            $val=$val0 ;
            $val0=$sqft;
            $sqft=$val ;
       }
       }else if($val0 > 0){
            $sqft=$val0;
       }
       $med_isqft = $sqft;

    }
       if( $rtype == 'condo' || $rtype == 'condo-townhouse'){
           $pred_avrg=round(1.05*($one_br*$med_bed+$one_bath*$med_bath+$one_maxsqf*$med_isqft+$one_pr_spaces*$med_pr_spaces)/4,0);
       }else{
           $pred_avrg=round(0.9*($one_br*$med_bed+$one_bath*$med_bath+$one_maxsqf*$med_isqft+$one_gar_spaces*$med_gar_spaces)/4,0);
       }
       $cb=($pred_avrg > 500000 )?round($pred_avrg*$cashback,-2):1000; 
       err_log("Estimation: SID:".$_SESSION['tr']." Type:".$rtype." Predicted:".$pred_avrg." CASHBACK: ".$cb." Email:".$em." Addr:".$addr_info." Lat:".$ulat." Lon:".$ulon." Bed:".$bed." Bath:".$bath." G:".$gar_spaces." ".$pr_spaces." SQF:".$sqft. " :".$one_pr_spaces ,__FILE__ );
       $xmldom = new DOMDocument("1.0");
       $node = $xmldom->createElement("results");
       $parnode = $xmldom->appendChild($node);
       $node = $xmldom->createElement("result");
       $newnode = $parnode->appendChild($node);
       $newnode->setAttribute("average_dom_sold",round($average_dom_sold,0));
       $newnode->setAttribute("average_dom_sale",round($average_dom_sale,0));
       $newnode->setAttribute("sale",bd_nice_number($pred_avrg));
       $newnode->setAttribute("cashback",bd_nice_number($cb)  );
       $newnode->setAttribute("max_lp_dol",$max_lp_dol);
       $newnode->setAttribute("max_br",$max_br);
       $newnode->setAttribute("max_bath_tot",$max_bath_tot);
       $newnode->setAttribute("max_gar_spaces",round($max_gr,0));
       $newnode->setAttribute("brData",$br_result);
       $newnode->setAttribute("bathData",$bath_result);
       $newnode->setAttribute("grData",$gr_result);
       $newnode->setAttribute("rtype",$rtype);
       $newnode->setAttribute("addr",$addr_info);
       $newnode->setAttribute("med_bed",$med_bed);
       $newnode->setAttribute("med_bath",$med_bath);
       $newnode->setAttribute("med_isqft",$med_isqft);
       $newnode->setAttribute("med_gar_spaces",$med_gar_spaces);
       $newnode->setAttribute("email",$erow['email']);
       $newnode->setAttribute("full_name",$erow['full_name']);
       $newnode->setAttribute("phone",$erow['phone']);
       $newnode->setAttribute("address",$erow['address']);
       $newnode->setAttribute("br",$erow['br']);
       $newnode->setAttribute("bath",$erow['bath']);
       $newnode->setAttribute("gr",$erow['gr']);
       $newnode->setAttribute("sqf",$erow['sqf']);
       $newnode->setAttribute("type",$erow['type']);
       $newnode->setAttribute("planing",$erow['planing']);
       $newnode->setAttribute("token",$erow['token']);
       echo $xmldom->saveXML();
       $mysqli->close();

} catch(Exception $e){
        err_log("Catched Error:". $e->getMessage( ).":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$isqft.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                   $xmldom = new DOMDocument("1.0");
                   $node = $xmldom->createElement("results");
                   $parnode = $xmldom->appendChild($node);
                   $node = $xmldom->createElement("result");
                   $newnode = $parnode->appendChild($node);
                   $newnode->setAttribute("sale", "");
                   $newnode->setAttribute("error","Sorry2. There was unexpected error. Our support team is notified. Please try again later.");
                   echo $xmldom->saveXML();
                   exit;

}

}else{
                   err_log("Error: ".$mysqli->error,__FILE__);
                   $xmldom = new DOMDocument("1.0");
                   $node = $xmldom->createElement("results");
                   $parnode = $xmldom->appendChild($node);
                   $node = $xmldom->createElement("result");
                   $newnode = $parnode->appendChild($node);
                   $newnode->setAttribute("sale", "");
                   $newnode->setAttribute("error","Sorry3. There was unexpected error. Our support team is notified. Please try again later.");
                   echo $xmldom->saveXML();
                   exit;
}


?>
