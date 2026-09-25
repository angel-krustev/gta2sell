<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/notify.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/form-select.js"> </script>
<script type="text/javascript" >
 function getScreenSize(){
        //if ( $(window).width() < 768) {
        if ( $(window).width() < 960) {
          return "small";
        }
        //else if ( $(window).width() < 960) {
        else if ( $(window).width() < 1000) {
          return "medium";
        }
        else if ( $(window).width() < 1220) {
          return "large";
        }
        else {
          return "xlarge";
        }
 }
function setScreenHWCookie() {
    // Function to set persistant (default) or session cookie with screen ht & width
    // Returns true if cookie matches screen ht & width or if valid cookie created
    // Returns false if cannot create a cookies.
    var ok  = getCookie( "shw");
    var shw_value = getScreenSize();
    if ( ! ok || ok != shw_value ) {
        var expires = 1 // days
        var ok = setCookie( "shw", shw_value, expires)
        if ( ok == "" ) {
            // not possible to set persistent cookie
            expires = 0
            ok = setCookie( "shw", shw_value, expires)
            if ( ok == "" ) return ok// not possible to set session cookie
        }
        window.location.reload();
    }
    return shw_value;
}

 function noResults(){
   var nmsg="Your search returned:<br>";
       nmsg += "<h2>No Results</h2>";
       msg += "Please refine your search criteria.<br>";
       nmsg += "Suggestions:<br>";
       nmsg += "Modify your search criteria<br>";
       nmsg += "Update your search location<br>";
       nmsg += "Broaden your map area<br>";
       nmsg += "Modify your keywords<br>";
       UIkit.notify(nmsg, {timeout: 0});
 }

function thisScript(){
  return  url.substring(url.lastIndexOf('/')+1);
}

function ActiveScript(scriptName){
}

</script>
