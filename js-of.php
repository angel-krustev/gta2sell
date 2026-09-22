<script type="text/javascript" >
function of(fn,rd_url){
$('document').ready(function() {
    $('#phone_'+fn).mask("999-999-9999");
    var field_values = {
            'name'  : 'full name',
            'phone'  : 'phone',
            'email'  : ''
    };
   var firstForm = $('#s1-'+fn);
   var secondForm = $('#s2-'+fn);
   var next = 0;
   var email = '';
   var pass = '';
   var name = '';
   var phone = '';
   var msg = '';
   var addr_info = '';
   var mls = '';
   var error = 0;

   $('input#email').inputfocus({ value: field_values['email'] }); 
   $('#first_step_'+fn).slideDown();
   $('#second_step_'+fn).slideUp();
   var firstFrom = $();
    $('#first_step_'+fn+' input').removeClass('uk-form-danger').removeClass('uk-form-success');
    firstForm.submit(function(){ return false; });

    $('#submit_first_'+fn).click(function(){
        $('#first_step_'+fn+' input').removeClass('uk-form-danger').removeClass('uk-form-success');
        error = 0;
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = $('#first_step_'+fn+' input[type=text]');
        var messageHolder = firstForm.find('span');
            messageHolder.removeClass('uk-form-danger').removeClass('uk-form-success');


        fields.each(function(){
            var value = $(this).val();
            if( value.length < 3 || ( $(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                messageHolder.addClass('uk-form-danger');
                messageHolder.text('Please enter a valid email');
                error++;
            } else {
                messageHolder.addClass('uk-form-success');
		email = value;
                error = 0;
            }
        });
        if(!error) {
             $.post(firstForm.attr('action'), {email: email}, function(m){
                        if(m.error){
                              messageHolder.addClass('uk-form-danger');
                              messageHolder.text('Please enter a valid email.');
                        }
                        else{
                              messageHolder.removeClass('uk-form-danger').addClass('loggedIn');
                              if(m.next){  
                                $('#first_step_'+fn).slideUp();
                                $('#second_step_'+fn).slideDown();
                              }else{
                               setCookie('em',m.cookie,5256000);
                               if(rd_url == window.location.pathname ){
                                 location.reload();
                               }else{
                                 location.assign(rd_url);
                               }

                              }
                              messageHolder.text(m.message);
                        }
                              next = m.next;
             });

        } else return false;

    });

    secondForm.submit(function(){ return false; });
    $('#submit_second_'+fn).click(function(){
       $('#second_step_'+fn+' input').removeClass('uk-form-danger').removeClass('uk-form-success');
       if(!error && next) {
         var phonePattern = /^((([0-9]{3}))|([0-9]{3}))[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4}$/;
         var fields = $('#second_step_'+fn+' input[type=text], input[type=email]');
         var messageHolder = secondForm.find('span');
             messageHolder.removeClass('uk-form-danger').removeClass('uk-form-success');
           fields.each(function(){
                var value = $(this).val();
                    if($(this).attr('id')=='name' ){
                         if( value.length < 2 ) {
                              messageHolder.addClass('uk-form-danger');
                              messageHolder.text('Please enter a name with 3 letters or more.');
                              error++;
                         } else {
                             messageHolder.removeClass('uk-form-danger');
                             name = value;
                         }
                    }
                   if($(this).attr('id').search(/phone_/) == 0 ){
                         if(  !phonePattern.test(value)    ) {
                              messageHolder.addClass('uk-form-danger');
                              messageHolder.text('Please enter a valid phone number.');
                              phone = value;
                              error++;
                         } else {
                             messageHolder.removeClass('uk-form-danger');
                             phone = value;
                         }
                   }

            });
            if(!error) {
               $.post(secondForm.attr('action'), {email: email,name: name,phone: phone}, function(m){
                        if(m.error){
                                messageHolder.addClass('uk-form-danger');
                                messageHolder.text(m.message);
                        }
                        else{
                              messageHolder.removeClass('uk-form-danger').addClass('loggedIn');
                              messageHolder.text(m.message);
                              if(m.next){
                               setCookie('em',m.cookie,5256000);

                               if(rd_url == window.location.pathname ){
                                 location.reload();
                               }else{
                                 location.assign(rd_url);
                               }


                              }

                              messageHolder.text(m.message);
                        }
                });

             } else{ 
                 error=0;
                 return false;
             }
          } else{
             error=0;
             return false;
          }

    });

 });

}
</script>
