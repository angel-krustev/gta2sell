<script type=text/javascript>

 var placeSearch, autocomplete, bLat,bLon,bAddr,aLat,aLon,aAddr;
 var aChange = false;
 var kChange = false;
      var componentForm = {
        ulat: 'lat',
        ulon: 'lng',
        addr: 'formatted_address',
      };

      function initAutocomplete() {
            var defaultBounds = new google.maps.LatLngBounds(
                   new google.maps.LatLng(42.052522,-83.109741),
                   new google.maps.LatLng(45.626204,-74.864502)
                   )

              var options = {
                   componentRestrictions: {country: 'ca' },
                   bounds: defaultBounds
                  }

        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('addr')),
            options);

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
               aChange = true;
         var location= place.geometry.location;
                       $("#ulat").val(location.lat());
                       $("#ulon").val(location.lng());
                       $("#addr").val(place.formatted_address);
                       onSubmit(curFrm,5256000);
      }

      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
      function isAddrOK() {
          var retOk = ( (kChange == aChange ) || aChange );
          kChange=aChange=false;
          return retOk;
      }
      function onChange(){
               kChange = true;
      }
</script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXmmJE2W7c10R7LcGQOAH28N4Vbv30VKE&libraries=places&callback=initAutocomplete" async defer></script>

