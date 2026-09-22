<?php
#include '../config/config.php';
#include '../config/func.php';
#include '../config/array_column.php';
#require_once 'signup/includes/main.php';

$sorry="Sorry. We don't have enough data to estimate the price of your property.<br> Please change the address, number of bedrooms/baths and etc. and try again. Sorry for the unconvinience.";
// Start XML file, create parent node
#est section
$ulat = htmlspecialchars(isset($_POST['ulat']) && ( is_float($_POST['ulat']) || is_numeric($_POST['ulat']))?$_POST['ulat']:'', ENT_QUOTES);
$ulon = htmlspecialchars(isset($_POST['ulon'])  && ( is_float($_POST['ulon']) || is_numeric($_POST['ulon']))?$_POST['ulon']:'', ENT_QUOTES);
$rtype = htmlspecialchars(isset($_POST['rtype'])?$_POST['rtype']:'', ENT_QUOTES);
$s_r = htmlspecialchars(isset($_POST['s_r'])?$_POST['s_r']:'Sale', ENT_QUOTES);
$addr_info = htmlspecialchars(isset($_POST['addr'])?$_POST['addr']:'-',  ENT_QUOTES);
$is_eml =  htmlspecialchars(isset($_POST['is_eml'])&& $_POST['is_eml'] != '' ?TRUE:FALSE,  ENT_QUOTES);

$bed = htmlspecialchars(isset($_POST['bed']) && is_numeric($_POST['bed'])?$_POST['bed']:'0', ENT_QUOTES);
$bath = htmlspecialchars(isset($_POST['bath']) && is_numeric($_POST['bath'])?$_POST['bath']:'0', ENT_QUOTES);
$isqft = htmlspecialchars(isset($_POST['sqft'])?$_POST['sqft']:'0-0', ENT_QUOTES);
$gar_spaces = htmlspecialchars(isset($_POST['gar_spaces'])?$_POST['gar_spaces']:0, ENT_QUOTES);
$range = htmlspecialchars(isset($_POST['r']) && is_numeric($_POST['r'])?$_POST['r']:.3);
#$ulat='43.566456';

#email section
$tp =  htmlspecialchars($_POST['tp'], ENT_QUOTES);
$em = htmlspecialchars(isset($_POST['em'])?$_POST['em']:'-', ENT_QUOTES);
$fn = htmlspecialchars(isset($_POST['fn'])?$_POST['fn']:'-', ENT_QUOTES);
$cph = htmlspecialchars(isset($_POST['cph'])?$_POST['cph']:'-', ENT_QUOTES);
$msg = htmlspecialchars(isset($_POST['msg'])?$_POST['msg']:'-', ENT_QUOTES);
$type = htmlspecialchars(isset($_POST['type'])?$_POST['type']:'-', ENT_QUOTES);
$landing = htmlspecialchars(isset($_POST['landing'])?$_POST['landing']:'-', ENT_QUOTES);
$frm = htmlspecialchars($_POST['frm'], ENT_QUOTES);
 
#$ulat='43.566456';
#$ulon='-79.693807';
#$ulon='-79.55770129999996';
#$ulat='43.6573378';
#$rtype='house';
#$isqft = '0-1500' ;
#$gar_spaces = 1;
#$bath = 1 ;
#$bed = 1;

$min_lp_dol=$max_lp_dol=0;
$max_gr=$max_br=0;

