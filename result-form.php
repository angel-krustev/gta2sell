<?php

?>
        <style>
          .uk-button-large {
             min-height: 50px;
             padding: 5px 5px ;
             line-height: 50px;
          }
        </style>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/notify.min.js"></script>

<script>
UIkit.notify({
    message : 'Plase wait...',
    timeout : 1000,
    pos     : 'top-center'
});
</script>


                     <div id="to-pdf" class="uk-container uk-margin-bottom uk-margin-top">
                          <div class="uk-grid uk-grid-match" data-uk-grid-margin >
			      <div class="uk-width-small-1-1 uk-width-medium-2-3 uk-width-large-2-3 uk-width-xlarge-2-3 uk-row-first" data-uk-grid-match="{target:'.uk-panel'}">
                                   <div class="uk-panel uk-panel-box uk-panel-header">
                                         <div id="ui"></div>
                                         <div style="margin-top: 10px;display: none; overflow-y: hidden;" aria-hidden="true"  id="form" >
                                                        <?php
                                                            include 'result-form-mautic.php';
                                                        ?>
                                                                    <div class="uk-width-1-1">
This is a computer generated report and it should be used for information purposes only. GTA2SELL.CA and all parties associated with the website are not responsible for any loss caused by using this estimation. We strongly recommend you to use a Real Estate agent for a home price estimation in a case of selling or buying a property.<br>
                                                                      </div>

                                         </div>

                                         <div class="uk-form-row" id="status"></div>
                                         <div class="uk-margin-large-left uk-margin-large-right" >
                                            <?php
                                             if (isset($_COOKIE[$cookie_name]) )  {
                                               $cem=base64_decode($_COOKIE[$cookie_name]);
                                               $user = User::findByEmail($cem);
                                             }
                                            ?>
                                        </div>
                                        <div class="uk-container uk-container-center uk-text-center" style="display: none; overflow-y: hidden;" aria-hidden="true" id="spinner" >
                                          <i class="uk-text-center uk-icon-large uk-icon-spinner uk-icon-spin" style="overflow-y: hidden;" ></i>
                                        </div>
                                   </div>
                              </div>
                              <div class="uk-width-small-1-1 uk-width-medium-1-3 uk-width-large-1-3 uk-width-xlarge-1-3">
                                           <?php include 'elza-contact-v.php' ?>
                              </div>
                          </div>
                     </div>
<script type=text/javascript>

var td=(new Date()).toISOString().slice(0,10);

var chartVar="";
chartVar += "                                                         <div class=\"uk-grid\" >";
chartVar += "                                                                   <div class=\"uk-width-1-1\" id=\"htext\" >";
chartVar += "<h3 class=\"uk-panel-title uk-text-left\" ><b>Estimation as of "+td+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:genPDF();\" class=\"button\"><img src=\"/pdf-d.jpg\"></a></h3>";
chartVar += "                                                                   <div class=\"uk-width-1-1 uk-text-justify\" id=\"tip\"  style=\"margin-top: 15px; margin-bottom: 15px;\" >";
chartVar += "                                                                   </div>";
chartVar += "                                                                   <div class=\"uk-width-1-1 uk-text-large uk-text-center uk-text-bold\" id=\"sale\"  style=\"margin-top: 10px;\" >";
chartVar += "                                                                   </div>";
chartVar += "                                                                   <div id=\"lease\" class=\"uk-width-1-1 uk-text-large uk-text-center uk-text-bold\"  style=\"margin-top: 15px;\" >";
chartVar += "                                                                   </div>";
chartVar += "                                                                   <div class=\"uk-width-1-1\">&nbsp;</div>";
chartVar += "                                                                        <div class=\"uk-width-1-1\">";
chartVar += "                                                                             <div class=\"uk-alert uk-danger\">";
chartVar += "                                                                       For a more accurate home evaluation, a visit to your home will allow me to determine how its unique features and upgrades may add to the value. <br>Please don't forget to ask me for the <b>CASHBACK</b> option!";
chartVar += "                                                                             </div>";
chartVar += "                                                                        </div>";
chartVar += "                                                                   </div>";

chartVar += "                                                          </div>";

