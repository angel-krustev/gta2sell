<?php

$html_error=<<<MSG
                  <div  class="uk-width-medium-1-2"><div class="uk-panel uk-panel-box uk-text-large uk-text-bold">
                                       <p class="uk-text-large">You Haven't saved any properties yet.</p>
                                       <p  class="uk-text-large">To save a property you like - click on the hart sign <i class="uk-icon-heart-o uk-icon-small" style="color: red;"></i> at top of the property page.</p>
                   </div></div>
MSG;

$xmldom = new DOMDocument("1.0");

// Start XML file, create parent node
if ($SEC_LEVEL1 && !verifyFormToken('ilike')) {
    err_log("CSRF detected",__FILE__);
    header("Content-type: text/xml");
                      $node = $xmldom->createElement("results");
                      $parnode = $xmldom->appendChild($node);
                      $node = $xmldom->createElement("result");
                      $newnode = $parnode->appendChild($node);
                      $newnode->setAttribute("liked",$html_error);
                      $newnode->setAttribute("expired",'');

    echo $xmldom->saveXML();
    exit;
}

$likestr = $_POST['ilike'];
err_log($likestr,__FILE__);

if( $likestr != null && $likestr  != '' ){
      $likearr=split(":",$likestr); 
      $a_bind_params=array();
      $a_param_type=array();
      $a_params = array();
      $conditions = "";
      $param_type = '';
      $n = count($likearr);
      for($i = 0; $i < $n; $i++) {
        $mln=split("-",$likearr[$i])[1];
        $a_bind_params[$i]=$mln;
        $param_type .= 's';
        $conditions .= " ml_num = ? OR";
      }
      $a_params[] = & $param_type;

      for($i = 0; $i < $n; $i++) {
        $a_params[] =  & $a_bind_params[$i];
      }
        $conditions=rtrim($conditions,"OR");
        $where="where  $conditions  ";
}else{
      err_log("Missing likelist.",__FILE__);
      header("Content-type: text/xml");
                      $node = $xmldom->createElement("results");
                      $parnode = $xmldom->appendChild($node);
                      $node = $xmldom->createElement("result");
                      $newnode = $parnode->appendChild($node);
                      $newnode->setAttribute("liked",$html_error);
                      $newnode->setAttribute("expired",'');

      echo $xmldom->saveXML();
      exit;
}
$todayd=date("Y-m-d H:i:s");
///////
header("Content-type: text/xml");
$query="select * from $RES $where"; 

if ( $stmt = $mysqli->prepare($query) ){
      call_user_func_array(array($stmt, 'bind_param'),$a_params);
}else{
      err_log('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error,__FILE__);
      header("Content-type: text/xml");
                      $node = $xmldom->createElement("results");
                      $parnode = $xmldom->appendChild($node);
                      $node = $xmldom->createElement("result");
                      $newnode = $parnode->appendChild($node);
                      $newnode->setAttribute("liked",$html_error);
                      $newnode->setAttribute("expired",'');

      echo $xmldom->saveXML();
      exit;
}
/*
*/
if (isset($stmt) && $stmt !== NULL){
        $stmt->execute();
        $result = $stmt->get_result();
        $html="";
        $is_found=false;
        while ($row = $result->fetch_assoc()) {
          // ADD TO XML DOCUMENT NODE
	          $escapedListing=array_map('mysql_real_escape_string', $row);
	          extract($escapedListing);
		         $page_url = "";
		         $full_addr = "";
		         if( $disp_addr == 'Y' ){
		             $full_addr=($apt_num != '')?$addr."_".$apt_num:$addr;
		         }
		         if( $disp_addr != 'Y' || $full_addr == '' ){
		             $page_url = "/".url_cooker($municipality)."-real-estate/".url_cooker($municipality)."/MLS/".$ml_num;
		          }else{
		             $page_url = "/".url_cooker($municipality)."-real-estate/".url_cooker($community)."/".url_cooker($full_addr);
		          }
                        $ipath  = get_path_form_mln($ml_num);
                        $img  = "/rs/250x150/r/retsimages/".$ipath."/image_".$ml_num."_1.jpg";
                        $html .=  '<div id="'.$ml_num.'" class="uk-width-medium-1-3"><div class="uk-panel uk-panel-box">';
                        $html .=  '<h2 class="uk-panel-title"><b>';
                        if( $disp_addr == 'Y' ){ 
                              $html .= $apt_num != ''?$addr.' #'.$apt_num:$addr; 
                        };
                        $html .= '</b>&nbsp;&nbsp;&nbsp;<a href="#" onclick="reflike(\'heart-'.$ml_num.'\',\'likelist\')"  class="uk-icon-small uk-icon-remove" ></a></h2>';
                        $html .= '<ul class="uk-list"><li><a href="'.$page_url.'"><img src="'.$img.'" onerror="imgError(this);"  alt=""/></a></li>';
                        $html .= '<li>Asking: <span class="uk-text-large uk-text-bold">'.money_format('%.0n',$lp_dol).'</span></li><li>Beds: <span class="uk-text-bold">';
                        $html .=  $br;
                        $html .=  ($br_plus > 0 )? "+".$br_plus:''; 
                        $html .=  '</span></li>';
                        $html .=  '<li>Baths: <span class="uk-text-bold">&nbsp;'.$bath_tot.'</li>';
                        $html .=  '<li>For: <span class="uk-text-bold">&nbsp;'.$s_r.'</li>';
                        $html .=  '</ul>';
                        $html .=  '</div>';
                        $html .=  '</div>';
                        $is_found=true; 
                        if (($key = array_search($ml_num, $a_bind_params)) !== FALSE) {
                              unset($a_bind_params[$key]);
                        }
          }
}else{
          $html='<div  class="uk-width-medium-1-3"><div class="uk-panel uk-panel-box"></div</div>';
          header("Content-type: text/xml");
                      $node = $xmldom->createElement("results");
                      $parnode = $xmldom->appendChild($node);
                      $node = $xmldom->createElement("result");
                      $newnode = $parnode->appendChild($node);
                      $newnode->setAttribute("liked",$html_error);
                      $newnode->setAttribute("expired",'');
                      echo $xmldom->saveXML();

}

        if (isset($stmt)){
            $stmt->close();
        };
        if (isset($mysqli)){
            $mysqli->close();
        };
                      if(!$is_found){
                          $html=$html_error;
                      }
                      $expired='';
                      $expiredlist='';
                      foreach ($a_bind_params as $value) {
                        if($value !== null && $value  !=''  ){
                         $expired .= ":".$value ;
                         $expiredlist .= $value."," ;
                        }
                      }
                      if( $expired !=''){
                         $expiredlist=rtrim($expiredlist,",");
                         $expiredmsg= ' <div  class="uk-width-medium-1-2"><div class="uk-panel uk-panel-box uk-text-large uk-text-bold uk-text-warn"><p  class="uk-text-large">The properties with the following MLS# '.$expiredlist.' are expired and  have been removed from the list.</p>';

                      }
                    
		      $node = $xmldom->createElement("results");
		      $parnode = $xmldom->appendChild($node);
		      $node = $xmldom->createElement("result");
		      $newnode = $parnode->appendChild($node);
		      $newnode->setAttribute("liked",$html);
		      $newnode->setAttribute("expired",$expired);
		      $newnode->setAttribute("expiredmsg",$expiredmsg);
		      echo $xmldom->saveXML();
		
?>
