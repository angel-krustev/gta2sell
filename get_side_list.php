    <script type='text/javascript' >
  $('document').ready(function() {

    var lat='<?php echo $lat;?>';
    var lon='<?php echo $lon;?>';
    var isc="y";
    var isr="";
    var list=[];
    var imgpath='/rs/';
    var is_loc_set=false;
function setItem(item,img){
         var htmlItem="<div class=\"uk-width-medium-1-1 uk-margin-top\">";
         var price=item.asking;
                                htmlItem += "<div  data-uk-modal=\"{target:'#modal-"+item.ml_num+"'}\" >";
                                htmlItem += "           <div class=\"uk-panel uk-panel-box\" >";
                                htmlItem += "                   <div class=\"uk-grid\">";
                                htmlItem += "                           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                                   <img width=\"150\" height=\"110\"  onerror=\"imgError(this);\"  src=\""+img+"\">";
                                htmlItem += "                           </div>";
                                htmlItem += "                           <div class=\"uk-width-medium-1-2\">";
                                htmlItem += "                                           <div class=\"uk-panel-badge uk-badge uk-badge-danger\">";
                                htmlItem +=                                                price;
                                htmlItem += "                                           </div>";
                                htmlItem += "                                           <ul class=\"uk-list\">";
                                htmlItem += "                                              <li><span  style=\"margin-right: 5px;\">"+item.addr+"</span></li>";
                                htmlItem += "                                              <li><span  style=\"margin-right: 5px;\">"+item.community+"</span></li>";
                                htmlItem += "                                              <li><span  style=\"margin-right: 5px; \">"+item.bed+" beds / "+item.bath+" baths"+"</span></li>";
                                htmlItem += "                                           </ul>";
                                htmlItem += "                           </div>";
                                htmlItem += "                   </div>";
                                htmlItem += "           </div>";
                                htmlItem += "</div>";
	htmlItem += "</div>";
        return htmlItem;
}

function showList(idx){
         var selectPriceAsc = '';
         var selectPriceDesc = '';
         var selectDomAsc = '';
         var selectDomDesc = '';
         var selectDistance = '';


                 if( idx == 0){
                      selectPriceAsc = 'selected';
                 }else if (idx == 1){
                      selectPriceDesc = 'selected';
                 }else if (idx == 2){
                      selectDomAsc = 'selected';
                 }else if (idx == 3){
                      selectDomDesc = 'selected';
                 }else if (idx == 4){
                      selectDistance = 'selected';
                 }else{
                      selectPriceAsc = 'selected';
                 };
                      
                       var isCookie ;
                         isCookie = '<?php echo $_COOKIE[$cookie_name]." ".$cookie_name ;?>';
                      var htmlModalList="";
                         
                      var htmlList="";
                if( list.length >0){
                          htmlList +="<div class=\"uk-width-medium-1-1\"> <ul class=\"ft-nav uk-nav uk-text-center\" data-uk-nav=\"\" style=\"margin-top: 15px;\" >";
                             htmlList +="<li  class=\"uk-nav-header uk-text-center\">";
                             htmlList +="      Simular Properties";
                             htmlList +="</li>";
                             htmlList +="</ul></div>";

                      for(index = 0; index < list.length; index++) {
                                  var price=list[index].asking;
                                  var img  = imgpath+"150x110/r/retsimages/"+list[index].ipath+"/image_"+list[index].ml_num+"_1.jpg";
                                  var Mimg  = imgpath+"600x400/r/retsimages/"+list[index].ipath+"/image_"+list[index].ml_num+"_1.jpg";



                                  htmlList += setItem(list[index],img);
                         if( list[index].count == 1){
				htmlModalList += "<div id=\"modal-"+list[index].ml_num+"\" class=\"uk-modal\">";
				htmlModalList += "		<div class=\"uk-modal-dialog uk-modal-dialog-lightbox\">";
				htmlModalList += "			<a href=\"\"  style=\"z-index:1;\" class=\"uk-modal-close uk-close uk-close-alt\"></a>";
				htmlModalList += "			<div class=\"uk-grid\" >";
				htmlModalList += "				<div class=\"uk-width-medium-1-1\">";
				htmlModalList += "					<figure class=\"uk-overlay\">";
				htmlModalList += "						<img width=\"600\" height=\"400\" src=\""+Mimg+"\" alt=\"\">";
				htmlModalList += "						<figcaption class=\"uk-overlay-panel uk-overlay-bottom uk-overlay-background\">";
				htmlModalList += "							<div class=\"uk-grid\">";
				htmlModalList += "								<div class=\"uk-width-1-2 uk-text-left uk-text-small\">";
				htmlModalList += "								</div>";
				htmlModalList += "								<div class=\"uk-width-1-2 uk-text-right\">";
				htmlModalList += 								list[index].dom+" days listed";
				htmlModalList += "								</div>";
				htmlModalList += "							</div>";
				htmlModalList += "						</figcaption>";
				htmlModalList += "					</figure>";
				htmlModalList += "				</div>";
				htmlModalList += "			</div>";
				htmlModalList += "			<div class=\"uk-grid\" style=\"margin-top: 2px; margin-bottom: 4px;\">";
				htmlModalList += "				<div class=\"uk-width-1-2 uk-text-left\" >";
				htmlModalList += "					<ul class=\"uk-list\">";
				htmlModalList += "						<li><span  style=\"margin-left: 5px;\">"+list[index].asking+"</span></li>";
				htmlModalList += "						<li><span  style=\"margin-left: 5px;\">"+list[index].bed+" beds / "+list[index].bath+" baths </span></li>";
				htmlModalList += "						<li></li>";
				htmlModalList += "					</ul>";
				htmlModalList += "				</div>";
				htmlModalList += "				<div class=\"uk-width-1-2 uk-text-right\" >";
				htmlModalList += "					<ul class=\"uk-list\">";
				htmlModalList += "						<li><span  style=\"margin-right: 5px;\">"+list[index].addr+"</span></li>";
				htmlModalList += "						<li><span   style=\"margin-right: 5px; \">"+list[index].community+"</span></li>";
				htmlModalList += "					</ul>";
				htmlModalList += "				</div>";
				htmlModalList += "				<div class=\"uk-width-1-1  uk-container-center uk-text-center\" style=\"margin-top: 2px; margin-bottom: 4px;\">";
				htmlModalList += "					<a class=\"uk-button uk-button-primary\" href=\""+list[index].page_url+"\">View Full Listing&nbsp;";
				htmlModalList += "                                  		<i class=\"uk-icon-justify uk-icon-hand-o-right\"></i>&nbsp;";
                                htmlModalList += "                                   </a>";
				htmlModalList += "				</div>";
				htmlModalList += "			</div>";
				htmlModalList += "		</div>";
				htmlModalList += "</div>";
                         }
                       }
                     }
                                jQuery("#list").html(htmlList);
                                jQuery("#modalList").html(htmlModalList);
                                jQuery(document).ready(function($) {
                                //          $.UIkit.modal('#modal-spinner').hide();
                                });


}

     function sortDomAsc(){
                  function cmp(a,b) {
                    return (a.dom - b.dom);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }

     function sortDomDesc(){
                  function cmp(a,b) {
                    return (b.dom - a.dom);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }

     function sortDistance(lat, lng) {
                  function dist(l) {
                    return (l.lat - lat) * (l.lat - lat) +
                      (l.lon-lng) * (l.lon-lng);
                 }

                  list.sort(function(l1, l2) {
                    return dist(l1) - dist(l2);
 
                  });
      }

     function sortPriceAsc() {
                  function cmp(a,b) {
                    return (a.lp_dol - b.lp_dol);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }
     function sortPriceDesc() {
                  function cmp(a,b) {
                    return (b.lp_dol - a.lp_dol);
                 }
                  list.sort(function(a1, a2) {
                    return cmp(a1,a2);
                  });
      }

	function sortList(selectObj)
	{	 
	  var idx = selectObj.selectedIndex;
                 if( idx == 0){
                      sortPriceAsc();
                 }else if (idx == 1){
                      sortPriceDesc();
                 }else if (idx == 2){
                      sortDomAsc();
                 }else if (idx == 3){
                      sortDomDesc();
                 }else if (idx == 4){
                      sortDistance(lat,lon);
                 }else{
                      sortPriceAsc();
                 }
                 showList(idx);
	}


    var ml_num='<?php echo $ml_num;?>'; 
    var lat='<?php echo $lat;?>'; 
    var lon='<?php echo $lon;?>';
    var prc = '<?php echo $lp_dol;?>'
    var sf = 25*(prc/100);
    var minp = prc-sf;
    var maxp = +prc + +sf;

// Sets the map on all markers in the array.
function initialize() {
  $.ajax({
         type : 'POST',
         url : '/get_cl_markers',
         dataType: 'xml',
         global: false, 
         data: {
             ml_num: ml_num,
             ulat: lat,
             ulon: lon,
             lm: '10',
             order: 'lc',
             c: 'n',
             ir: 'y',
             s: '',
             bed: '<?php echo $br; ?>',
             bath: '<?php echo $bath_tot; ?>',
             minp: minp,
             maxp: maxp,
             typeos: '<?php echo $type_own_srch; ?>',
             frm: 'sf',
             s_r: 'Sale',
             at: '<?php echo generateFormToken('sf')?>'
         },
          success : function(data) {
                            plat=plon=latlon=isr='';
                            isc='y';
		        var markers = data.documentElement.getElementsByTagName("marker");
                            list=[];
                            showBack="";
		      for (var i = 0; i < markers.length; i++) {
		        var asking = markers[i].getAttribute("asking");
		        var ml_num = markers[i].getAttribute("ml_num");
		        var ipath = markers[i].getAttribute("ipath");
		        var addr = markers[i].getAttribute("addr");
		        var bed = markers[i].getAttribute("bed");
		        var bath = markers[i].getAttribute("bath");
		        var building = markers[i].getAttribute("building");
		        var type_own_srch = markers[i].getAttribute("type_own_srch");
		        var type_own1_out = markers[i].getAttribute("type_own1_out");
		        var iconName   = markers[i].getAttribute("icon");
		        var xlon = markers[i].getAttribute("lon");
		        var xlat = markers[i].getAttribute("lat");
		        var min = markers[i].getAttribute("min");
		        var max = markers[i].getAttribute("max");
		        var community = markers[i].getAttribute("community");
		        var municipality = markers[i].getAttribute("municipality");
		        var page_url = markers[i].getAttribute("page_url");
		        var dom = markers[i].getAttribute("dom");
		        var rltr = markers[i].getAttribute("rltr");
		        var count = markers[i].getAttribute("count");
		        var multiple = markers[i].getAttribute("multiple");
		        var cluster = markers[i].getAttribute("cluster");
		        var s_r = markers[i].getAttribute("s_r");
		        var lp_dol  = markers[i].getAttribute("lp_dol");
		        var point = new google.maps.LatLng(
			     markers[i].getAttribute("lat"),
			     markers[i].getAttribute("lon")
                            );
                        var aList = {ml_num:ml_num,ipath:ipath,asking:asking,addr:addr,bed:bed,bath:bath,lat:xlat,lon:xlon,min:min,max:max,rltr:rltr,count:count,dom:dom,municipality:municipality,community:community,type_own1_out:type_own1_out,index:i,building:building,multiple:multiple,lp_dol:lp_dol,page_url:page_url,cluster:cluster};
                        list.push(aList);
                        var img  = imgpath+ipath+"/image_"+ml_num+"_1.jpg&w=100&h=60";
                      };//for
                      markers=[];
                      var lPPage=8;
                      var pn=1;
                      var al=true;
                      var imgpath='<?php echo $imgtmb.$image_base."/";?>';
                 //     sortPriceAsc();
                      showList(0);
            },//success
            error: function(e){
           }


         });
    };//initiloze
initialize() ;
});
</script>
