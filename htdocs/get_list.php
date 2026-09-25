    <script type='text/javascript'>
    map="";
    var showBack="";
    var isc="";
    var isr="";
    var ulat='43.67023';
    var ulon='-79.38676';
    var latlon='';
    var list=[];
    var initZoom=16;
    var is_latlon=true;
    var cl=true;
    var allMarkers=[];

    var imgpath='/rs/';

    var is_loc_set=false;
        <?php if($is_loc_set === true ){ 
              echo "is_loc_set = true ; ";
        };?>
        if( $("#ulat").val() !='' &&  $("#ulon").val() !=''){
                ulat=$("#ulat").val();
                ulon=$("#ulon").val();
        }
        if( $('#s').val() == '' ){
            $('#s').val('0');
        }

      function CoordMapType(tileSize) {
          this.tileSize = tileSize;
      }
      CoordMapType.prototype.getTile = function(coord, zoom, ownerDocument) {
           var img = ownerDocument.createElement('img');
               img.src="/tile?z="+zoom+"&x="+coord.x+"&y="+coord.y;
               img.style.width = this.tileSize.width + 'px';
               img.style.height = this.tileSize.height + 'px';
               img.style.opacity = 0.4;
           var div = ownerDocument.createElement('div');
               div.style.borderStyle = 'none';
               div.style.borderWidth = '0px';
               div.style.position = 'absolute';
               div.appendChild(img);
               return div;
     };

    var customIcons = {
      houseF: {
        icon: 'images/house-r.png'
      },
      townhouseF: {
        icon: 'images/townhouse-r.png'
      },
      condoF: {
        icon: 'images/condo-r.png'
      },
      clusterF: {
        icon: 'images/cluster-r.png'
      },
      parkingF: {
        icon: 'images/parking.png'
      },
      parking: {
        icon: 'images/parking.png'
      },
      house: {
        icon: 'images/house-b.png'
      },
      condo: {
        icon: 'images/condo-b.png'
      },
      townhouse: {
        icon: 'images/townhouse-b.png'
      },
      clustercondo: {
        icon: 'images/cluster-b.png'
      },
      clusterhouse: {
        icon: 'images/cluster-b.png'
      },
      clustertownhouse: {
        icon: 'images/cluster-b.png'
      },
      clusterparking: {
        icon: 'images/parking.png'
      }
    };

// Builds the DOM content for an AdvancedMarkerElement (replaces the old
// MarkerWithLabel icon+labelContent combo, which google.maps.Marker deprecated).
function makeMarkerContent(iconUrl, text, opacity) {
    var wrap = document.createElement('div');
    wrap.style.cssText = 'display:flex;align-items:center;gap:2px;opacity:' + (opacity != null ? opacity : 1) + ';white-space:nowrap;';
    if (iconUrl) {
        var img = document.createElement('img');
        img.src = iconUrl;
        img.style.cssText = 'width:20px;height:20px;';
        wrap.appendChild(img);
    }
    if (text !== undefined && text !== null && text !== '') {
        var label = document.createElement('span');
        label.className = 'uk-badge uk-badge-danger';
        label.textContent = text;
        wrap.appendChild(label);
    }
    return wrap;
}

function setMapOnAll(map) {
  for (var i = 0; i < allMarkers.length; i++) {
    allMarkers[i].map = map;
  }
}

function clearMarkers() {
  setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
  setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  allMarkers = [];
}



