    <script type='text/javascript' >
 //  $('document').ready(function() {

    map;
    var marker;
    var activeInfoWindow ;	
    var allMarkers=[];
    var showBack="";
    var backZ="<span style=\"margin-top: 5px; float:right \"><a href=\"#\"  onclick=\"backZoom();\" >&nbsp;&nbsp;<<&nbsp;Go Back</a>&nbsp;&nbsp;</span>";
    var isc="y";
    var isr="";
    var ulat='43.67023';
    var ulon='-79.38676';
    var plat='';
    var plon='';
    var latlon='';
    var mid=lid=false;
    var list=[];
    var initZoom=16;
    var minZoom=12;
    var cl=true;
    var imgpath='/rs/';
    var is_loc_set=false;
    var myMapOptions = '';
    var remove_poi = [
    {
      "featureType": "poi",
      "elementType": "labels",
      "stylers": [
        { "visibility": "off" }
      ]
     }
    ]
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

        if(  $("#zoom").val() !='' ){
                initZoom=$("#zoom").val();
        }
function setItem(item,img){
         var htmlItem="<div class=\"uk-width-medium-1-1\">";
         var price=(item.count==1)?item.asking:"From "+item.min+" to "+item.max;
                         if( item.count > 1){
                                htmlItem += "<div class=\"uk-panel uk-panel-box\" onmouseover=\"changeMarkerOver("+item.index+")\" onmouseout=\"changeMarkerOut("+item.index+")\" onclick=\"seeCluster("+item.index+",\'"+item.multiple+"\');\" >";
                                htmlItem += "   <div class=\"uk-grid\">";
                                htmlItem += "           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                   <img width=\"150\" height=\"110\"  onerror=\"imgError(this);\" src=\"imgError(this);\">";
                                htmlItem += "           </div>";
                                htmlItem += "           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                   <div class=\"uk-panel-badge uk-badge uk-badge-danger\">";
                                htmlItem +=                     price;
                                htmlItem += "                   </div>";
                              if (item.multiple == 'y'){       
                                htmlItem += "                   <span  class=\"uk-text-bold\"><br>"+item.addr+"&nbsp;&nbsp;<i class=\"uk-icon-justify uk-icon-plus-square\"></i>&nbsp;&nbsp;Multiple Listings</span>";
                              }else{ 
                                htmlItem += "                   <span  class=\"uk-text-bold\"><br> <i class=\"uk-icon-justify uk-icon-plus-square\"></i>&nbsp;&nbsp;Multiple Listings</span>";
                              }
                                htmlItem += "           </div>";
                                htmlItem += "   </div>";
                                htmlItem += "</div>";
                         }else{
                                htmlItem += "<div  data-uk-modal=\"{target:'#modal-"+item.ml_num+"'}\" >";
                                htmlItem += "           <div class=\"uk-panel uk-panel-box\" onmouseover=\"changeMarkerOver("+item.index+");\" onmouseout=\"changeMarkerOut("+item.index+");\" >";
                                htmlItem += "                   <div class=\"uk-grid\">";
                                htmlItem += "                           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                                                     <img width=\"600\" height=\"400\" src=\""+img+"\" onerror=\"imgError(this);\"  alt=\"\">";
                                htmlItem += "                           </div>";
                                htmlItem += "                           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                                           <div class=\"uk-panel-badge uk-badge uk-badge-danger\">";
                                htmlItem +=                                                price;
                                htmlItem += "                                           </div>";
                                htmlItem += "                                           <ul class=\"uk-list\">";
                                htmlItem += "                                              <li><span  style=\"margin-right: 5px;\">"+item.addr+"</span></li>";
                                htmlItem += "                                              <li><span  style=\"margin-right: 5px;\">"+item.community+"</span></li>";
                                htmlItem += "                                              <li><span  style=\"margin-right: 5px; \">"+item.bed+" beds / "+item.bath+" baths"+"</span></li>";
                                htmlItem += "                                           </ul>";
                                htmlItem += "                           </div>";
                                htmlItem += "                   </div>";
                                htmlItem += "           </div>";
                                htmlItem += "</div>";
                          }
	htmlItem += "</div>";
        return htmlItem;
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
                 };
                      
                       var isCookie ;
                         isCookie = '<?php echo $_COOKIE[$cookie_name]." ".$cookie_name ;?>';
                      var htmlModalList="";
                      var htmlList="";
                          htmlList += "<div class=\"uk-panel uk-panel-box\" >";
                          htmlList += "                           <span class=\"uk-text-bold\">Sort by:</span>";
                          htmlList += "                           <select id=\"srt\" onChange=\"sortList(this);\" type=\"text\"  class=\"uk-form-large uk-text-bold uk-width-4-5\">";
                          htmlList += "                                              <option value='' "+selectPriceAsc+" >Price - low to high </option>";
                          htmlList += "                                              <option value='' "+selectPriceDesc+" >Price - high to low </option>";
                          htmlList += "                                              <option value='' "+selectDomAsc+" >Date - newest first </option>";
                          htmlList += "                                              <option value='' "+selectDomDesc+" >Date - oldest first </option>";
                          htmlList += "                                              <option value='' "+selectDistance+" >Distance</option>";
                          htmlList += "                           </select>";
                          htmlList += showBack;
                          htmlList += "</div>";
                          htmlList="";
                      for(index = 0; index < list.length; index++) {
                                  var price=(list[index].count==1)?list[index].asking:"From "+list[index].min+" to "+list[index].max;
                                  var img  = list[index].img;
                                  var Mimg  = list[index].img;
                                  htmlList += setItem(list[index],img);
                         if( list[index].count == 1){
				htmlModalList += "<div id=\"modal-"+list[index].ml_num+"\" class=\"uk-modal\">";
				htmlModalList += "		<div class=\"uk-modal-dialog uk-modal-dialog-lightbox\">";
				htmlModalList += "			<a href=\"\"  style=\"z-index:1;\" class=\"uk-modal-close uk-close uk-close-alt\"></a>";
				htmlModalList += "			<div class=\"uk-grid\" >";
				htmlModalList += "				<div class=\"uk-width-medium-1-1\">";
				htmlModalList += "					<figure class=\"uk-overlay\">";
				htmlModalList += "						<img width=\"600\" height=\"400\"  onerror=\"imgError(this);\"  src=\""+Mimg+"\" alt=\"\">";
				htmlModalList += "						<figcaption class=\"uk-overlay-panel uk-overlay-bottom uk-overlay-background\">";
				htmlModalList += "							<div class=\"uk-grid\">";
				htmlModalList += "								<div class=\"uk-width-1-2 uk-text-left uk-text-small\">";
				htmlModalList += "								</div>";
				htmlModalList += "								<div class=\"uk-width-1-2 uk-text-right\">";
				htmlModalList += 								list[index].dom+" days listed";
				htmlModalList += "								</div>";
				htmlModalList += "							</div>";
				htmlModalList += "						</figcaption>";
				htmlModalList += "					</figure>";
				htmlModalList += "				</div>";
				htmlModalList += "			</div>";
				htmlModalList += "			<div class=\"uk-grid\" style=\"margin-top: 2px; margin-bottom: 4px;\">";
				htmlModalList += "				<div class=\"uk-width-1-2 uk-text-left\" >";
				htmlModalList += "					<ul class=\"uk-list\">";
				htmlModalList += "						<li><span  style=\"margin-left: 5px;\">"+list[index].asking+"</span></li>";
				htmlModalList += "						<li><span  style=\"margin-left: 5px;\">"+list[index].bed+" beds / "+list[index].bath+" baths </span></li>";
				htmlModalList += "						<li></li>";
				htmlModalList += "					</ul>";
				htmlModalList += "				</div>";
				htmlModalList += "				<div class=\"uk-width-1-2 uk-text-right\" >";
				htmlModalList += "					<ul class=\"uk-list\">";
				htmlModalList += "						<li><span  style=\"margin-right: 5px;\">"+list[index].addr+"</span></li>";
				htmlModalList += "						<li><span   style=\"margin-right: 5px; \">"+list[index].community+"</span></li>";
				htmlModalList += "					</ul>";
				htmlModalList += "				</div>";
				htmlModalList += "				<div class=\"uk-width-1-1  uk-container-center uk-text-center\" style=\"margin-top: 2px; margin-bottom: 4px;\">";
				htmlModalList += "					<a class=\"uk-button uk-button-primary\" href=\""+list[index].page_url+"\">View Full Listing&nbsp;";
				htmlModalList += "                                  		<i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;";
                                htmlModalList += "                                   </a>";
				htmlModalList += "				</div>";
				htmlModalList += "			</div>";
				htmlModalList += "		</div>";
				htmlModalList += "</div>";
                         }
                       }
                        if( htmlList == '' ){
                                htmlList += "<div class=\"uk-width-medium-1-1 uk-align-center \">";
                                htmlList += "<div class=\"uk-alert uk-alert-large uk-alert-danger\" data-uk-alert>";
                                htmlList += "<button type=\"button\" class=\"uk-alert-close uk-close\"></button>";
                                htmlList += "<h2>Your search didn't return any results!</h2>";
                                htmlList += "<p>Please refine your search criteria.<br>Suggestions:<br><br>Broaden your map area.</br>Update your search location<br>Modify the selected filters.</p>";
                                htmlList += "</div></div>";
                         } 

                                      jQuery("#list").html(htmlList);
                                      jQuery("#modalList").html(htmlModalList);
                                      
                                        jQuery(document).ready(function($) {
                                         $.UIkit.modal('#modal-spinner',{center: true}).hide();
                                         });

}

