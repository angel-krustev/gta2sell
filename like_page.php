<?php include 'form-like.php' ?> 
 <div class="uk-container uk-container-center uk-grid-medium uk-padding-remove"  >

     <div class="uk-block">
           <div class="uk-grid" id="liked"  style="margin-top: 5px;" >
           </div>
           <div id="expiredmsg"  style="margin-top: 35px;" >
           </div>
           <div id="likenote"  style="margin-top: 35px;" >
           </div>
     </div>
 </div>
<script>
function reflike(likeid,like){
if (confirm('Are you sure you want to delete the saved property?')) {
    switchlike(likeid,like);
    getlike();
  } else {
    // location.reload(); 
  }
}
function getlike(){
  var pgURL='/get_cl_like';
  var mparam=$('#likelist').val();
  $.ajax({
        url : pgURL,
        method: "POST",
        data: { ilike : mparam },
        dataType: "xml",
        success : function(xml) {
          var result = xml.documentElement.getElementsByTagName("result");
          jQuery("#liked").html(result[0].getAttribute('liked')); // result is the HTML text
          if(result[0].getAttribute('expired') !== null ){
             expArray=result[0].getAttribute('expired').split(":");
             for (var i = 0; i < expArray.length; i++) {
                 if(expArray[i] !== null && expArray[i] !== ''){
                       idontlikeitH('heart-'+expArray[i],'likelist');
                 }
             }
             jQuery("#expiredmsg").html(result[0].getAttribute('expiredmsg')); // result is the HTML text
          }
        },
  });
 }

$(document).ready(function() {
  getlike();
});
</script>

<?php
#include 'js-email.php';
?>
