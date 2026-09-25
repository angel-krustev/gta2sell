<script type="text/javascript" >
                                if( getScreenSize() != "small" ){
</script>
<!-- LARGE SCREEN --!>
            <div class="uk-grid uk-margin-top-remove">
               <div class="uk-width-6-6 uk-margin-left uk-margin-small-bottom uk-text-left" >
                     <?php include 'social-line.php' ?>
               </div>
               <div class="uk-width-2-6" >
                      <div style="height: 450px;"  id="list" class="uk-grid uk-scrollable-text">
                      </div>
               </div>
               <div class="uk-width-4-6" >
                          <div id="map" style="height: 450px;width: 100%" ></div>
               </div>
               <div class="uk-width-6-6"  >
                            <div id="modalList"></div>
               </div>
            </div>
<!-- LARGE SCREEN --!>
<script type="text/javascript" >
                             }else{
</script>

<!-- SMALL SCREEN --!>
            <div class="uk-grid uk-margin">
                  <div class="uk-width-1-1 uk-row-first" >
                    <ul class="uk-tab" data-uk-switcher="{connect:'#tab-1', animation:'fade'}">
                        <li class="uk-active" id="tmid" ><a class="uk-text-primary" href="#">Map</a></li>
                        <li class=""  id="tlid"  ><a class="uk-text-primary" href="#">Listing</a></li>
                    </ul>
                   </div>
                   <div class="uk-width-1-1 uk-margin-small">
                     <ul id="tab-1" class="uk-switcher">
                         <li class="uk-active" id="mid">
                                <div id="map" style="height: 500px;width: 100%" ></div>
                         </li>
                         <li class="" id="lid">
                                   <div style="height: 500px;"  id="list" class="uk-grid uk-scrollable-text uk-text-left uk-grid-divider">
                         </li>
                     </ul>
                   </div>
                   <div class="uk-width-1-1"> 
                     <div id="modalList"></div>
                   </div>
            </div>
<script type="text/javascript" >
                             }

jQuery("#map-content").html(htmlMapList);

</script>