function changeMarkerOver(i) {
   if(allMarkers[i] == null && list[i].cluster == 'n' ){
        allMarkers[0].setIcon((allMarkers[0].icon).replace("-b.png","-r.png"));
   }
   if(allMarkers[i]!= null && allMarkers[i].icon.indexOf("-b.png") > -1){ 
        allMarkers[i].setIcon((allMarkers[i].icon).replace("-b.png","-r.png"));
   }
}
function changeMarkerOut(i) {
   if(allMarkers[i] == null &&  list[i].cluster == 'n'){
        allMarkers[0].setIcon((allMarkers[0].icon).replace("-r.png","-b.png"));
   }
   if(allMarkers[i]!= null && allMarkers[i].icon.indexOf("-r.png") > -1){
    allMarkers[i].setIcon((allMarkers[i].icon).replace("-r.png","-b.png"));
   }
   
}
function seeCluster(i,m) {
          // AdvancedMarkerElement.position can be a LatLng (methods) or a plain
          // LatLngLiteral (lat/lng as plain number properties); support both.
          var pos = allMarkers[i].position;
          ulat = (typeof pos.lat === 'function') ? pos.lat() : pos.lat;
          ulon = (typeof pos.lng === 'function') ? pos.lng() : pos.lng;
        
         if(m == 'y' ){
          latlon="&ulat="+ulat+"&ulon="+ulon;
          plat=ulat;
          plon=ulon;
          isc="n";
          isr="0";
          cl=false; 
          showBack=backZ;
         }

         var myLatlng = new google.maps.LatLng(ulat, ulon);
         map.setCenter(myLatlng);
         if(map.getZoom() >= minZoom){
             map.setZoom(map.getZoom()+1);
         }
}

