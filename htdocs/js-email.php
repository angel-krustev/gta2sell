<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/notify.js"> </script>

<script type="text/javascript" >

$('document').ready(function() {
   var email = '';
   var name = '';
   var phone = '';
   var msg = '';
   var addr_info = '';
   var mls = '';
   var at = '';
   var tp = '';
   var frm = '';
   var error = 0;

    var eform = $('#eform');
    eform.submit(function(){ return false; });
    $('#eform-submit').click(function(e){
           var phonePattern = /^((([0-9]{3}))|([0-9]{3}))[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4}$/;
           var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
           var fields = $("#eform input[type='text'], textarea, input[type='hidden'], input[type=email]");
               error = 0;

        if(eform.is('.emailing, .emailed')){
            return false;
        }

         var   messageHolder = eform.find('#status');
         var   emsg="";

        fields.each(function(){

            var value = $(this).val();
            if(  $(this).attr('id')=='em' ) {
               if( !emailPattern.test(value)   ) {
                 // $(this).addClass('uk-alert-warning');
                  $( "#em" ).focus();
                  emsg = "A valid email is required!";
                  error++;
               } else {
        //          $(this).addClass('uk-form-success');
                  email = value;
              }
            }
            if(  $(this).attr('id')=='mls'   ) {
               if( value != null  ) {
         //          $(this).addClass('uk-form-success');
                   mls = value;
               }
            }
            if(  $(this).attr('id')=='at'   ) {
               if( value != null   ) {
          //         $(this).addClass('uk-form-success');
                   at = value;
               }
            }
            if(  $(this).attr('id')=='addr_info'   ) {
               if( value != null   ) {
           //        $(this).addClass('uk-form-success');
                   addr_info = value;
               }
            }
            if(  $(this).attr('id')=='cph'   ) {
               if( !phonePattern.test(value)   ) {
                  // $(this).addClass('uk-form-danger');
                   emsg = "A valid phone# is required!";
                   $( "#cph" ).focus();

                   error++;
               } else {
            //       $(this).addClass('uk-form-success');
                   phone = value;
               }
            }
            if($(this).attr('id')=='fn' ){
               if( value.length < 3 ) {
                  // $(this).addClass('uk-form-danger');
                   emsg = "Please enter your first and last name.";
                   $( "#fn" ).focus();
                   error++;
               } else {
             //      $(this).addClass('uk-form-success');
                   name = value;
               }
            }
            if($(this).attr('id')=='msg' ){
               if( value.length < 10 ) {
                   $(this).addClass('uk-form-danger');
                   emsg = "Minimum 10 chars are required.";
                   $( "#msg" ).focus();
                   error++;
               } else {
              //     $(this).addClass('uk-form-success');
                   msg = value;
               }
           }
            if($(this).attr('id')=='tp' ){
                   tp = value;
            }
            if($(this).attr('id')=='frm' ){
                  frm = value;
            }
        });
        if(!error) {
           messageHolder.removeClass('uk-alert uk-alert-warning')
           e.preventDefault();
           $.post(eform.attr('action'), {at: at, em: email,cph: phone,fn: name, addr_info: addr_info, msg: msg, tp: tp, frm: frm}, function(m){
           if(m.error){
                messageHolder.addClass('uk-alert uk-alert-warning')
                messageHolder.text(m.message);
                error++;
           }
           else{
                setTimeout(function() {
                messageHolder.removeClass('uk-alert uk-alert-warning')
                messageHolder.addClass('uk-alert uk-alert-success')
                messageHolder.text("Your request has been sent." );

                 }, 3000);

          }
        });
       } else {
                messageHolder.addClass('uk-alert uk-alert-warning')
                messageHolder.text(emsg);
       }
     });
       if(!error) {
        $(document).ajaxStart(function(){
            eform.addClass('emailing');
                 $("#eform-submit").prop('disabled', true);
                 $("#msg").prop('disabled', true);
                 $("#fn").prop('disabled', true);
                 $("#cph").prop('disabled', true);
                 $("#em").prop('disabled', true);
                 jQuery("#status").html("<div style=\"display: none;\" aria-hidden=\"true\" id=\"email-spinner\"  class=\"uk-text-center\"> <i class=\"uk-icon uk-icon-spinner uk-icon-spin\"></i> </div>");
                 $('#email-spinner').attr("aria-hidden","false");
                 $('#email-spinner').show();
        });
        $(document).ajaxComplete(function(){
                $("#eform-submit").prop('disabled', true);
        });
       }
       error=0;

});
</script>
