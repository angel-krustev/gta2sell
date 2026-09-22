<select <?php echo $disabled;?>  name="province" id="province">
<option value='--Please Select State/Province--'>--Please Select State/Province--</option>
<?php
// print state select box
// convert country code to country name
 $countrycode = $_GET['countrycode'];

     if (!$countrycode) { $countrycode = $country; }
     $getcnty = "SELECT * FROM countries WHERE ccode='$countrycode'";
     if( $stmt = $mysqli->prepare($getcnty) ){
        $stmt->execute();
        $resultcnty = $stmt->get_result();
        if( $resultcnty === NULL ){
          err_log('Mysql: [' . $mysqli->error . '] :'.$getcnty ,__FILE__);
          include 'opps-page.php';
        }
     }
     $selectcnty = mysql_fetch_array($resultcnty);
     $cntyname = $selectcnty["ccode"];
         $querystate = "SELECT * FROM states WHERE ccode='$countrycode' ORDER BY name";
         $result = mysql_query($querystate);
         while($row_result = mysql_fetch_array($result)) {
         $statename = $row_result["name"];
         $statecode = $row_result["state_sign"];
         if ($statename) {
         if ($statename!=$province) { echo "<option value='$statename'>$statecode-$statename</option>\n";
         }
         }
         }
         if (!empty($province)) { echo "<option value='$province' selected='selected'>$province</option>\n";
         }
         if (!$statename) {
         if (!empty($cntyname)) {
         echo "<option value='$cntyname' selected='selected'>$cntyname</option>\n";
         }
         }
?>
</select>