function radiusToZoom(radius){
    return Math.round(16-Math.log(radius*0.62)/Math.LN2);
}

function backZoom() {
         map.setZoom(map.getZoom()-1);
         showBack="";
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


          function CoordMapType(tileSize) {
          this.tileSize = tileSize;
      } 
      CoordMapType.prototype.getTile = function(coord, zoom, ownerDocument) {
           var img = ownerDocument.createElement('img');
               img.src="tile/"+zoom+"/"+coord.x+"/"+coord.y;
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

/**/
    //var list = '';
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
    var lat='<?php echo $lat;?>'; 
    var lon='<?php echo $lon;?>';

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



// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < allMarkers.length; i++) {
    allMarkers[i].map = map;
  }
}

// Removes the markers from the map, but keeps them in the array.
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

<!--
          $("#lid").on('display.uk.check', function(){
              lid=true
          });

function initialize() {
          if(is_loc_set){
                ulat='<?php echo $lat; ?>';
                ulon='<?php echo $lon; ?>';
                $("#ulat").val(ulat);
                $("#ulon").val(ulon);
                $("#addr").val('<?php echo $addr;?>');
           }else{
                ulat=getInputValue('fc','ulat',ulat);
                ulon=getInputValue('fc','ulon',ulon);
           }
          // if(lid){
          $("#mid").on('display.uk.check', function(){
               // UIkit.switcher('#v-control').show('#mid');
               // UIkit.switcher('#v-control').show('#tmid');
           })
           onSubmit('fc',5256000);
           UIkit.modal('#modal-spinner',{center: true}).show();
     if ( (ulat == null && ulon==null) || (    ulat=='' && ulon=='') ){
           ulat='43.67023';
           ulon='-79.38676';
     }

  var myLatlng = new google.maps.LatLng(ulat,ulon);

  if($("#nr").val() != '0' ){
     initZoom = radiusToZoom($("#nr").val());
  }
  var mapOptions = {
    minZoom: minZoom, 
    zoom: initZoom,
    center: myLatlng,
    scaleControl: true,
    scrollwheel: false,
    mapId: '8924d60d97d8e8654f674654',
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
        map.setCenter(myLatlng);

  var myIcon = customIcons["<?php echo getPropertyType($type_own_srch).'F'; ?>"] || {};
  marker = new google.maps.marker.AdvancedMarkerElement({
      position: myLatlng,
      map: map,
      zIndex:  2,
      title: '<?php echo $addr; ?>'
  });

   map.overlayMapTypes.insertAt( 0, new CoordMapType(new google.maps.Size(256, 256)));
  // google.maps.event.addListener(marker,'click',function(event) {
  //        map.setCenter(marker.getPosition());
  //        map.setZoom(map.getZoom()+1);
  //        //map.setCenter(marker.getPosition());
  //});
  google.maps.event.addListener(marker, 'mouseout', function() {
  });

   map.addListener('dragend', function() {
         ulon=map.getCenter().lng();
         ulat=map.getCenter().lat();
         $("#ulon").val(ulon);
         $("#ulat").val(ulat);
         $("#addr").val("");
        var myLatlng = new google.maps.LatLng(ulat,ulon);
            marker.map = null;
            marker = new google.maps.marker.AdvancedMarkerElement({
            position: myLatlng,
            map: map,
            zIndex:  2
    });


   });
   map.addListener('drag', function() {
          cl=true;
          $.UIkit.modal('#modal-spinner',{center: true}).show();
   });
   map.addListener('zoom_changed', function() {
          cl=true;
          initZoom=map.getZoom() ;
          $.UIkit.modal('#modal-spinner',{center: true}).show();
   });
   map.addListener('bonds_changed', function() {
          cl=true;
          $.UIkit.modal('#modal-spinner',{center: true}).show();
   });
 var maxp = $("#s_r").val() == 'Sale'  ? $("#smaxp").val() : $("#lmaxp").val() ;
 var minp = $("#s_r").val() == 'Sale'  ? $("#sminp").val() : $("#lminp").val() ;
 var sForm = "&bed="+$("#bed").val()+"&bath="+$("#bath").val()+"&minp="+minp+"&maxp="+maxp+"&rtype="+$("#rtype").val()+"&s_r="+$('#s_r').val();

 google.maps.event.addListener(map,'idle', function(event) 
 {
   var bounds = map.getBounds();
   var ne = bounds.getNorthEast();
   var sw = bounds.getSouthWest();
   var infoWindow = new google.maps.InfoWindow;
   if($('#isc').val()){
        // isc="&c=n";
   }
   var parm="?z="+map.getZoom()+"&ml_num=<?php echo $ml_num; ?>&nelat="+ne.lat()+"&nelng="+ne.lng()+"&swlat="+sw.lat()+"&swlng="+sw.lng()+latlon+"&c="+isc+isr+sForm+"&at="+$("#at").val();
  $.ajax({
         type : 'POST',
         url : '/get_cl_markers',
         dataType: 'xml',
         data: {
             ulat: plat,
             ulon: plon,
             nelat: ne.lat(),
             nelng: ne.lng(),
             swlat: sw.lat(),
             swlng: sw.lng(),
             c: isc,
             ir: 'y',
             nr: isr,
             s: $("#s").val(),
             bed: $("#bed").val(),
             bath: $("#bath").val(),
             minp: minp,
             maxp: maxp,
             rtype: $("#rtype").val(),
             s_r: $("#s_r").val(),
             z: map.getZoom(),
             at: $("#at").val()
         },
          success : function(data) {
                            deleteMarkers();
                            plat=plon=latlon=isr='';
                            isc='y';
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
		        var s_r = markers[i].getAttribute("s_r");
		        var lp_dol  = markers[i].getAttribute("lp_dol");
		        var point = new google.maps.LatLng(
			     markers[i].getAttribute("lat"),
			     markers[i].getAttribute("lon")
                            );
                        var aList = {ml_num:ml_num,ipath:ipath,img:img,asking:asking,addr:addr,bed:bed,bath:bath,lat:xlat,lon:xlon,min:min,max:max,rltr:rltr,count:count,dom:dom,municipality:municipality,community:community,type_own1_out:type_own1_out,index:i,building:building,multiple:multiple,lp_dol:lp_dol,page_url:page_url,cluster:cluster};
                        list.push(aList);
                        var img  = markers[i].getAttribute("img");
                        var html="";
		        var icon = customIcons[iconName] || {};
                        var msg = (count == 1 ? asking : count);
                        var title = (count == 1 ? addr : '');
                        var shift = (count == 1 ? '0' : '35');
                        var label = (count == 1 ? 'labels' : 'clabels');
                           if(map.getZoom() > 15 && multiple == 'y' && (count > 1 ||  cluster == 'n') && building == 'condo'  ){
                                if( typeof isSmall !=='undefined' && isSmall ){
                                      html = "<b>"+addr+"</b>&nbsp;<a href=\"#\" onclick=\"map.setZoom(map.getZoom()+1);showLTab()\"><i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;</a></br>"+count+" units, from "+min+" up to "+max;
                                 }else{
                                      html = "<b>"+addr+"</b></br>"+count+" units, from "+min+" up to "+max;
                                 }
                              shift = 0;
                              label = 'labels';
                              msg = "+"+min;
		              icon = customIcons['condo'] || {};
                           }
                           if(map.getZoom() > 15 && multiple == 'y' &&  (count > 1  ||  cluster == 'n') && building == 'townhouse' ){
                                 if( typeof isSmall !=='undefined' && isSmall ){
                                     html = "<b>"+addr+"</b>&nbsp;<a href=\"#\" onclick=\"showLTab()\"><i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;</a></br>"+count+" units, from "+min+" up to "+max;
 
                                 }else{
                                     html = "<b>"+addr+"</b>&nbsp;</br>"+count+" units, from "+min+" up to "+max;

                                 }
                              shift = 0;
                              label = 'labels';
                              msg = "+"+min;
		              icon = customIcons['townhouse'] || {};
                           }
                           var idx = i;
                           if(  cluster == 'n' && (building == 'condo' ||  building == 'townhouse' )  ){
                               idx=0;
                               msg=markers.length+' units';
                                 if( typeof isSmall !=='undefined' && isSmall ){
 
                               html = "<b>"+addr+"</b>&nbsp;<a href=\"#\" onclick=\"showLTab()\"><i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;</a></br>"+markers.length+" units";
                                 }else{
                               html = "<b>"+addr+"</b>&nbsp;</br>"+markers.length+" units";
                                 }
                               showBack=backZ;
                           }
                           if( html == null || html == ""){
                               html = "<div  data-uk-modal=\"{target:'#modal-"+ml_num+"'}\" >";
                               html += "<b>"+addr+"</b></br>"+bed+" beds/"+bath+" baths<br>"+asking+" for "+s_r;
                               html += "&nbsp;<i class=\"uk-icon-justify uk-icon-hand-o-right\"></i></div>";
                           };

                           if(  cluster != 'n' || i == 0 ){
                                 var myMarker = new google.maps.marker.AdvancedMarkerElement({
                        		map: map,
                          		zIndex:  -1,
                         		title:  title,
                          		position: point,
                          		content: makeMarkerContent(icon.icon, msg, 0.75)
                                      });
                                        allMarkers.push(myMarker);
                                        // myMarker.set(ml_num); // invalid MVCObject.set() usage (needs key+value); AdvancedMarkerElement throws on this

                                        //}else{
                                         //   var modal = UIkit.modal("#modal-"+ml_num);
                                        //        modal.show();
                                       // }
                           }


                         if(  count > 1 &&  ( multiple != 'y' || map.getZoom() < 15 ) ){
                         //if(  count > 1  ){
                                        myMarker.addListener('gmp-click', function() {
					    map.setCenter(this.position);
                                            map.setZoom(map.getZoom()+1);
					});

				 }

				 if( count == 1 || ( map.getZoom() > 15 &&  count > 1 &&  multiple == 'y' ) ){
				   bindInfoWindow(myMarker, map, infoWindow, html);
				 }

			      };//for
			      markers=[];
			      var lPPage=8;
			      var pn=1;
			      var al=true;
			      var imgpath='<?php echo $imgtmb.$image_base."/";?>';
			      sortPriceAsc();
			      showList(0);
		    }
	      });


	    function bindInfoWindow(marker, map, infoWindow, html) {
	      marker.content.addEventListener('mouseover', function() {
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
	      });

	      marker.content.addEventListener('mousedown', function() {
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
	      });

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
	    };

	    function doNothing() {}

	   }); // end of listener callbck
	//]]>


	};
	 function showLTab(){
           UIkit.switcher('#v-control').show('#lid');
           UIkit.switcher('#v-control').show('#tlid');
         } 
         // Was bound to window 'load' (waits for every image/analytics beacon to finish,
         // which can hang indefinitely and silently prevent the map from ever initializing).
         // DOMContentLoaded/jQuery ready is sufficient since we only need the #map div present.
         jQuery(document).ready(function() { initialize(); });
 //end of wait to get ready
// }); //end of wait to get ready
</script>
