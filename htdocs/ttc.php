       <div id="transit-wpr">
         <button id="transit">Toggle transit layer</button>
       </div>
       <div id="map" style="width:100%; height:400px; z-index:0;"></div>
<script>
      var directions = new google.maps.DirectionsService();
      var renderer = new google.maps.DirectionsRenderer();
      var map, transitLayer;

      function initialize() {
        var myLatLng = {lat: <?php echo $lat?>, lng:  <?php echo $lon?>};

        var mapOptions = {
          zoom: 18,
          center: myLatLng,
          scaleControl: true,
          scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);

        google.maps.event.addDomListener(document.getElementById('go'), 'click', route);

        var input = document.getElementById('from');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var tinput = document.getElementById('to');
        var tautocomplete = new google.maps.places.Autocomplete(tinput);
        tautocomplete.bindTo('bounds', map);


        transitLayer = new google.maps.TransitLayer();

        var control = document.getElementById('transit-wpr');
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(control);

        google.maps.event.addDomListener(control, 'click', function() {
          transitLayer.setMap(transitLayer.getMap() ? null : map);
        });

      //  addDepart();
      //  route();
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: '<?php echo $addr?>'
        });

      }

      function addDepart() {
        var depart = document.getElementById('depart');
        for (var i = 0; i < 24; i++) {
          for (var j = 0; j < 60; j += 15) {
          var x = i < 10 ? '0' + i : i;
          var y = j < 10 ? '0' + j : j;
          depart.innerHTML += '<option>' + x + ':' + y + '</option>';
        }
        }
      }

      function route() {
/*
        var departure = document.getElementById('depart').value;
        var bits = departure.split(':');
        var now = new Date();
        var tzOffset = (now.getTimezoneOffset() + 60) * 60 * 1000;

        var time = new Date();
        time.setHours(bits[0]);
        time.setMinutes(bits[1]);

        var ms = time.getTime() - tzOffset;
        if (ms < now.getTime()) {
          ms += 24 * 60 * 60 * 1000;
        }

        var departureTime = new Date(ms);
i*/
        var request = {
          origin: document.getElementById('from').value,
          destination: document.getElementById('to').value,
          travelMode: google.maps.DirectionsTravelMode.TRANSIT,
          provideRouteAlternatives: true,
          transitOptions: {
   //         departureTime: departureTime
          }
        };

        var panel = document.getElementById('panel');
        panel.innerHTML = '';
        directions.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            renderer.setDirections(response);
            renderer.setMap(map);
            renderer.setPanel(panel);
          } else {
            renderer.setMap(null);
            renderer.setPanel(null);
          }
        });

      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
