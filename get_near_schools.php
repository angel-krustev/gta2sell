<?php
if($mysqli->connect_errno > 0){
    err_log('Unable to connect to database [' . $mysqli->connect_error . ']',__FILE__);
    die('Unable to connect to database [' . $mysqli->connect_error . ']');
}

$SCHOOLS="ONTARIO_SCHOOLS";
$SCHOOL_TYPE=array("Public","Catholic","Protestant Separate","Provincial");
$SCHOOL_LEVEL=array("Elementary","Secondary","Elem/Sec");
$SCHOOL_SPECIAL=" School_Special_Conditions_Code in ('Not applicable','Junior High School')";

if (is_decimal($lat) && is_decimal($lon) ){
      echo "<div class=\"uk-grid\">\n";
          for ($j=0;$j<count($SCHOOL_LEVEL);$j++){ 
             for ($i=0;$i<count($SCHOOL_TYPE);$i++){ 
                 $where = " where School_Type='".$SCHOOL_TYPE[$i]."' and School_Level='".$SCHOOL_LEVEL[$j]."' and lat <> '' and lon <> '' and $SCHOOL_SPECIAL ";
                 // Postgres folds unquoted identifiers to lowercase; quote the aliases so the
                 // returned column names keep the exact case extract() below relies on.
                 $query = "select * from ( select School_Name AS \"School_Name\",School_Level AS \"School_Level\",Board_Name AS \"Board_Name\", ( 6372 * acos( cos( radians($lat) ) * cos( radians( lat::double precision ) )     * cos( radians(lon::double precision) - radians($lon)) + sin(radians($lat))     * sin( radians(lat::double precision)))) AS distance  FROM $SCHOOLS   $where ) sub WHERE distance <= $radiusSCH ";
   if( $stmt = $mysqli->prepare($query) ){
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include 'opps-page.php';
       }
   }


 while ($row = $result->fetch_array()) {

   $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);

                               extract($escapedListing);
                               echo "<div class=\"uk-width-2-5 uk-text-bold\">". $School_Name."</div><div class=\"uk-width-1-5\">".$School_Level."</div><div class=\"uk-width-2-5\">".$Board_Name."</div>\n";
                        }
              }#SCHOOL_LEVEL
           }#SCHOOL_TYPE
       
     echo "		<div class=\"uk-width-1-1\">&nbsp;</div>\n";
     echo "		<div class=\"uk-width-1-1\">\n";
     echo "	             <div class=\"uk-alert uk-text-small\">\n";
     echo	      	         "The listed schools are within the closest distance to the property. However, it doesn't mean the property is in the boundaties of these schools.";
     echo	      	         "<br>Please check in the respective school or school board if the property is in the bounbdaries of the desired school.";
     echo "		     </div>\n";
     echo "		</div>\n";
     echo "</div>\n";
}
#| Field                          | Type             | Null | Key | Default | Extra          |
#| id                             | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
#| Region                         | varchar(34)      | NO   |     |         |                |
#| Board_Number                   | varchar(7)       | NO   |     |         |                |
#| Board_Name                     | varchar(46)      | NO   |     |         |                |
#| Board_Type                     | varchar(28)      | NO   |     |         |                |
#| Board_Language                 | varchar(8)       | NO   |     |         |                |
#| School_Number                  | varchar(7)       | NO   |     |         |                |
#| School_Name                    | varchar(78)      | NO   |     |         |                |
#| School_Level                   | varchar(11)      | NO   |     |         |                |
#| School_Language                | varchar(8)       | NO   |     |         |                |
#| School_Type                    | varchar(20)      | NO   |     |         |                |
#| School_Special_Conditions_Code | varchar(27)      | NO   |     |         |                |
#| Suite                          | varchar(40)      | NO   |     |         |                |
#| PO_Box                         | varchar(20)      | NO   |     |         |                |
#| Street                         | varchar(35)      | NO   |     |         |                |
#| City                           | varchar(20)      | NO   |     |         |                |
#| Province                       | varchar(8)       | NO   |     |         |                |
#| Postal_Code                    | varchar(7)       | NO   | MUL |         |                |
#| Phone                          | varchar(13)      | NO   |     |         |                |
#| Fax                            | varchar(13)      | NO   |     |         |                |
#| Grade_Range                    | varchar(21)      | NO   |     |         |                |
#| Date_Open                      | varchar(19)      | NO   |     |         |                |
#| Principals_First_Name          | varchar(18)      | NO   |     |         |                |
#| Principals_Last_Name           | varchar(22)      | NO   |     |         |                |
#| Email                          | varchar(50)      | NO   |     |         |                |
#| lat                            | varchar(20)      | NO   | MUL |         |                |
#| lon                            | varchar(20)      | NO  