function showList(idx){
         var selectPriceAsc = '';
         var selectPriceDesc = '';
         var selectDomAsc = '';
         var selectDomDesc = '';
         var selectDistance = '';


                 if( idx == 0){
                      selectPriceAsc = 'selected';
                 }else if (idx == 1){
                      selectPriceDesc = 'selected';
                 }else if (idx == 2){
                      selectDomAsc = 'selected';
                 }else if (idx == 3){
                      selectDomDesc = 'selected';
                 }else if (idx == 4){
                      selectDistance = 'selected';
                 }else{
                      selectPriceAsc = 'selected';
                 }
                      
                       var isCookie ;
                         isCookie = '<?php echo $_COOKIE[$cookie_name];?>';
                       
                      var htmlModalList="";
                      var htmlList="";
                          htmlList = "<div class=\"uk-grid\" data-uk-grid-margin>";
                          var indexLength =  list.length;
                          var ctr = 0;          
	for(index = indexLength-1 ; index >= 0; index--) {
            var addr="";
            if( list[index].disp_addr == 'Y' ){ 
                addr= (list[index].apt_num != '')?list[index].addr+" #"+list[index].apt_num:list[index].addr; 
            }
                                               
	    var dom = list[index].dom < 3?"<span class=\"uk-badge uk-badge-danger\" >New</span>":"<span class=\"uk-badge uk-badge-warning\" >"+list[index].dom+" days</span>";
	    var simg  = list[index].img;
            var price=list[index].asking;

	    var img  = list[index].img;

                        htmlList += " <div class=\"uk-width-medium-1-3\" >";
                        htmlList += "                                   <div class=\"uk-thumbnail uk-overlay-hover\" id=\"imodal-"+list[index].ml_num+"\"  data-uk-modal=\"{target:'#modal-"+list[index].ml_num+"'}\" >";
                        htmlList += "                                        <figure class=\"uk-overlay\">";
                        htmlList += "                                            <img src=\""+img+"\" onerror=\"imgError(this);\"  alt=\"\"/>";
                        htmlList += "                                             <figcaption class=\"uk-overlay-panel uk-overlay-icon uk-overlay-background uk-overlay-fade\"></figcaption>";
                        htmlList += "                                             <figcaption class=\"uk-overlay-panel uk-overlay-top uk-ignore\">";
                        htmlList += "                                               <div class=\"uk-grid\">";
                        htmlList += "                                                <div class=\"uk-width-medium-1-2\">";
                        htmlList += "                                                       <a onclick=\"switchlike(\"heart-"+list[index].ml_num+"\",\"likelist\")\"  style=\"color: red;\"  id=\"heart-"+list[index].ml_num+"\" class=\"uk-icon-heart-o uk-icon-small\" href=\"#\">&nbsp;</a>";
                        htmlList += "                                                </div><div class=\"uk-width-medium-1-2 uk-text-right\">"+dom;
                        htmlList += "                                               </div>";
                        htmlList += "                                             </figcaption>";
                        htmlList += "                                             <figcaption class=\"uk-overlay-panel uk-overlay-background uk-overlay-bottom uk-ignore uk-overlay-scale\">";
                        htmlList += "                                               <div class=\"uk-grid\" >";
                        htmlList += "                                                <div class=\"uk-width-medium-1-2\">";
                        htmlList += price+"                                                   </br>";
                        htmlList += list[index].bed+" beds / "+list[index].bath+" baths";
                        htmlList += "                                                </div><div class=\"uk-width-medium-1-2 uk-text-right\">";
                        htmlList += addr+"<br/>";
                        htmlList += list[index].community;
                        htmlList += "                                                </div>";
                        htmlList += "                                               </div>";
                        htmlList += "                                             </figcaption>";
                        htmlList += "";
                        htmlList += "                                             <a class=\"uk-position-cover\" href=\"#\"></a>";
                        htmlList += "                                         </figure>";
                        htmlList += "                                   </div>";
                        htmlList += "   </div>";



                       if( ctr != 0 && (ctr+1)%3 == 0){
                          htmlList += "</div>";
                          htmlList += "<div class=\"uk-grid\" data-uk-grid-margin>";
                        }
	if (isCookie != '' || '<?php echo $my_broker ?>' == list[index].rltr ){
                        htmlModalList += "   <div id=\"modal-"+list[index].ml_num+"\" class=\"uk-modal\">";
                        htmlModalList += "        <div class=\"uk-modal-dialog uk-modal-dialog-lightbox\">";
                        htmlModalList += "                                            <a href=\"#\" style=\"z-index:1;\"  class=\"uk-modal-close uk-close uk-close-alt\"></a>";
                        htmlModalList += "                                               <div class=\"uk-grid\" >";
                        htmlModalList += "                                                 <div class=\"uk-width-medium-1-1\">";
                        htmlModalList += "                                                   <figure class=\"uk-overlay\">";
                        htmlModalList += "                                                     <img width=\"600\" height=\"400\" src=\""+img+"\" onerror=\"imgError(this);\"  alt=\"\">";
                        htmlModalList += "                                                         <figcaption class=\"uk-overlay-panel uk-overlay-bottom uk-overlay-background\">";
                        htmlModalList += "                                                         <div class=\"uk-grid\">";
                        htmlModalList += "                                                            <div class=\"uk-width-1-2 uk-text-left uk-text-small\">";
                        htmlModalList += list[index].rltr;
                        htmlModalList += "                                                            </div>";
                        htmlModalList += "                                                            <div class=\"uk-width-1-2 uk-text-right\">";
                        htmlModalList += dom;
                        htmlModalList += "                                                            </div>";
                        htmlModalList += "                                                          </div>";
                        htmlModalList += "                                                          </figcaption>";
                        htmlModalList += "                                                  </figure>";
                        htmlModalList += "                                                 </div>";
                        htmlModalList += "                                               </div>";
                        htmlModalList += "                                               <div class=\"uk-grid\" style=\"margin-top: 2px; margin-bottom: 4px;\">";
                        htmlModalList += "                                                <div class=\"uk-width-1-2 uk-text-left\" >";
                        htmlModalList += "                                                  <ul class=\"uk-list\">";
                        htmlModalList += "                                                    <li><span  style=\"margin-left: 5px;\">"+list[index].asking+"</span></li>";
                        htmlModalList += "                                                    <li><span  style=\"margin-left: 5px;\">"+list[index].bed+" beds / "+list[index].bath+" baths</span></li>";
                        htmlModalList += "                                                    <li></li>";
                        htmlModalList += "                                                  </ul>";
                        htmlModalList += "                                                 </div>";
                        htmlModalList += "                                                 <div class=\"uk-width-1-2 uk-text-right\" >";
                        htmlModalList += "                                                  <ul class=\"uk-list\">";
                        htmlModalList += "                                                   <li><span  style=\"margin-right: 5px;\">"+addr+"</span></li>";
                        htmlModalList += "                                                   <li><span   style=\"margin-right: 5px; \">"+list[index].community+"</span></li>";
                        htmlModalList += "                                                  </ul>";
                        htmlModalList += "                                                </div>";
                        htmlModalList += "                                                 <div class=\"uk-width-1-1  uk-container-center uk-text-center\" style=\"margin-top: 2px; margin-bottom: 4px;\">";
htmlModalList += "                                                                      <a class=\"uk-button uk-button-primary\" href=\""+list[index].page_url+"\">View Full Listing&nbsp;";
htmlModalList += "                                             <i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;</a>";
                        htmlModalList += "                                                 </div>";
                        htmlModalList += "                                               </div>";
                        htmlModalList += "        </div>";
                        htmlModalList += "   </div>\r\n";
    //$("#modal-"+list[index].ml_num+").on('display.uk.check', function(){
    //        of(list[index].ml_num);
   // });
    }else {
                        htmlModalList += "        <div id=\"modal-"+list[index].ml_num+"\" class=\"uk-modal\">\r";
                        htmlModalList += "             <div class=\"uk-modal-dialog uk-modal-dialog-lightbox\">\r";
                        htmlModalList += "                                            <a href=\"#\" style=\"z-index:1;\"   class=\"uk-modal-close uk-close uk-close-alt\"></a>\r";

//START F
                        htmlModalList += "                                               <div class=\"uk-grid\" >\r";
                        htmlModalList += "                                                 <div class=\"uk-width-medium-1-1\">\r";
                        htmlModalList += "                                                   <figure class=\"uk-overlay\">\r";
                        htmlModalList += "                                                     <img width=\"600\" height=\"400\" src=\""+img+"\" onerror=\"imgError(this);\"  alt=\"\">\r";
                        htmlModalList += "                                                         <figcaption class=\"uk-overlay-panel uk-overlay uk-overlay-background\">\r";
                        htmlModalList += "                                                             <div id='first_step_"+list[index].ml_num+"'>\r";
                        htmlModalList += "                                                                <form class=\"uk-form-large\" id=\"s1-"+list[index].ml_num+"\" method=\"post\" action=\"/step1\" >\r";
                        htmlModalList += "                                                                 <div class=\"form\">\r";
                        htmlModalList += "                                                                    <fieldset>\r";
                        htmlModalList += "                                                                        <div class=\"uk-width-1-1\">\r";
                        htmlModalList += "                                                                            <b>FREE Account Required For Full Access</b><br/>\r";
                        htmlModalList += "                                                                               MLS® and the Real Estate Board require you sign up to see full details, including photos. It's Free!\r";
                        htmlModalList += "                                                                         </div>\r";
                        htmlModalList += "                                                                         <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        htmlModalList += "                                                                         <label class=\"uk-form-label\" for=\"email\"><b>Email Address</b></label>\r";
                        htmlModalList += "                                                                         <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-envelope\"></i><input class=\"uk-form-large uk-width-1-1\"  name=\"email\" id=\"email\" placeholder=\"email@email.com\"   type='text' ></div>\r";
            if( typeof ispass !== 'undefined' && ispass == 'Y'){
                        htmlModalList += "                                                                         <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-lock\"></i><input class=\"uk-form-large uk-width-1-1\"  name=\"pass\" id=\"pass\" placeholder=\"password\" type='password' ></div>\r";
            }
                        htmlModalList += "                                                                         <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        htmlModalList += "                                                                         <div class=\"uk-width-1-1\"><input class=\"uk-button uk-button-large uk-button-primary uk-width-1-1\" type=\"submit\" name=\"submit_first_"+list[index].ml_num+"\" id=\"submit_first_"+list[index].ml_num+"\" value=\"Sign In / Sign Up\"></div>\r";
                        htmlModalList += "                                                                         <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        htmlModalList += "                                                                            <input id=\"at\" name=\"at\" type=\"hidden\" value=\"<?php echo generateFormToken('first_step')?>\" >";
                        htmlModalList += "                                                                    </fieldset>\r";
                        htmlModalList += "                                                                 </div>\r";
                        htmlModalList += "                                                                <span  class=\"uk-text-bold\"></span>\r";
                        htmlModalList += "                                                                </form>\r";
                        htmlModalList += "                                                             </div>\r";
                        htmlModalList += "\r";
                        htmlModalList += "                                                             <div id='second_step_"+list[index].ml_num+"'  style=\"display: none;\" aria-hidden=\"true\">\r";
                        htmlModalList += "                                                                 <form class=\"uk-form-large\" id=\"s2-"+list[index].ml_num+"\" method=\"post\" action=\"/step2\"  >\r";
                        htmlModalList += "                                                                    <div class=\"form\">\r";
                        htmlModalList += "                                                                       <fieldset>\r";
                        htmlModalList += "                                                                           <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        htmlModalList += "                                                                            <label class=\"uk-form-label\" for=\"name\"><b>Name</b></label>\r";
                        htmlModalList += "                                                                            <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-male\"></i><input class=\"uk-form-large uk-width-1-1\"  name=\"name\" id=\"name\" placeholder=\"Your Name\"  type='text' ></div>\r";
                        htmlModalList += "                                                                            <label class=\"uk-form-label\" for=\"phone\"><b>Phone</b></label>\r";
                        htmlModalList += "                                                                            <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-phone\"></i><input class=\"uk-form-large uk-width-1-1\" name=\"phone\" id=\"phone_"+list[index].ml_num+"\" type='text'>\r";
                        htmlModalList += "                                                                            </div>\r";
                        htmlModalList += "                                                                            <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        htmlModalList += "                                                                            <div class=\"uk-width-1-1\">\r";
                        htmlModalList += "                                                                           <input class=\"uk-button uk-button-large uk-button-primary uk-width-1-1\" name=\"submit_second_"+list[index].ml_num+"\" id=\"submit_second_"+list[index].ml_num+"\" value=\"Submit\" type=\"submit\">\r";
                        htmlModalList += "                                                                            </div>\r";
                        htmlModalList += "                                                                            <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        htmlModalList += "                                                                            <input id=\"at\" name=\"at\" type=\"hidden\" value=\"<?php echo generateFormToken('second_step')?>\" >";
                        htmlModalList += "                                                                       </fieldset>\r";
                        htmlModalList += "                                                                    </div>\r";
                        htmlModalList += "                                                                    <span class=\"uk-text-bold\"></span>\r";
                        htmlModalList += "                                                                 </form>\r";
                        htmlModalList += "                                                              </div>\r";
                        htmlModalList += "                                                         </figcaption>\r";
                        htmlModalList += "                                                         <figcaption class=\"uk-overlay-panel uk-overlay-bottom uk-overlay-background\">\r";
                        htmlModalList += "                                                         <div class=\"uk-grid\">\r";
                        htmlModalList += "                                                            <div class=\"uk-width-1-2 uk-text-left uk-text-small\">\r";
                        htmlModalList += list[index].rltr;
                        htmlModalList += "                                                            </div>\r";
                        htmlModalList += "                                                            <div class=\"uk-width-1-2 uk-text-right\">\r";
                        htmlModalList += "                                                            </div>\r";
                        htmlModalList += "                                                         </div>\r";
                        htmlModalList += "                                                         </figcaption>\r";
                        htmlModalList += "                                                   </figure>\r";
                        htmlModalList += "                                                  </div>\r";
                        htmlModalList += "                                               </div>\r";
                        htmlModalList += "                                               <div class=\"uk-grid\" style=\"margin-top: 2px;\">\r";
                        htmlModalList += "                                                <div class=\"uk-width-1-2 uk-text-left\" >\r";
                        htmlModalList += "                                                  <ul class=\"uk-list\">\r";
                        htmlModalList += "                                                    <li><span  style=\"margin-left: 5px;\">"+list[index].asking+"</span></li>\r";
                        htmlModalList += "                                                    <li><span  style=\"margin-left: 5px;\">"+list[index].bed+" beds / "+list[index].bath+" baths</span></li>\r";
                        htmlModalList += "                                                    <li></li>\r";
                        htmlModalList += "                                                  </ul>\r";
                        htmlModalList += "                                                 </div>\r";
                        htmlModalList += "                                                 <div class=\"uk-width-1-2 uk-text-right\" >\r";
                        htmlModalList += "                                                  <ul class=\"uk-list\">\r";
                        htmlModalList += "                                                   <li><span  style=\"margin-right: 5px;\">"+addr+"</span></li>\r";
                        htmlModalList += "                                                   <li><span   style=\"margin-right: 5px; \">"+list[index].community+"</span></li>\r";
                        htmlModalList += "                                                  </ul>\r";
                        htmlModalList += "                                                </div>\r";
//END F
                        htmlModalList += "                                                 <div class=\"uk-width-1-1  uk-container-center uk-text-center\" style=\"margin-top: 2px; margin-bottom: 4px;\">\r";
htmlModalList += "                                     <a class=\"uk-button uk-button-primary\" href=\""+list[index].page_url+"\">View Full Listing&nbsp;";
 
htmlModalList += "                                             <i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;</a>";
 
                        htmlModalList += "                                                 </div>\r";
                        htmlModalList += "\r";
                        htmlModalList += "                                               </div>\r";
                        htmlModalList += "             </div>\r";
                        htmlModalList += "       </div>\r";

                       htmlModalList +=  "<script type=\"text/javascript\">";
                       htmlModalList +=  "$(\"#modal-"+list[index].ml_num+"\").on('display.uk.check', function(){";
                       htmlModalList +=  "       of(\""+list[index].ml_num+"\",\""+list[index].page_url+"\");";
                       htmlModalList +=  " });";
                       htmlModalList +=  "<\/script>";
               } ;
            ctr++;
               if( index == 0 ){
                }
       }
                       if( indexLength < 1 ){
                                htmlList += "<div class=\"uk-width-medium-1-1 uk-align-center \">";
                                htmlList += "<div class=\"uk-alert uk-alert-large uk-alert-danger\" data-uk-alert>";
                                htmlList += "<button type=\"button\" class=\"uk-alert-close uk-close\"></button>";
                                htmlList += "<h2>Your search didn't return any results!</h2>";
                                htmlList += "<p>Please refine your search criteria.<br>Suggestions:<br><br>Broaden your map area.</br>Update your search location<br>Modify the selected filters.</p>";
                                htmlList += "</div></div>";

                                htmlModalList="";
                        }else {
                                 htmlList += "</div>";
                        }
                               jQuery("#list").html(htmlList);
                               jQuery(document).ready(function($) {
                                         $.UIkit.modal('#modal-spinner',{center: true}).hide();
                               });
                               jQuery("#modalList").html(htmlModalList);
                                likeinit('likelist');

}

     function sortDomAsc(){
                  function cmp(a,b) {
                    return (a.dom - b.dom);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }

     function sortDomDesc(){
                  function cmp(a,b) {
                    return (b.dom - a.dom);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }

     function sortDistance(lat, lng) {
                  function dist(l) {
                    return (l.lat - lat) * (l.lat - lat) +
                      (l.lon-lng) * (l.lon-lng);
                 }

                  list.sort(function(l1, l2) {
                    return dist(l1) - dist(l2);
 
                  });
      }

     function sortPriceAsc() {
                  function cmp(a,b) {
                    return (a.lp_dol - b.lp_dol);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }
     function sortPriceDesc() {
                  function cmp(a,b) {
                    return (b.lp_dol - a.lp_dol);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }

	function sortList(selectObj)
	{	 
	  var idx = selectObj.selectedIndex;
                 if( idx == 0){
                      sortPriceAsc();
                 }else if (idx == 1){
                      sortPriceDesc();
                 }else if (idx == 2){
                      sortDomAsc();
                 }else if (idx == 3){
                      sortDomDesc();
                 }else if (idx == 4){
                      sortDistance(ulat,ulon);
                 }else{
                      sortPriceAsc();
                 }
                 showList(idx);
	}
function initialize() {
          if(is_loc_set){
                ulat='<?php echo $lat; ?>';
                ulon='<?php echo $lon; ?>';
                $("#ulat").val(ulat);
                $("#ulon").val(ulon);
                $("#addr").val('<?php echo $addr;?>');
                $("#s").val(0);
                onSubmit('fc',5256000);
                onSubmit('pg');
                onLoad('fc')
           }else{
                onSubmit('fc',5256000);
                onSubmit('pg');
                onLoad('fc')
                ulat=getInputValue('fc','ulat',ulat);
                ulon=getInputValue('fc','ulon',ulon);
           }
           UIkit.modal('#modal-spinner',{center: true}).show();
     if ( (ulat == null && ulon==null) || (    ulat=='' && ulon=='') ){
           ulat='43.67023';
           ulon='-79.38676';
     }
  var myLatlng = new google.maps.LatLng(ulat,ulon);
  var mapOptions = {
    //minZoom: 14,
    zoom: 15,
    center: myLatlng,
    scrollwheel: false,
    mapId: '8924d60d97d8e8654f674654',
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    draggable: false, 
    zoomControl: false, 
    scrollwheel: false, 
    disableDoubleClickZoom: true
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
        map.setCenter(myLatlng);

  var myIcon = customIcons["<?php echo getPropertyType($type_own_srch).'F'; ?>"] || {};
  var marker = new google.maps.marker.AdvancedMarkerElement({
      position: myLatlng,
      map: map,
      zIndex:  2,
      title: '<?php echo $addr; ?>'
  });

   map.overlayMapTypes.insertAt( 0, new CoordMapType(new google.maps.Size(256, 256)));
   marker.addListener('gmp-click', function(event) {
          map.setZoom(map.getZoom()+1);
          map.setCenter(marker.position);
  });
  google.maps.event.addListener(marker, 'mouseout', function() {
  });
 var maxp = $("#s_r").val() == 'Sale'  ? $("#smaxp").val() : $("#lmaxp").val() ;
 var minp = $("#s_r").val() == 'Sale'  ? $("#sminp").val() : $("#lminp").val() ;
 var sForm = "&bed="+$("#bed").val()+"&bath="+$("#bath").val()+"&minp="+minp+"&maxp="+maxp+"&rtype="+$("#rtype").val()+"&order="+$("#order").val()+"&s_r="+$("#s_r").val()+"&at="+$("#at").val();
 var latlon="&ulat="+ulat+"&ulon="+ulon;
 var isc="&c=n";
 var isr="&ir=y&nr="+$("#nr").val()+"&s="+$("#s").val();
 $.ajax({
        type : 'POST',
        url : '/get_cl_markers',
        dataType: 'xml',
        data: {
            ulat: ulat,
            ulon: ulon,
            c: 'n',
            ir: 'y',
            nr: $("#nr").val(),
            s: $("#s").val(),
            bed: $("#bed").val(),
            bath: $("#bath").val(), 
            minp: minp, 
            maxp: maxp, 
            rtype: $("#rtype").val(),
            order: $("#order").val(),
            s_r: $("#s_r").val(),
            at: $("#at").val()
        },
         success : function(data) {

                            latlon=isc=isr='';
                        var markers = data.documentElement.getElementsByTagName("marker");
                            list=[];
                            showBack="";
		      for (var i = 0; i < markers.length; i++) {
		        var asking = markers[i].getAttribute("asking");
		        var ml_num = markers[i].getAttribute("ml_num");
		        var ipath = markers[i].getAttribute("ipath");	        var img = markers[i].getAttribute("img");		        var addr = markers[i].getAttribute("addr");
		        var bed = markers[i].getAttribute("bed");
		        var bath = markers[i].getAttribute("bath");
		        var building = markers[i].getAttribute("building");
		        var type_own_srch = markers[i].getAttribute("type_own_srch");
		        var type_own1_out = markers[i].getAttribute("type_own1_out");
		        var iconName   = markers[i].getAttribute("icon");
		        var xlon = markers[i].getAttribute("lon");
		        var xlat = markers[i].getAttribute("lat");
		        var min = markers[i].getAttribute("min");
		        var max = markers[i].getAttribute("max");
		        var community = markers[i].getAttribute("community");
		        var municipality = markers[i].getAttribute("municipality");
		        var page_url = markers[i].getAttribute("page_url");
		        var dom = markers[i].getAttribute("dom");
		        var rltr = markers[i].getAttribute("rltr");
		        var count = markers[i].getAttribute("count");
		        var multiple = markers[i].getAttribute("multiple");
		        var cluster = markers[i].getAttribute("cluster");
		        var lp_dol  = markers[i].getAttribute("lp_dol");
		        var html ="";
                        var msg = (count == 1 ? asking : count);
                        var title = (count == 1 ? addr : '');
                        var shift = (count == 1 ? '0' : '35');
                        var label = (count == 1 ? 'labels' : 'clabels');
                        var aList = {ml_num:ml_num,ipath:ipath,img:img,asking:asking,addr:addr,bed:bed,bath:bath,lat:xlat,lon:xlon,min:min,max:max,rltr:rltr,count:count,dom:dom,community:community,municipality:municipality, page_url:page_url,type_own1_out:type_own1_out,index:i,building:building,multiple:multiple,lp_dol:lp_dol};
                        list.push(aList);
                        var icon = customIcons[iconName] || {};

                        var point = new google.maps.LatLng(
                             markers[i].getAttribute("lat"),
                             markers[i].getAttribute("lon")
                            );
                         if( i== 0 && markers[i].getAttribute("mr") > 0){
                             

                         }

                         var myMarker = new google.maps.marker.AdvancedMarkerElement({
                                        map: map,
                                        zIndex:  -1,
                                        title:  title,
                                        position: point,
                                        content: makeMarkerContent(icon.icon, msg, 0.75)
                           });
                                        //myMarker.set(ml_num);
                        allMarkers.push(myMarker);
                        myMarker.addListener('gmp-click',function(event) {
                                map.panTo(myMarker.position);
                                map.setZoom(map.getZoom()+1);
                         });


                          myMarker.addListener('gmp-click',function(event) {
                                var modal = UIkit.modal("#modal-"+ml_num);
                                    modal.show();
                         });
                        //   bindInfoWindow(myMarker, ap, infoWindow, html);

                       };
                            showList(0);
                }

          });
 
    function bindInfoWindow(marker, map, infoWindow, html) {
      marker.content.addEventListener('mouseover', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    };

//$(document).ready(function() {
 var pgURL="http://<?php echo $domain;?>/get_cl_pagination?"+latlon+isc+isr+sForm;
 $.ajax({
        type : 'POST',
        url : '/get_cl_pagination',
        dataType: 'xml',
        data: {
            ulat: ulat,
            ulon: ulon,
            c: 'n',
            ir: 'y',
            nr: $("#nr").val(),
            s: $("#s").val(),
            bed: $("#bed").val(),
            bath: $("#bath").val(),
            minp: minp,
            maxp: maxp,
            rtype: $("#rtype").val(),
            order: $("#order").val(),
            s_r: $("#s_r").val(),
            at: $("#at").val()
        },
         success : function(xml) {
         var result = xml.documentElement.getElementsByTagName("result");
         jQuery("#pagination").html(result[0].getAttribute('pagination')); // result is the HTML text
         jQuery("#totals").html(result[0].getAttribute('totals')); // result is the HTML text
        },
  });
     $("#s").val(0);
     onSubmit('pg');
};

    function downloadUrl(url,posturl, callback) {
      var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
        
      };
      request.open('GET', url+posturl, true);
      request.send(null);
    }

    function doNothing() {}

// Was bound to window 'load' (waits for every image/analytics beacon to finish,
// which can hang indefinitely and silently prevent the map from ever initializing).
jQuery(document).ready(function($) { initialize(); });

</script>
