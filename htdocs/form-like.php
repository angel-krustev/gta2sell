<form name="ilike" id="ilike" action="" method="post" >
<input id="likelist" name="likelist" type="hidden"/>
<input id="isearch" name="isearch" type="hidden"/>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/notify.js"> </script>


<script type='text/javascript'>
       var limit=24;
       function arrayContains(needle, arrhaystack)
       {
              return (arrhaystack.indexOf(needle) > -1);
       }
       function ilikeit(likeid,like){
         if(!doilikeit(likeid,like)){
                 likeArray=$('#'+like).val().split(":");
              if(likeArray.length > limit){
                 idontlikeit(likeArray[0],like);  
              }
              likelist=$('#'+like).val()+":"+likeid;
              $('#'+like).val(likelist)
              onSubmit('ilike',5256000);
              $("#"+likeid).removeClass('uk-icon-heart-o uk-icon-medium');
              $("#"+likeid).addClass('uk-icon-heart uk-icon-medium');
         }  
       }
       function idontlikeitH(likeid,like){
          if(likeid !== '' && likeid !== null && doilikeit(likeid,like)){
              var a=$('#'+like).val().split(":");
              var i = a.indexOf(likeid);
              if(i != -1) {
                        a.splice(i, 1);
              }
              $('#'+like).val(a.join(':') );
              onSubmit('ilike',5256000);
          }
       }

       function idontlikeit(likeid,like){
          if(likeid !== '' && likeid !== null && doilikeit(likeid,like)){
              var a=$('#'+like).val().split(":");
              var i = a.indexOf(likeid);
	      if(i != -1) {
			a.splice(i, 1);
		}
              $('#'+like).val(a.join(':') );
              onSubmit('ilike',5256000);
              $("#"+likeid).removeClass('uk-icon-heart uk-icon-medium');
              $("#"+likeid).addClass('uk-icon-heart-o uk-icon-medium');
              var notice="<div class=\"uk-alert uk-alert-danger\">"+likeid.split("-")[1]+" has been removed from your list. If it was removed by a mistake - you can <a href=\"#\" onclick=\"switchlike('"+likeid+"','"+like+"');location.reload(); \"> Click here </a> to Add it again.</div>";
              jQuery("#likenote").html(notice); 
          }
       }
       function switchlike(likeid,like){
          if(doilikeit(likeid,like)){
            idontlikeit(likeid,like);
          }else{
            ilikeit(likeid,like);
          }
       } 
       function doilikeit(needle,like){
           return arrayContains(needle, $('#'+like).val().split(":"))
       }

      function likeinit(like){
          var likeArray = $('#'+like).val().split(":");
          for (var i = 0; i < likeArray.length; i++) {
            if(likeArray[i] !== null && likeArray[i] !== '' &&  document.getElementById(likeArray[i]) !== null){
              $("#"+likeArray[i]).removeClass('uk-icon-heart-o uk-icon-medium');
              $("#"+likeArray[i]).addClass('uk-icon-heart uk-icon-medium');
           }
          }
      }
      $('document').ready(function() {
         onLoad('ilike');
         likeinit('likelist');
      });
</script>
