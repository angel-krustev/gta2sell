<script type"text/javascript">
var isSmall=false;
var htmlMapList="";
                                if( getScreenSize() != "small" ){
<!-- LARGE SCREEN --!>
htmlMapList += "            <div class=\"uk-grid uk-margin-top-remove\">";
htmlMapList += "               <div class=\"uk-width-2-6\" >";
htmlMapList += "                      <div style=\"height: 450px;\"  id=\"list\" class=\"uk-grid uk-scrollable-text\">";
htmlMapList += "                      </div>";
htmlMapList += "               </div>";
htmlMapList += "               <div class=\"uk-width-4-6\" >";
htmlMapList += "                          <div id=\"map\" style=\"height: 450px;width: 100%\" ></div>";
htmlMapList += "               </div>";
htmlMapList += "               <div class=\"uk-width-6-6\"  >";
htmlMapList += "                            <div id=\"modalList\"></div>";
htmlMapList += "               </div>";
htmlMapList += "            </div>";
<!-- LARGE SCREEN --!>
                             }else{
 
     isSmall=true;
<!-- SMALL SCREEN --!>
htmlMapList += "            <div class=\"uk-grid uk-margin\">";
htmlMapList += "                  <div class=\"uk-width-1-1 uk-row-first\" >";
htmlMapList += "                    <ul class=\"uk-tab\" id=\"v-control\" data-uk-switcher=\"{connect:'#tab-1', swiping: false}\">";
htmlMapList += "                        <li class=\"uk-active\" id=\"tmid\" ><a class=\"uk-text-primary\" href=\"#\">Map</a></li>";
htmlMapList += "                        <li class=\"\" id=\"tlid\"  ><a class=\"uk-text-primary  uk-hidden-small\" href=\"#\">Listing</a></li>";
htmlMapList += "                    </ul>";
htmlMapList += "                   </div>";
htmlMapList += "                   <div class=\"uk-width-1-1 uk-margin-small\">";
htmlMapList += "                     <ul id=\"tab-1\" class=\"uk-switcher\">";
htmlMapList += "                         <li class=\"uk-active\" id=\"mid\">";
htmlMapList += "                         <div id=\"map\" style=\"height:500px;width: 100%\" data-uk-check-display></div>";
htmlMapList += "                         </li>";
htmlMapList += "                         <li class=\"\" id=\"lid\">";
htmlMapList += "                         <div style=\"height: 500px;\" id=\"list\" class=\"uk-grid uk-scrollable-text uk-text-left uk-grid-divider  uk-hidden-small\"></div>";
htmlMapList += "                         </li>";
htmlMapList += "                     </ul>";
htmlMapList += "                   </div>";
htmlMapList += "                   <div class=\"uk-width-1-1\"> ";
htmlMapList += "                     <div id=\"modalList\"></div>";
htmlMapList += "                   </div>";
htmlMapList += "            </div>";
                             }

jQuery("#map-content").html(htmlMapList);

</script>
