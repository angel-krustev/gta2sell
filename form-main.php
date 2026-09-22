<script type"text/javascript">
   function sr_changed(){
                    if(jQuery("#s_r").val() == 'Lease' ){
                         slider.noUiSlider.destroy();
                         sliderInit(50,5000,'lminp','lmaxp');
                    }else{
                         slider.noUiSlider.destroy();
                         sliderInit(100000,3000000,'sminp','smaxp');
                    }
                    $("#s").val(0);
                    initialize();
      };

var htmlForm="";
function generateForm(){
  htmlForm=""; 
                     <!-- screen  panel --!>
htmlForm += "                   <div class=\"uk-grid\"  style=\"margin-bottom: 10px; z-index: 4 ;\" <?php echo $formsticky ?> >";
htmlForm += "                      <div class=\"uk-width-1-1\"> ";
htmlForm += "                        <div class=\"uk-panel uk-panel-box uk-panel-box-secondary\">";
                           <!--  form --!>
htmlForm += "                           <form class=\"uk-form uk-margin-remove uk-form-medium\" name='fc' id='fc'  action=\"<?php echo $form_action ?>\" method=\"post\" >";

                                if( getScreenSize() != "small" ){

                                           <!-- LARGE FORM START --!>
                                           <!-- Divider grid --!>
htmlForm += "                                           <div class=\"uk-grid\">";
                                              <!-- Search Area --!>
htmlForm += "                                              <div class=\"uk-width-1-2\">";
                                                 <!-- search grid --!>
htmlForm += "                                                 <div class=\"uk-grid\">";
htmlForm += "                                                    <div class=\"uk-width-4-6\">";
htmlForm += "                                                       <input id=\"addr\" name=\"addr\" placeholder=\"Address or Neighburhood\" type=\"text\" size=\"30\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                       <input name=\"ulat\" id=\"ulat\" type=\"hidden\">";
htmlForm += "                                                       <input name=\"ulon\" id=\"ulon\" type=\"hidden\">";
htmlForm += "                                                       <input id=\"zoom\" name=\"zoom\" type=\"hidden\" >";
htmlForm += "                                                       <input id=\"at\" name=\"at\" type=\"hidden\" value=\"<?php echo generateFormToken('fc')?>\" >";
htmlForm += "                                                    </div>";
htmlForm += "                                                    <div class=\"uk-width-2-6\">";
htmlForm += "                                                       <button class=\"uk-button uk-button-primary uk-button-medium uk-width-1-1\" onclick=\"onSubmit('fc',5256000);\">";
htmlForm += "                                                          <i class=\"uk-icon-small uk-icon-search\"></i>";
htmlForm += "                                                       </button>";
htmlForm += "                                                    </div>";
htmlForm += "                                                    <div class=\"uk-width-2-6 uk-text-left\" style=\"margin-top: 6px;\">";
htmlForm += "                                                                     <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                               <span id=\"span-nr\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                <select id=\"nr\" name=\"nr\" onChange=\"initialize();\" type=\"text\"  class=\"uk-form-small uk-width-1-1\">";
htmlForm += "                                                                                     <option value='1' >RADIUS - 1KM</option>";
htmlForm += "                                                                                     <option value='3' selected >RADIUS - 3KM</option>";
htmlForm += "                                                                                     <option value='5' >RADIUS - 5KM</option>";
htmlForm += "                                                                                     <option value='10'>RADIUS - 10KM</option>";
htmlForm += "                                                                                 </select>";
htmlForm += "                                                                    </div>";
htmlForm += "                                                    </div>";
htmlForm += "                                                    <div class=\"uk-width-2-6 uk-text-left\" style=\"margin-top: 6px;\">";
                                           if( typeof maplink ==='undefined'  ){


htmlForm += "                                                                     <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                               <span id=\"span-order\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                          						        <select id=\"order\"  name=\"order\" onChange=\"initialize();\" type=\"text\"  class=\"uk-form-small uk-text-bold\">";
htmlForm += "                          							     <option value='pl' >PRICE - LOWEST FIRST</option>";
htmlForm += "                                                                                     <option value='ph' >PRICE - HIGHEST FIRST</option>";
htmlForm += "                                                                                     <option value='dl' >NEWEST FIRST</option>";
htmlForm += "                                                                                     <option value='dh' >OLDEST FIRST</option>";
htmlForm += "                          							     <option value='lc' >CLOSEST FIRST</option>";
htmlForm += "                                                                                 </select>";
htmlForm += "                                                                    </div>";
                                         } else {
htmlForm += "                                                                     <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";

htmlForm += "										<span id=\"span-sorter\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "											<select id=\"sorter\"  onChange=\"sortList(this);\" type=\"text\"  class=\"uk-form-small uk-text-bold\">";
htmlForm += "												<option selected >PRICE - LOWEST FIRST</option>";
htmlForm += "												<option>PRICE - HIGHEST FIRST</option>";
htmlForm += "												<option>NEWEST FIRST</option>";
htmlForm += "												<option>OLDEST FIRST</option> ";
htmlForm += "												<option>CLOSEST FIRST</option> ";
htmlForm += "											</select>";
htmlForm += "									</div>";

                              } 

htmlForm += "						     </div>";
htmlForm += "                                                     <div class=\"uk-width-2-6\" style=\"margin-top: 8px\">";
htmlForm += "                                                        <div class=\"uk-form-row\">";
htmlForm += "                                                           <div class=\"uk-form-controls uk-text-small uk-text-bold uk-text-primary uk-text-left\">";
htmlForm += "                                                             <label><a id=\"saveme\" name=\"saveme\" class=\"uk-button uk-button-mini uk-button-danger\" onclick=\"saveSearch()\">Save Search</a></label>";
htmlForm += "                                                           </div>";
htmlForm += "                                                        </div>";
htmlForm += "                                                     </div>";
htmlForm += "                                                 </div>";
                                                 <!-- search grid --!>
htmlForm += "                                              </div>";
                                              <!-- Search Area --!>

                                              <!-- Select Area --!>
htmlForm += "                                              <div class=\"uk-width-1-2\">";
htmlForm += "                                                 <div class=\"uk-grid uk-grid-divider\"> ";
htmlForm += "                                                    <div class=\"uk-width-3-10\" style=\"margin-left: 0px;margin-bottom: 5px\">";
                                                      <!-- FIRST COLUMN -->
htmlForm += "                                                      <div class=\"uk-grid\"> ";
htmlForm += "                                                    	<div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";

htmlForm += "                                                       		<div class=\"uk-form-select uk-text-nowrap uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                     		<span  id=\"span-rtype\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                     			<select  onchange=\"initialize();\" type=\"text\" name=\"rtype\" id=\"rtype\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                         		<option value=\"\" >ALL HOMES</option>";
htmlForm += "                                                         		<option value=\"house\">HOUSE</option>";
htmlForm += "                                                         		<option value=\"condo\">CONDO</option>";
htmlForm += "                                                         		<option value=\"townhouse\">TOWN HOUSE</option>";
htmlForm += "                                                         		<option value=\"land\">LAND</option>";
htmlForm += "                                                         		<option value=\"cottage\">COTTAGE</option>";
htmlForm += "                                                     			</select>";
htmlForm += "                                                    		</div>";
htmlForm += "                                                  	</div>";
htmlForm += "                                                  	<div class=\"uk-width-1-1\" style=\"margin-top: 6px\">";
htmlForm += "                                                                     <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                               <span id=\"span-s_r\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                <select onchange=\"sr_changed();\"  id=\"s_r\" name=\"s_r\" type=\"text\"  class=\"uk-form-small\">";
htmlForm += "                                                                                     <option value='Sale' >FOR SALE</option>";
htmlForm += "                                                                                     <option value='Lease' >FOR LEASE</option>";
htmlForm += "                                                                                 </select>";
htmlForm += "                                                                    </div>";

htmlForm += "                                                        </div>";
htmlForm += "                                                      </div>";
                                                      <!-- FIRST COLUMN -->
htmlForm += "                                                    </div>";
htmlForm += "                                                    <div class=\"uk-width-3-10\"  style=\"margin-left: 0px\">";
                                                      <!-- SECOND COLUMN -->
htmlForm += "                                                      <div class=\"uk-grid\"> ";
htmlForm += "                                                    	<div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";
htmlForm += "                                                      		<div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                          		<span id=\"span-bed\"></span>&nbsp;BEDS&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                   	      	  		<select onchange=\"initialize();\"   type=\"text\" name=\"bed\" id=\"bed\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                       		 		<option value=\"\"></option>";
htmlForm += "                                                        	 		<option value=\"1\">1+</option>";
htmlForm += "                                                        	 		<option value=\"2\">2+</option>";
htmlForm += "                                                         	 		<option value=\"3\">3+</option>";
htmlForm += "                                                        	 		<option value=\"4\">4+</option>";
htmlForm += "                                                        			<option value=\"5\">5+</option>";
htmlForm += "                                                        	  		</select>";
htmlForm += "                                                       		</div>";
htmlForm += "                                                    	</div>";
htmlForm += "                                                    	<div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";
htmlForm += "                                                       		<div class=\"uk-form-select uk-text-nowrap uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                    			<span id=\"span-bath\"></span>&nbsp;BATHS&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                     		  		<select onchange=\"initialize();\"   type=\"text\" id=\"bath\"  name=\"bath\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                       		 		<option value=\"\"></option>";
htmlForm += "                                                         			<option value=\"1\">1+</option>";
htmlForm += "                                                         			<option value=\"2\">2+</option>";
htmlForm += "                                                         			<option value=\"3\">3+</option>";
htmlForm += "                                                         			<option value=\"4\">4+</option>";
htmlForm += "                                                     		  		</select>";
htmlForm += "                                                      		</div>";
htmlForm += "                                                    	</div>";
htmlForm += "  						      </div>";
                                                      <!-- SECOND COLUMN -->
htmlForm += "                                                    </div>";
htmlForm += "                                                    <div class=\"uk-width-4-10\" style=\"margin-top: 6px\">";
                                                      <!-- THIRD COLUMN -->
htmlForm += "                                                         <div class=\"uk-grid\" >";
htmlForm += "                                                            <div class=\"uk-width-1-1\" style=\"margin-bottom: 5px\" >";
htmlForm += "                                                                     <div  id=\"slider\"  class=\"uk-text-small uk-text-bold\"  style=\"width: 80%\"></div>";
htmlForm += "                                                            </div>";
htmlForm += "                                                            <div class=\"uk-width-1-2 uk-text-left uk-text-small uk-text-bold\"    >";
htmlForm += "                                                               <input id=\"lminp\" name=\"lminp\" type=\"hidden\"  data-index=\"0\" value=\"50\" disabled  />";
htmlForm += "                                                               <input id=\"sminp\" name=\"sminp\" type=\"hidden\"  data-index=\"0\" value=\"100000\" disabled  />";
htmlForm += "                                                                <div id=\"dminp\" class=\"uk-text-small uk-text-bold\" ></div>";
htmlForm += "                                                            </div>";
htmlForm += "                                                            <div class=\"uk-width-1-2 uk-text-right uk-text-small uk-text-bold\"  >";
htmlForm += "                                                              <input id=\"lmaxp\" name=\"lmaxp\" type=\"hidden\"  data-index=\"1\" value=\"5000\" disabled />";
htmlForm += "                                                              <input id=\"smaxp\" name=\"smaxp\" type=\"hidden\"  data-index=\"1\" value=\"3000000\" disabled />";
htmlForm += "                                                              <div id=\"dmaxp\" class=\"uk-text-small uk-text-bold\" style=\"width: 50%\"></div>";
htmlForm += "                                                            </div>";
htmlForm += "                                                         </div>";
                                                      <!-- THIRD COLUMN -->
htmlForm += "                                                   </div>";
htmlForm += "                                              </div>";
                                              <!-- Select Area --!>
htmlForm += "                                        </div>";
                                           <!-- Divider grid --!>
                                           <!-- LARGE FORM END --!>
htmlForm += "                               ";
                             }else{
                                     <!-- small screen  grid --!>
htmlForm += "                              	     <div class=\"uk-grid\">";
                                           <!-- Search area  --!>
htmlForm += "                                            <div class=\"uk-width-4-6\">";
htmlForm += "                                                       <input id=\"addr\" name=\"addr\" placeholder=\"Address or Neighburhood\" type=\"text\" size=\"30\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                       <input name=\"ulat\" id=\"ulat\" type=\"hidden\">";
htmlForm += "                                                       <input name=\"ulon\" id=\"ulon\" type=\"hidden\">";
htmlForm += "                                                       <input id=\"zoom\" name=\"zoom\" type=\"hidden\"  />";
htmlForm += "                                                       <input id=\"isc\" name=\"isc\" type=\"hidden\" value=\"n\"  />";
htmlForm += "                                            </div>";
htmlForm += "                                 	    <div class=\"uk-width-2-6\">";
htmlForm += "                                 		  <button class=\"uk-button uk-button-primary uk-button-medium uk-width-1-1\" onclick=\"onSubmit('fc',5256000);\">";
htmlForm += "                                                              <i class=\"uk-icon-small uk-icon-search\"></i>";
htmlForm += "                                                  </button>";
htmlForm += "                                  	    </div>";
<!--START--!>
htmlForm += "                                                    <div class=\"uk-width-1-3\" style=\"margin-left: 0px;margin-bottom: 5px\">";
                                                      <!-- FIRST COLUMN -->
htmlForm += "                                                      <div class=\"uk-grid\">";
htmlForm += "                                                        <div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";

htmlForm += "                                                                <div class=\"uk-form-select uk-text-nowrap uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                <span  id=\"span-rtype\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                        <select  onchange=\"initialize();\" type=\"text\" name=\"rtype\" id=\"rtype\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                                        <option value=\"\" >ALL HOMES</option>";
htmlForm += "                                                                        <option value=\"house\">HOUSE</option>";
htmlForm += "                                                                        <option value=\"condo\">CONDO</option>";
htmlForm += "                                                                        <option value=\"townhouse\">TOWN HOUSE</option>";
htmlForm += "                                                                        <option value=\"land\">LAND</option>";
htmlForm += "                                                                        <option value=\"cottage\">COTTAGE</option>";
htmlForm += "                                                                        </select>";
htmlForm += "                                                                </div>";
htmlForm += "                                                        </div>";
htmlForm += "                                                        <div class=\"uk-width-1-1\" style=\"margin-top: 6px\">";
htmlForm += "                                                                     <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                               <span id=\"span-s_r\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                <select onchange=\"sr_changed();\" id=\"s_r\" name=\"s_r\" type=\"text\"  class=\"uk-form-small\">";
htmlForm += "                                                                                     <option value='Sale' >FOR SALE</option>";
htmlForm += "                                                                                     <option value='Lease' >FOR LEASE</option>";
htmlForm += "                                                                                 </select>";
htmlForm += "                                                                    </div>";

htmlForm += "                                                        </div>";
htmlForm += "                                                      </div>";
                                                      <!-- FIRST COLUMN -->
htmlForm += "                                                    </div>";
htmlForm += "                                                    <div class=\"uk-width-1-3\"  style=\"margin-left: 0px\">";
                                                      <!-- SECOND COLUMN -->
htmlForm += "                                                      <div class=\"uk-grid\">";
htmlForm += "                                                        <div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";
htmlForm += "                                                                <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                        <span id=\"span-bed\"></span>&nbsp;BEDS&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                <select onchange=\"initialize();\"   type=\"text\" name=\"bed\" id=\"bed\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                                                <option value=\"\"></option>";
htmlForm += "                                                                                <option value=\"1\">1+</option>";
htmlForm += "                                                                                <option value=\"2\">2+</option>";
htmlForm += "                                                                                <option value=\"3\">3+</option>";
htmlForm += "                                                                                <option value=\"4\">4+</option>";
htmlForm += "                                                                                <option value=\"5\">5+</option>";
htmlForm += "                                                                                </select>";
htmlForm += "                                                                </div>";
htmlForm += "                                                        </div>";
htmlForm += "                                                        <div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";
htmlForm += "                                                                <div class=\"uk-form-select uk-text-nowrap uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                        <span id=\"span-bath\"></span>&nbsp;BATHS&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                <select onchange=\"initialize();\"   type=\"text\" id=\"bath\"  name=\"bath\" class=\"uk-form-medium uk-width-1-1\">";
htmlForm += "                                                                                <option value=\"\"></option>";
htmlForm += "                                                                                <option value=\"1\">1+</option>";
htmlForm += "                                                                                <option value=\"2\">2+</option>";
htmlForm += "                                                                                <option value=\"3\">3+</option>";
htmlForm += "                                                                                <option value=\"4\">4+</option>";
htmlForm += "                                                                                </select>";
htmlForm += "                                                                </div>";
htmlForm += "                                                        </div>";
htmlForm += "                                                      </div>";
                                                      <!-- SECOND COLUMN -->
htmlForm += "                                                    </div>";


htmlForm += "                                                    <div class=\"uk-width-1-3\"  style=\"margin-left: 0px\">";
                                                      <!-- THIRD COLUMN -->
htmlForm += "                                                      <div class=\"uk-grid\">";
htmlForm += "                                                        <div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";
htmlForm += "                                                                                      <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                               <span id=\"span-nr\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                <select id=\"nr\" name=\"nr\" onChange=\"initialize();\" type=\"text\"  class=\"uk-form-small uk-width-1-1\">";
htmlForm += "                                                                                     <option value='1' >RADIUS - 1KM</option>";
htmlForm += "                                                                                     <option value='3' selected >RADIUS - 3KM</option>";
htmlForm += "                                                                                     <option value='5' >RADIUS - 5KM</option>";
htmlForm += "                                                                                     <option value='10'>RADIUS - 10KM</option>";
htmlForm += "                                                                                 </select>";

htmlForm += "                                                                                       </div>";
htmlForm += "                                                        </div>";
htmlForm += "                                                        <div class=\"uk-width-1-1\" style=\"margin-left: 0px;margin-bottom: 5px\">";
                                           if( typeof maplink ==='undefined'  ){


htmlForm += "                                                                     <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";
htmlForm += "                                                                               <span id=\"span-order\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                <select id=\"order\"  name=\"order\" onChange=\"initialize();\" type=\"text\"  class=\"uk-form-small uk-text-bold\">";
htmlForm += "                                                                                     <option value='pl' >PRICE - LOWEST FIRST</option>";
htmlForm += "                                                                                     <option value='ph' >PRICE - HIGHEST FIRST</option>";
htmlForm += "                                                                                     <option value='dl' >NEWEST FIRST</option>";
htmlForm += "                                                                                     <option value='dh' >OLDEST FIRST</option>";
htmlForm += "                                                                                     <option value='lc' >CLOSEST FIRST</option>";
htmlForm += "                                                                                 </select>";
htmlForm += "                                                                    </div>";
                                         } else {
htmlForm += "                                                                     <div class=\"uk-form-select uk-text-nowrap uk-text-center uk-text-small uk-text-bold\" data-uk-form-select=\"{target:'span'}\">";

htmlForm += "                                                                                <span id=\"span-sorter\"></span>&nbsp;<i class=\"uk-icon-caret-down\"></i>";
htmlForm += "                                                                                        <select id=\"sorter\"  onChange=\"sortList(this);\" type=\"text\"  class=\"uk-form-small uk-text-bold\">";
htmlForm += "                                                                                                <option selected >PRICE - LOWEST FIRST</option>";
htmlForm += "                                                                                                <option>PRICE - HIGHEST FIRST</option>";
htmlForm += "                                                                                                <option>NEWEST FIRST</option>";
htmlForm += "                                                                                                <option>OLDEST FIRST</option>";
htmlForm += "                                                                                                <option>CLOSEST FIRST</option>";
htmlForm += "                                                                                        </select>";
htmlForm += "                                                                        </div>";
                              }


htmlForm += "                                                        </div>";
htmlForm += "                                                      </div>";
                                                      <!-- THIRD  COLUMN -->
htmlForm += "                                                    </div>";

htmlForm += "                                            <div class=\"uk-width-3-3\" style=\"margin-top: 10px\">";
htmlForm += "                                                  <div class=\"uk-grid\" >";
htmlForm += "                                                      <div class=\"uk-width-1-1\" style=\"margin-bottom: 5px\" >";
htmlForm += "                                                                <div id=\"slider\"  class=\"uk-text-small uk-text-bold\"></div>";
htmlForm += "                                                      </div>";
htmlForm += "                                                       <div class=\"uk-width-1-2 uk-text-left uk-text-small uk-text-bold\"    >";
htmlForm += "                                                          <input id=\"lminp\" name=\"lminp\" type=\"hidden\"  data-index=\"0\" value=\"50\" disabled  />";
htmlForm += "                                                          <input id=\"sminp\" name=\"sminp\" type=\"hidden\"  data-index=\"0\" value=\"100000\" disabled  />";
htmlForm += "                                                           <span id=\"dminp\" class=\"uk-text-small uk-text-bold\"></span>";
htmlForm += "                                                       </div>";
htmlForm += "                                                       <div class=\"uk-width-1-2 uk-text-right uk-text-small uk-text-bold\"  >";
htmlForm += "                                                         <input id=\"lmaxp\" name=\"lmaxp\" type=\"hidden\"  data-index=\"1\" value=\"5000\" disabled />";
htmlForm += "                                                         <input id=\"smaxp\" name=\"smaxp\" type=\"hidden\"  data-index=\"1\" value=\"3000000\" disabled />";
htmlForm += "                                                         <span id=\"dmaxp\" class=\"uk-text-small uk-text-bold\"></span>";
htmlForm += "                                                       </div>";
htmlForm += "                                                  </div>";
htmlForm += "                                             </div>";
htmlForm += "  ";
htmlForm += "                                     </div>";
                                     <!-- eof small screen  grid --!>
                                 };
htmlForm += "                        </form>";
htmlForm += "                     </div>";
                     <!-- panel --!>
htmlForm += "           </div>";
         <!-- width-1-1 --!>
htmlForm += "    </div>";
    <!-- grid --!>
                jQuery("#fc-form").html(htmlForm);
                $("document").ready(function() {
                    onLoad('fc');
                    if(jQuery("#s_r").val() == 'Lease' ){
                         sliderInit(50,5000,'lminp','lmaxp');
                    }else{
                         sliderInit(100000,3000000,'sminp','smaxp');
                    }
                });



 }; 

      generateForm();

</script>