if ($SEC_LEVEL1 && !verifyFormToken('eform')) {
       $xmldom = new DOMDocument("1.0");
       $node = $xmldom->createElement("results");
       $parnode = $xmldom->appendChild($node);
       $node = $xmldom->createElement("result");
       $newnode = $parnode->appendChild($node);
       $newnode->setAttribute("sale", "");
       $newnode->setAttribute("error", "<h2>Opps. There was an unexpected error.</h2>
                                     <p>Our support team has been notified and is working to fix the issue.<br>Meanwhile you can modify your search criteria and try again...<br>Thank you for your patience.</p>");
       echo $xmldom->saveXML();
       err_log("CSRF detected",__FILE__);
       exit;
}
       err_log("Is_EML:".$is_eml.":",__FILE__);
try{
      if( !empty($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $is_eml ){
        $type = htmlspecialchars(isset($_POST['type'])?$_POST['type']:'-', ENT_QUOTES);
        $landing = htmlspecialchars(isset($_POST['landing'])?$_POST['landing']:'-', ENT_QUOTES);
        $frm = htmlspecialchars($_POST['frm'], ENT_QUOTES);
                #header('Content-type: application/json', ENT_QUOTES);
                if(!isset($tp) ){
                        throw new Exception('Invalid request.');
                }
                if(!isset($msg) || strlen($msg) < 6 ){
                        throw new Exception('Please enter a message.');
                }
                if(!isset($fn) || strlen($fn) < 3 || strlen($fn) > 40  ){
                        throw new Exception('Please enter your name.');
                }
                if(!isset($em) || !filter_var($em, FILTER_VALIDATE_EMAIL) || strlen($fn) > 30  ){
                        throw new Exception('Please enter a valid email.');
                }
                   rate_limit($_SERVER['REMOTE_ADDR']);
                // Record this email attempt
                   rate_limit_tick($_SERVER['REMOTE_ADDR'], $em);

                        $message = '';
                        $subject  = "Estimation Request - ".$addr_info;
                        $message  = get_page_url()."\n\n";
                        $message .= $em."\n\n";
                        $message .= $fn."\n\n";
                        $message .= $cph."\n\n";
                        $message .= $addr_info."\n\n";
                        $message .= $rtype."\n\n";
                        $message .= "Simple request.\n\n";
                                    $message .= $msg;
                        $cem="-";

                        if( isset($_COOKIE[$cookie_name]) ){
                            $cem=base64_decode($_COOKIE[$cookie_name]);
                        }

                        $sid=$_SESSION['tr'];
                        $ip_ra=$_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR']:'-';
                        $ip_fw=$_SERVER['HTTP_X_FORWARDED_FOR']!=''?$_SERVER['HTTP_X_FORWARDED_FOR']:'-';
                        $tracksql = "INSERT INTO TRACKER (session,ip_fw,ip_ra, cookie_email, email,full_name, phone, address, br,bath,gr,sqf,est_p,msg,type,landing) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt = $mysqli->prepare($tracksql);
                        if (isset($stmt) && $stmt !== NULL){
                            $stmt->bind_param("ssssssssssssssss",$sid,$ip_fw,$ip_ra,$cem,$em,$fn,$cph,$addr_info,$bed,$bath,$max_gr,$sqf,$pred_avr,$message,$tp,$landing );
                            if ( ! $stmt->execute()) {
                                    err_log("Error: ".$mysqli->error,__FILE__);
                                    err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                            }

                        }else{
                                    err_log("Error: ".$mysqli->error,__FILE__);
                                    err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                        }

                        $result = send_email($fromEmail, $toEmail, $subject, $message);

                        if(!$result){
                               err_log("There was an error sending estimation email..".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                               # no interuption
                               #throw new Exception("There was an error sending your email. Please try again.");
                        }
                       # $msg = array(
                       #    'error' => 0,
                       #    'message' => 'Your message has been sent. Thank You!'
                       # );
                       #die(json_encode($msg) );
              }else{
                             err_log("Estimation email rejected..".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                       #throw new Exception('There was an error processing your request.');
              }
                                                                                                         
$rStep=.3;
$thresh=5;

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
    $total_rows ="";
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
           $sql  ="   select count(distinct addr) c,avg(lp_dol) average,avg(br) average_br,avg(bath_tot) average_bath,avg(gar_spaces) average_gar_spaces,avg(park_spcs) average_park_spcs, avg(maxsqf) average_maxsqf,avg(dom_sale) average_dom_sale,avg(dom_sold) average_dom_sold from ( ";
           $sql .="   select lp_dol, ml_num, addr,br,bath_tot, front_ft,depth,minsqf,maxsqf , gar_spaces,park_spcs,dom as dom_sale, '' as dom_sold, ( ";
           $sql .="   6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )     * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance FROM RES   $where $twhere ";
           $sql .="   HAVING distance <= $range";
           $sql .="   UNION  ";
           $sql .="   select lp_dol, ml_num, addr,br,bath_tot,front_ft,depth,minsqf,maxsqf,gar_spaces,park_spcs,'' as dom_sale,dom as dom_sold,  ( ";
           $sql .="   6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )  * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance FROM history_res  $where $twhere ";
           $sql .="    HAVING distance <= $range";
           $sql .="   ) t";
           $row=array();
           $row['c']=0;
#echo "\n".$sql;
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
               err_log("Count: ".$row['c']."Average: ".$average." BR:".$average_br." SQF:".$average_maxsqf." Bath:".$average_bath." GR:".$average_gar_spaces ,__FILE__ );
	    }else{
	    err_log("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error.":".$ulat." Lon:".$ulon." Bed:".$bed." Bath:".$bath." G:".$gar_spaces." SQF:".$sqft."  Predicted: ". $sql ,__FILE__ );
                   die(json_encode(array(
                       'error' => 1,
                       'message' =>  $sorry
                    )));

            }
         }while( $row['c'] < $thresh &&  $range < $rStep*20  );
         if($range > $rStep*20 ){
	     err_log("Not enough data - range > ".$rStep*20 ,__FILE__ );
                   die(json_encode(array(
                       'error' => 1,
                       'message' =>  $sorry
                    )));

         } 
               $one_br=$average/$average_br;
               $one_bath=$average/$average_bath;
               $one_maxsqf=$average/$average_maxsqf;
               $one_gar_spaces=$average/$average_gar_spaces;
               $one_pr_spaces=$average/$pr_gar_spaces;
#               $pred_avrg=round(1.05*($one_br*$bed+$one_bath*$bath+$one_maxsqf*$sqft+$one_gar_spaces*$gar_spaces)/4,0);
}else{
       err_log("No lat and long",__FILE__ );
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
           $sql .="   6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )  * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance FROM history_res  $where $twhere ";
           $sql .="  group by (addr)  HAVING distance <= $range";
           $sql .="   ) t";
           #echo "\n".$sql;
        $min_lp_dol=$max_lp_dol=0;
        $max_gr=$max_br=0;
#$rtype='house';
#$isqft = '0-1500' ;
#$gar_spaces = 1;
#$bath = 1 ;
#$bed = 1;

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
          err_log($row['bath_tot']." ". $row['br']." ".$row['gar_spaces'] );
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
    err_log("bed: ".$bed." ".$bath." ".$isqft);
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
       if( $rtype == 'condo'){
           $pred_avrg=round(1.05*($one_br*$med_bed+$one_bath*$med_bath+$one_maxsqf*$med_isqft+$one_pr_spaces*$pr_spaces)/4,0);
       }else{
           $pred_avrg=round(0.9*($one_br*$med_bed+$one_bath*$med_bath+$one_maxsqf*$med_isqft+$one_gar_spaces*$med_gar_spaces)/4,0);
       }
       err_log("Pred weight: Bed:".$one_br." Bath:".$one_bath." Gr:".$one_gar_spaces." SQF:".$one_isqft ,__FILE__ );
       err_log("Pred: ".$pred_avrg." Bed:".$med_bed." Bath:".$med_bath." G:".$med_gar_spaces." SQF:".$med_isqft ,__FILE__ );
       $xmldom = new DOMDocument("1.0");
       $node = $xmldom->createElement("results");
       $parnode = $xmldom->appendChild($node);
       $node = $xmldom->createElement("result");
       $newnode = $parnode->appendChild($node);
       $newnode->setAttribute("average_dom_sold",round($average_dom_sold,0));
       $newnode->setAttribute("average_dom_sale",round($average_dom_sale,0));
       $newnode->setAttribute("sale",bd_nice_number($pred_avrg));
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
       $sid=$_SESSION['tr'];
       $cem="-";
       $landing='-';
       $msg="Estimation event.";
       if( isset($_COOKIE[$cookie_name]) ){
           $cem=base64_decode($_COOKIE[$cookie_name]);
       }

       $ip_ra=$_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR']:'-';
       $ip_fw=$_SERVER['HTTP_X_FORWARDED_FOR']!=''?$_SERVER['HTTP_X_FORWARDED_FOR']:'-';
       $tracksql = "INSERT INTO TRACKER (session,ip_fw,ip_ra,cookie_email, email,full_name, phone, address, br,bath,gr,sqf,est_p,msg,type,landing) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
         $stmt = $mysqli->prepare($tracksql);
           if (isset($stmt) && $stmt !== NULL){
               $stmt->bind_param("ssssssssssssssss",$sid,$ip_fw,$ip_ra,$cem,$em,$fn,$cph,$addr_info,$med_bed,$med_bath,$med_gar_spaces,$med_isqft,$pred_avrg,$msg,$tp,$landing );
               if ( ! $stmt->execute()) {
                   err_log("Error: ".$mysqli->error,__FILE__);
                   die(json_encode(array(
                       'error' => 1,
                       'message' =>  'Sorry. There was an error processing your request. '
                    )));
               }
          }else{
                   err_log("Error: ".$mysqli->error,__FILE__);
                   die(json_encode(array(
                       'error' => 1,
                       'message' =>  'Sorry. There was an error processing your request. '
                    )));
          }

       echo $xmldom->saveXML();
       $mysqli->close();

} catch(Exception $e){
        err_log("Catched Error:". $e->getMessage( ).":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
        die(json_encode(array(
                'error' => 1,
                'message' =>  'Sorry. There was an error processing your request. '
        )));
}

?>
