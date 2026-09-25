<script type='text/javascript'>

//var MAX=3000000;
var slider;
/*   PRICE  SLIDER START */

function nFormatter(num,MAX) {
     if (num >= MAX) {
        return 'Max';
     }
     if (num >= 1000000) {
        return '$'+(num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
     }
     if (num >= 1000) {
        return '$'+(num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
     }
     return num;
}

//var pMax=3000000;
//var pMin=100000;

 function sliderInit(pMin,pMax,vminp,vmaxp){
    var minp;
    var maxp;
    var step=100000;
     MAX=pMax;
     minp=getInputValue('fc',vminp,pMin)+"";
     maxp=getInputValue('fc',vmaxp,pMax)+"";
     minp = minp.replace(/,/g , "");
     maxp = maxp.replace(/,/g , "");
     minp = minp.replace(/\$/g,"");
     maxp = maxp.replace(/\$/g,"");
     var iValues = [
        document.getElementById(vminp),
        document.getElementById(vmaxp)
     ];
     var pValues = [
        document.getElementById('dminp'),
        document.getElementById('dmaxp')
     ];
     if( pMin < 10000){
        step = 500;
     }
     if(minp < pMin ){
        minp = pMin;  
     }
     if(maxp > pMax ){
        maxp = pMax;  
     }
     if(minp > pMax ){
        minp = pMin;
     }
     if(maxp < pMin ){
        maxp = pMax;
     }
     //if(maxp < minp ){
     //   maxp = pMax;
     //   minp = pMin;
     //}
     //alert(pMin+":"+pMax+"<br>"+minp+":"+maxp);
     slider = document.getElementById('slider');
     noUiSlider.create(slider, {
        start: [minp,maxp],
        step: step,
        connect: true,
        range: {
                'min': pMin,
                'max': pMax
        }
     });
     slider.noUiSlider.on('update', function( values, handle ) {
        pValues[handle].innerHTML = nFormatter(values[handle],pMax);
        iValues[handle].value = values[handle];
     });
     slider.noUiSlider.on('change', function( ) {
        initialize();
     });
 }

 //$(document).ready(function() {
 //   if(jQuery("#s_r").val() == 'Lease' ){
 //        sliderInit(50,5000,'lminp','lmaxp');
 //   }else{
 //        sliderInit(100000,3000000,'sminp','smaxp');
 //   }
 //});
//function updateSliderRange ( min, max ) {
//	updateSlider.noUiSlider.updateOptions({
//		range: {
//			'min': min,
//			'max': max
//		}
//	});
//}
//slider.setAttribute('disabled', true);
//  function disableSlider(isdisabled){ 
//          if( isdisabled ){
//             slider.setAttribute('disabled', true);
//           }else{
//             slider.removeAttribute('disabled');
//          }
//  }
/*   PRICE  SLIDER END */
</script>