function getEst(tk){
    var messageHolder = $('#status'); 

    if( tk == '' ){
        messageHolder.addClass('uk-alert uk-alert-warning')
        messageHolder.text("A valid address is required.");
        return false;
    }
    messageHolder.removeClass('uk-alert uk-alert-warning');
    messageHolder.text("");
    var data =  {tk: tk };
                  var pgURL="/get_cl_est_landing";
                      $('#spinner').show();
                      $.ajax({
                        url: pgURL,
                        type: "POST",
                        data: data,
                        dataType: "xml",
                        success: function(xml){
                             var result = xml.documentElement.getElementsByTagName("result");
                                 jQuery("#average_dom_sold").html(result[0].getAttribute("average_dom_sold"));
                                 $('#spinner').hide();
                                 $('#form').show();
                               //(function (UI) {
                               //  UI.on('ready.uk.dom', function(){
                                  if(result[0].getAttribute("error") == null || result[0].getAttribute("error") == ''  ){
                                    jQuery('#ui').html(chartVar);
                                    jQuery("#sale").html(result[0].getAttribute("sale"));
                                    var  type_gr='car(s) garage';
                                    if(result[0].getAttribute("rtype") == 'condo' || result[0].getAttribute("rtype") == 'condo-townhouse'){
                                       type_gr='parking spot(s)';
                                    }
                                    jQuery("#tip").html("The recommneded asking price for a "+result[0].getAttribute("rtype")+" in close distance from <b>"+ result[0].getAttribute("addr")+ "</b> with "+result[0].getAttribute("br")+" beds, "+result[0].getAttribute("bath")+ " baths,  "+result[0].getAttribute("gr")+" "+type_gr+" and approximatly "+result[0].getAttribute("sqf") +" sq/ft living area is:" ) ;
                                    UIkit.notify( 
{
    message : "<i class='uk-icon-check'></i>*Your are eligible for up to "+result[0].getAttribute("cashback")+" cashback. <br><br><div class=\"uk-text-small\">*Some conditions apply.</span>",
    timeout : 8000,
    pos     : 'top-center'
})
                                    var br = eval(result[0].getAttribute("brData"));
                                    var bath = eval(result[0].getAttribute("bathData"));
                                    var gr = eval(result[0].getAttribute("grData"));
                                  $("#mauticform_input_evaluationappointment_email").val(result[0].getAttribute("email") );
                                  $("#mauticform_input_evaluationappointment_full_name").val(result[0].getAttribute("full_name") );
                                  $("#mauticform_input_evaluationappointment_contact_phone").val(result[0].getAttribute("phone") );
                                  $("#mauticform_input_evaluationappointment_address").val(result[0].getAttribute("address")  );
                                  $("#mauticform_input_evaluationappointment_g_beds").val(result[0].getAttribute("br")  );
                                  $("#mauticform_input_evaluationappointment_baths").val(result[0].getAttribute("bath")  );
                                  $("#mauticform_input_evaluationappointment_garage").val(result[0].getAttribute("gr")  );
                                  $("#mauticform_input_evaluationappointment_sqft").val(result[0].getAttribute("sqf")  );
                                  $("#mauticform_input_evaluationappointment_property_type").val(result[0].getAttribute("type")  );
                                  $("#mauticform_input_evaluationappointment_planing").val(result[0].getAttribute("planing")  );
                                  $("#mauticform_input_evaluationappointment_token").val(result[0].getAttribute("token") );
                                  $("#mauticform_input_evaluationappointment_estimated_price").val(result[0].getAttribute("sale")  );
                                  $("#mauticform_input_evaluationappointment_cashback").val(result[0].getAttribute("cashback")  );
                                  jQuery("#ctitle").html($("#addr").val());
                                   }else{
                                      messageHolder.addClass('uk-alert uk-alert-warning')
                                      messageHolder.text(result[0].getAttribute("error"));
                                   }
                                 //} (UIkit));
                                 //   UIkit.domObserve('#ui', function(element) {
                                 //   });
                              //});
                           },
                           error: function(xhr, status, error){
                                 console.warn(xhr.responseText);
                                 messageHolder.addClass('uk-alert uk-alert-warning')
                                 messageHolder.text("Sorry, we coudn't complete your request. Please change the address and try again ... Sorry for the inconvinience.");
                           }

                   });
}
 getEst('<?php echo $tk;?>');
 function genPDF(){
          var pdf = new jsPDF('p', 'pt', 'a4');
              pdf.addHTML(document.body, function() {
              pdf.save('Price-Estimation.pdf');
          })
 }



</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
