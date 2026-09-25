<?php
//email signup ajax call
include '../config/config.php';
include '../config/legacy_helpers.php';
#$test='Y';
#ttp://jv.mooo.com/location_reciever.php?adr_address=%3Cspan%20class=%22street-address%22%3E1185%20King%20St%20W%3C/span%3E,%20%3Cspan%20class=%22locality%22%3EToronto%3C/span%3E,%20%3Cspan%20class=%22region%22%3EON%3C/span%3E%20%3Cspan%20class=%22postal-code%22%3EM6K%203C5%3C/span%3E,%20%3Cspan%20class=%22country-name%22%3ECanada%3C/span%3E&formatted_address=1185 King St W, Toronto, ON M6K 3C5, Canada&name=1185 King St W&scope=GOOGLE&types=street_address&vicinity=Old Toronto&lat=&lat=43.6391994&lng=-79.42560809999998"
function findDivInnerHtml($html, $id){
$pattern = "/<span class=\"".$id."\">(.+?)<\\/span>/";
preg_match($pattern, $html, $matches);
print $matches[1] ;
}
try{
if($_GET['name'] != null && $_GET['name'] != ''  ){
		$myfile = fopen("newfile1.txt", "a+") or die("Unable to open file!");
		fwrite($myfile, $_GET['name'].":".$_GET['types'].":".$_GET['vicinity'].":".$_GET['formatted_address'].":".$_GET['lat'].":".$_GET['lng'].":".$_GET['adr_address']."\n");
		fclose($myfile);
	}
#                  $query = "nsert  n $RES $where $rwhere $twhere $order $lmt $total_rows"  ;
#                  $stmt = $mysqli->prepare($query);
#                if( $s_r != null && $s_r != '' ){
#                  $stmt->bind_param("siiiidddd",$s_r, $bath,$bed, $minp, $maxp, $swlat,$nelat,$nelng,$swlng);
#                }else{
#                  $stmt->bind_param("iiiidddd",$bath,$bed, $minp, $maxp, $swlat,$nelat,$nelng,$swlng);
#                }

}catch(Exception $e){

        die(json_encode(array(
                'error'=>1,
                'message' => $e->getMessage(),
                'str' => $$street_address
        )));
}
?>
