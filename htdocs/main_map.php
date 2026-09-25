<div id="map" style="width:100%; height:400px; z-index:1; "></div>
      <script type='text/javascript' >
          function CoordMapType(tileSize) {
          this.tileSize = tileSize;
      } 
  CoordMapType.prototype.getTile = function(coord, zoom, ownerDocument) {
           var img = ownerDocument.createElement('img');
               img.src="/tile/"+zoom+"/"+coord.x+"/"+coord.y;
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
    var allMarkers=[];
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

function initialize() {
  var myLatlng = new google.maps.LatLng(lat,lon);
  var mapOptions = {
    minZoom: 14,
    zoom: 18,
    center: myLatlng,
    scrollwheel: false,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}

  }
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
  var myIcon = customIcons["<?php echo getPropertyType($type_own_srch).'F'; ?>"] || {};
  var marker = new MarkerWithLabel({
      position: myLatlng,
      map: map,
      zIndex:  2,
      icon:  myIcon.icon,
       title: '<?php echo $addr; ?>',
       labelContent: "<?php echo bd_nice_number($lp_dol);?>",
       labelAnchor: new google.maps.Point(25, 0),
       labelClass: "rlabels", // the CSS class for the label
       labelStyle: {opacity: 0.85}
  });

   map.overlayMapTypes.insertAt( 0, new CoordMapType(new google.maps.Size(256, 256)));
   google.maps.event.addListener(marker,'click',function(event) {
          map.setZoom(map.getZoom()+1);
          map.setCenter(marker.getPosition());
  });

 google.maps.event.addListener(map,'idle', function(event) 
 {
   var bounds = map.getBounds();
   var ne = bounds.getNorthEast();
   var sw = bounds.getSouthWest();

    //<![CDATA[
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      var parm="?z="+map.getZoom()+"&ml_num=<?php echo $ml_num; ?>&nelat="+ne.lat()+"&nelng="+ne.lng()+"&swlat="+sw.lat()+"&swlng="+sw.lng();
      downloadUrl("get_cl_markers.php",parm, function(data) {
      deleteMarkers();
		      var xml = data.responseXML;
		      var markers = xml.documentElement.getElementsByTagName("marker");
		      for (var i = 0; i < markers.length; i++) {
		        var asking = markers[i].getAttribute("asking");
		        var address = markers[i].getAttribute("addr");
		        var building = markers[i].getAttribute("building");
		        var type_own_srch = markers[i].getAttribute("type_own_srch");
		        var iconName   = markers[i].getAttribute("icon");
		        var min = markers[i].getAttribute("min");
		        var max = markers[i].getAttribute("max");
		        var count = markers[i].getAttribute("count");
		        var point = new google.maps.LatLng(
			    markers[i].getAttribute("lat"),
			    markers[i].getAttribute("lon"));
		        var html ="";
		        var icon = customIcons[iconName] || {};
                        var msg = (count == 1 ? asking : count);
                        var shift = (count == 1 ? '0' : '35');
/**/
                            if (  map.getZoom() > 18 &&  markers[i].getAttribute("lat")== lat && markers[i].getAttribute("lon")== lon){
                                    point = new google.maps.LatLng(
                                          markers[i].getAttribute("lat"),
                                          markers[i].getAttribute("lon")-0.00004);
                            }else if (   markers[i].getAttribute("lat")== lat && markers[i].getAttribute("lon")== lon){
                                    point = new google.maps.LatLng(
                                          markers[i].getAttribute("lat"),
                                          markers[i].getAttribute("lon")-0.00004);
                                             msg='';

                            }
/**/
                        var label = (count == 1 ? 'labels' : 'clabels');
                            if(map.getZoom() > 15 && count > 1 && building == 'condo' ){
                              html = "<b>"+address+"</b></br>"+count+" units, from "+min+" up to "+max;
                              shift = 0;
                              label = 'labels';
                              msg = max>min?"+"+min:min;
		              icon = customIcons['condo'] || {};
                            }
                            if(map.getZoom() > 15 && count > 1 && building == 'townhouse' ){
                              html = max>min?"<b>"+address+"</b></br>"+count+" units, from "+min+" up to "+max:"<b>"+address+"</b></br>"+count+" units, x "+min;
                              shift = 0;
                              label = 'labels';
                              msg = max>min?"+"+min:min;
		              icon = customIcons['townhouse'] || {};
                            }
                            if( map.getZoom() < 15 &&  count == 1 ){
                              msg = '';
                            }
                        var myMarker = new MarkerWithLabel({
                          map: map,
                          zIndex:  -1,
                          title:  address,
                          position: point,
                          icon: icon.icon,
                          labelContent: msg,
                          labelAnchor: new google.maps.Point(25, shift),
                          labelClass: label, // the CSS class for the label
                          labelStyle: {opacity: 0.75}
                        });
                        allMarkers.push(myMarker);
                        google.maps.event.addListener(myMarker,'click',function(event) {
                                map.panTo(this.getPosition());
                                map.setZoom(map.getZoom()+1);
                         });

                         if( (map.getZoom() > 15 &&  count > 1 && building == 'condo' ) || (map.getZoom() > 15 && count > 1 && type_own_srch == 'A.'  ) ){
                           bindInfoWindow(myMarker, map, infoWindow, html);
                         }
                      }
                      markers=[];

      });

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'mouseover', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

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

   }); // end of listener callbck
  //]]>


}
google.maps.event.addDomListener(window, 'load', initialize);


</script>
