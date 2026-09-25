<?php
$DefaultTitle='404 - Not Found';
 header( "HTTP/1.1 404 Not Found" );
include 'header.php';
include 'nav-main.php';
?>

          <div class="uk-container uk-container-center uk-grid-medium uk-padding-remove"  > 
<?php 
include 'opps-page.php';
?>
          </div>
<?php 
include 'footer.php';
?>
