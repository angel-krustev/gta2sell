    <script type='text/javascript' >
//$('document').ready(function() {

    map;
    var activeInfoWindow ;	
    var allMarkers=[];
    var showBack="";
    var backZ="<span style=\"margin-top: 5px; float:right \"><a href=\"#\"  onclick=\"backZoom();\" >&nbsp;&nbsp;<<&nbsp;Go Back</a>&nbsp;&nbsp;</span>";
    var isc="";
    var isr="";
    //var ulat='43.67023';
    //var ulon='-79.38676';
    var ulat='';
    var ulon='';
    var latlon='';
    var list=[];
    var initZoom=16;
    var minZoom=14;
    var cl=true;
    var imgpath='<?php echo $imgtmb.$image_base."/";?>';
        if(  $("#zoom").val() !='' ){
                initZoom=$("#zoom").val();
        }
        if(  $("#ulat").val() !='' &&  $("#ulon").val() !=''){
                ulat=$("#ulat").val();
                ulon=$("#ulon").val();
        }
function setItem(item,img){
         var htmlItem="<div class=\"uk-width-medium-1-1\">";
         var price=(item.count==1)?item.asking:"From "+item.min+" to "+item.max;
                         if( item.count > 1){
                                htmlItem += "<div class=\"uk-panel uk-panel-box\" onmouseover=\"changeMarkerOver("+item.index+")\" onmouseout=\"changeMarkerOut("+item.index+")\" onclick=\"seeCluster("+item.index+",\'"+item.multiple+"\');\" >";
                                htmlItem += "   <div class=\"uk-grid\">";
                                htmlItem += "           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                   <img width=\"150\" height=\"110\"  onerror=\"imgError(this);\" src=\"u\">";
                                htmlItem += "           </div>";
                                htmlItem += "           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                   <div class=\"uk-panel-badge uk-badge uk-badge-danger\">";
                                htmlItem +=                     price;
                                htmlItem += "                   </div>";
                                htmlItem += "                   <span  class=\"uk-text-bold\"><br>Full List</span>";
                                htmlItem += "           </div>";
                                htmlItem += "   </div>";
                                htmlItem += "</div>";
                         }else{
                                htmlItem += "<div  data-uk-modal=\"{target:'#modal-"+item.ml_num+"'}\" >";
                                htmlItem += "           <div class=\"uk-panel uk-panel-box\" onmouseover=\"changeMarkerOver("+item.index+");\" onmouseout=\"changeMarkerOut("+item.index+");\" >";
                                htmlItem += "                   <div class=\"uk-grid\">";
                                htmlItem += "                           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                                   <img width=\"150\" height=\"110\"  onerror=\"imgError(this);\"  src=\""+img+"\">";
                                htmlItem += "                           </div>";
                                htmlItem += "                           <div class=\"uk-width-medium-1-2\"></br>";
                                htmlItem += "                                   <div class=\"uk-panel-badge uk-badge uk-badge-danger\">";
                                htmlItem +=                                             price;
                                htmlItem += "                                   </div>";
                                htmlItem +=                                             item.building+"</br>"+item.bed+" bedroom(s)</br>"+item.bath+" bath(s)";
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
                          //htmlList += showBack;
                          jQuery("#srt").html(htmlList);
                          htmlList="";
                      for(index = 0; index < list.length; index++) {
                                  var price=(list[index].count==1)?list[index].asking:"From "+list[index].min+" to "+list[index].max;
                                  var img  = imgpath+list[index].ipath+"/image_"+list[index].ml_num+"_1.jpg&w=150&h=110";
                                  var Mimg  = imgpath+list[index].ipath+"/image_"+list[index].ml_num+"_1.jpg&w=600&h=400";
                                  htmlList += setItem(list[index],img);
                         if( list[index].count == 1){
				htmlModalList += "<div id=\"modal-"+list[index].ml_num+"\" class=\"uk-modal\">";
				htmlModalList += "		<div class=\"uk-modal-dialog uk-modal-dialog-lightbox\">";
				htmlModalList += "			<a href=\"\"  style=\"z-index:1;\" class=\"uk-modal-close uk-close uk-close-alt\"></a>";
				htmlModalList += "			<div class=\"uk-grid\" >";
				htmlModalList += "				<div class=\"uk-width-medium-1-1\">";
				htmlModalList += "					<figure class=\"uk-overlay\">";
				htmlModalList += "						<img width=\"600\" height=\"400\" src=\""+Mimg+"\" alt=\"\">";
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
				htmlModalList += "					<a class=\"uk-button uk-button-primary\" href=\"/"+"<?php echo $property_url.'?ml_num=';?>"+list[index].ml_num+"\">View Full Listing&nbsp;";
				htmlModalList += "                                  		<i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;";
                                htmlModalList += "                                   </a>";
				htmlModalList += "				</div>";
				htmlModalList += "			</div>";
				htmlModalList += "		</div>";
				htmlModalList += "</div>";
                         }
                       }
                                jQuery("#list").html(htmlList);
                                jQuery("#modalList").html(htmlModalList);
                                jQuery(document).ready(function($) {
                                      $.UIkit.modal('#modal-spinner').hide();
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
          ulat=list[i].lat;
          ulon=list[i].lon;

         if(m == 'y' ){
          latlon="&ulat="+ulat+"&ulon="+ulon;
          isc="&c=n";
          isr="&nr=0";
          cl=false; 
          showBack=backZ;
         }

         var myLatlng = new google.maps.LatLng(ulat,ulon);
         map.setCenter(myLatlng);
         if(map.getZoom() >= minZoom){
             map.setZoom(map.getZoom()+1);
         }
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
               img.src="ts/tile.php?z="+zoom+"&x="+coord.x+"&y="+coord.y;
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



// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < allMarkers.length; i++) {
    allMarkers[i].setMap(map);
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
        var southWest = "";
        var northEast = "";
        var gtaBounds = "";
        //southWest = new google.maps.LatLng( 44.495526, -78.2350160 );
        //northEast = new google.maps.LatLng( 44.495526, -78.235016 );
        //gtaBounds = new google.maps.LatLngBounds( southWest, northEast );
        // var cLatlng = new google.maps.LatLng(ulat,ulon);
        // gtaBounds =  map.boundsAt(initZoom,cLatlng);
        
     //onSubmit('fc',5256000);
                //.geocomplete({blur: false, bounds: gtaBounds,  country: 'ca', state: 'on',
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

        $("#addr")
                .geocomplete({blur: false, country: 'ca', state: 'on',
                restoreValueAfterBlur: true})
                .bind("geocode:result", function (event, result) {
                       $("#ulat").val(result.geometry.location.lat());
                       $("#ulon").val(result.geometry.location.lng());
                       onSubmit('fc',5256000);
                       //initialize();
        });

function initialize() {
        jQuery(document).ready(function($) {
             $.UIkit.modal('#modal-spinner').show();
        });
             ulat=getInputValue('fc','ulat',ulat);
             ulon=getInputValue('fc','ulon',ulon);
     if ( (ulat == null && ulon==null) || (    ulat=='' && ulon=='') ){
           ulat='43.67023';
           ulon='-79.38676';

        //ulat=$("#ulat").val();
        //ulon=$("#ulon").val();
     }
  var myLatlng = new google.maps.LatLng(ulat,ulon);
  var mapOptions = {
    minZoom: minZoom, 
    zoom: initZoom,
    center: myLatlng,
    scrollwheel: false,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
        map.setCenter(myLatlng);

  var myIcon = customIcons["<?php echo getPropertyType($type_own_srch).'F'; ?>"] || {};
  var marker = new MarkerWithLabel({
      position: myLatlng,
      map: map,
      zIndex:  2,
      title: '<?php echo $addr; ?>',
      // labelContent: "<?php echo bd_nice_number($lp_dol);?>",
      labelAnchor: new google.maps.Point(25, 0),
      // labelClass: "rlabels", // the CSS class for the label
      labelStyle: {opacity: 0.85}
  });

   map.overlayMapTypes.insertAt( 0, new CoordMapType(new google.maps.Size(256, 256)));
   google.maps.event.addListener(marker,'click',function(event) {
          map.setZoom(map.getZoom()+1);
          map.setCenter(marker.getPosition());
  });
  google.maps.event.addListener(marker, 'mouseout', function() {
  });

   map.addListener('dragend', function() {
         ulon=map.getCenter().lng();
         ulat=map.getCenter().lat();
         $("#ulon").val(ulon);
         $("#ulat").val(ulat);
         $("#addr").val("");
   });
   map.addListener('drag', function() {
          cl=true;
   });
   map.addListener('zoom_changed', function() {
          cl=true;
          initZoom=map.getZoom() ;
   });
   map.addListener('bonds_changed', function() {
          cl=true;
   });
  var s_r="";
  if($('#sale').is(':checked')) {
    s_r='&s_r=Sale';
  }else if ($('#lease').is(':checked')){
    s_r='&s_r=Lease';
  }else if ($('#s_sale').is(':checked')){
    s_r='&s_r=Sale';
  }
 var sForm = "&bed="+$("#bed").val()+"&bath="+$("#bath").val()+"&minp="+$("#minp").val()+"&maxp="+$("#maxp").val()+"&rtype="+$("#rtype").val()+s_r;

 google.maps.event.addListener(map,'idle', function(event) 
 {
   var bounds = map.getBounds();
   var ne = bounds.getNorthEast();
   var sw = bounds.getSouthWest();
      var infoWindow = new google.maps.InfoWindow;
      var parm="?z="+map.getZoom()+"&ml_num=<?php echo $ml_num; ?>&nelat="+ne.lat()+"&nelng="+ne.lng()+"&swlat="+sw.lat()+"&swlng="+sw.lng()+latlon+isc+isr+sForm;
      downloadUrl("get_cl_markers.php",parm, function(data) {
                            deleteMarkers();
                            latlon=isc=isr='';
		        var xml = data.responseXML;
		        var markers = xml.documentElement.getElementsByTagName("marker");
                            list=[];
                            showBack="";
		      for (var i = 0; i < markers.length; i++) {
		        var asking = markers[i].getAttribute("asking");
		        var ml_num = markers[i].getAttribute("ml_num");
		        var ipath = markers[i].getAttribute("ipath");
		        var addr = markers[i].getAttribute("addr");
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
                        var aList = {ml_num:ml_num,ipath:ipath,asking:asking,addr:addr,bed:bed,bath:bath,lat:xlat,lon:xlon,min:min,max:max,rltr:rltr,count:count,dom:dom,community:community,type_own1_out:type_own1_out,index:i,building:building,multiple:multiple,lp_dol:lp_dol,cluster:cluster};
                        list.push(aList);
                        var img  = imgpath+ipath+"/image_"+ml_num+"_1.jpg&w=100&h=60";
                        var html="";
		        var icon = customIcons[iconName] || {};
                        var msg = (count == 1 ? asking : count);
                        var title = (count == 1 ? addr : '');
                        var shift = (count == 1 ? '0' : '35');
                        var label = (count == 1 ? 'labels' : 'clabels');
                           if(map.getZoom() > 15 && multiple == 'y' && (count > 1 ||  cluster == 'n') && building == 'condo'  ){
                              html = "<b>"+addr+"</b></br>"+count+" units, from "+min+" up to "+max;
                              shift = 0;
                              label = 'labels';
                              msg = "+"+min;
		              icon = customIcons['condo'] || {};
                           }
                           if(map.getZoom() > 15 && multiple == 'y' &&  (count > 1  ||  cluster == 'n') && building == 'townhouse' ){
                              html = "<b>"+addr+"</b></br>"+count+" units, from "+min+" up to "+max;
                              shift = 0;
                              label = 'labels';
                              msg = "+"+min;
		              icon = customIcons['townhouse'] || {};
                           }
                           var idx = i;
                           if(  cluster == 'n' && (building == 'condo' ||  building == 'townhouse' )  ){
                               idx=0;
                               msg=markers.length+' units';
                               html = "<b>"+addr+"</b></br>"+markers.length+" units";
                               showBack=backZ;
                           }
                           if( html == null || html == ""){
                               html = "<div  data-uk-modal=\"{target:'#modal-"+ml_num+"'}\" >";
                               html += "<b>"+addr+"</b></br>"+bed+" beds/"+bath+" baths<br>"+asking+" for "+s_r;
                               html += "&nbsp;<i class=\"uk-icon-justify uk-icon-hand-o-right\"></i></div>";
                           };

                           if(  cluster != 'n' || i == 0 ){
                                 var myMarker = new MarkerWithLabel({
                        		map: map,
                          		zIndex:  -1,
                         		title:  title,
                          		position: point,
                          		icon: icon.icon,
                          		labelContent: msg,
                          		labelAnchor: new google.maps.Point(25, shift),
                          		labelClass: label,
                          		labelStyle: {opacity: 0.75}
                           });
                                        allMarkers.push(myMarker);
                                        myMarker.set(ml_num);
                           };

                         google.maps.event.addListener(myMarker,'click',function(event) {
                                var modal = UIkit.modal("#modal-"+ml_num);
                                    modal.show();
                         });
                         if( map.getZoom() > 15 &&  count > 1 &&  multiple == 'y'){
                           bindInfoWindow(myMarker, map, infoWindow, html);
                         }else if ( count == 1){
                           bindInfoWindow(myMarker, map, infoWindow, html);
                         }

                      };
                      markers=[];
                      var lPPage=8;
                      var pn=1;
                      var al=true;
                      var imgpath='<?php echo $imgtmb.$image_base."/";?>';
                      sortPriceAsc();
                      showList(0);
      });


    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'mouseover', function() {
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
google.maps.event.addDomListener(window, 'load', initialize);

// }); //end of wait to get ready
</script>
