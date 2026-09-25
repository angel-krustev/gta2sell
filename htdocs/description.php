 		      <div class="uk-width-1-1" >
 		            <div class="uk-panel uk-panel-box  uk-panel-header" >
 		            <h3 class="uk-panel-title"  ><b>Description</b></h3>
 		               <?php echo $ad_text."<br>"; 
 		                  if( $extras != ''){
 		                   echo  "<b>Extras</b><br>".$extras; 
 		                  }
                               ?> 
 		            </div>
 		      </div>
 		      <div class="uk-hidden-small uk-width-1-1" > &nbsp; </div>
 		      <div class="uk-width-1-1" >
 		            <div class="uk-panel uk-panel-box "  >
 		            <h3 class="uk-panel-title"  ><b>Details</b></h3>
 		                     <div class="uk-grid uk-grid-divider">
 		                         <div class="uk-width-small-1-1 uk-width-medium-1-3">
 		                                    <ul class="uk-list uk-list-space">
 		                                       <li><span class="uk-text-bold">Taxes:</span> <?php echo money_format('%.0n',$taxes)." / ".$yr;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Type:</span> <?php echo $type_own1_out." ".$style;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Exterior:</span> <?php echo $constr1_out;?>&nbsp;<?php echo $constr2_out;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Fronting:</span> <?php echo $comp_pts ;?><span class="uk-text-large"></span></li>
 		                                      <?php if($prop_feat1_out != '' ){ ?>
 		                                       <li><span class="uk-text-bold">Features:</span> 
 		                                            <?php 
 		                                               $feat= $prop_feat1_out!=''?'<br/>'.$prop_feat1_out:'';
 		                                               $feat= $feat.($prop_feat2_out != ''?", ".$prop_feat2_out:'');
 		                                               $feat= $feat.($prop_feat3_out != ''?", ".$prop_feat3_out:'');
 		                                               $feat= $feat.($prop_feat4_out != ''?", ".$prop_feat4_out:'');
 		                                               $feat= $feat.($prop_feat5_out != ''?", ".$prop_feat5_out:'');
 		                                               $feat= $feat.($prop_feat6_out != ''?", ".$prop_feat6_out:'');
 		                                               echo $feat;
 		                                             ?>
 		                                           <span class="uk-text-large"></span></li>
 		                                      <?php } ?>
 		                                      <?php if(  $type_tr == 'CND'   ){ ?>
 		                                        <li><span class="uk-text-bold">Balcony:</span> 
 		                                         <?php echo $patio_ter != ''?$patio_ter:'N/A'; ?>
 		                                        <span class="uk-text-large"></span></li>
 		                                        <li><span class="uk-text-bold">Amenities:</span> 
 		                                            <?php 
 		                                               $amen= $bldg_amen1_out!=''?'<br/>'.$bldg_amen1_out:'';
 		                                               $amen= $amen.($bldg_amen2_out != ''?", ".$bldg_amen2_out:'');
 		                                               $amen= $amen.($bldg_amen3_out != ''?", ".$bldg_amen3_out:'');
 		                                               $amen= $amen.($bldg_amen4_out != ''?", ".$bldg_amen4_out:'');
 		                                               $amen= $amen.($bldg_amen5_out != ''?", ".$bldg_amen5_out:'');
 		                                               $amen= $amen.($bldg_amen6_out != ''?", ".$bldg_amen6_out:'');
 		                                               echo $amen != ''?$amen:'N/A';
 		                                             ?>
 		                                        <span class="uk-text-large"></span></li>
 		                                      <?php } ?>
 		                                      <?php if(  $type_tr == 'CND' && $pets != ''   ){ ?>
 		                                        <li><span class="uk-text-bold">Pets Permitted:</span> 
 		                                           <?php echo $pets ;?>
 		                                        <span class="uk-text-large"></span></li>
 		                                      <?php } ?>

 		                                    </ul> 
 		                         </div>
 		                         <div class="uk-width-small-1-1 uk-width-medium-1-3">
 		                                    <ul class="uk-list uk-list-space">
 		                                      <?php if(  $type_tr == 'CND'   ){ ?>
 		                                       <li><span class="uk-text-bold">Maintenance:</span> <?php echo $maint > 0?money_format('%.0n',$maint):'N/A' ;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Insurance Included:</span> <?php echo $insur_bldg;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Condo Corp#:</span> <?php echo $corp_num;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Condo Registry Office:</span> <?php echo $condo_corp;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Condo Taxes Included:</span> <?php echo $cond_txinc;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Ensuite Laundry:</span> <?php echo $ens_lndry;?><span class="uk-text-large"></span></li>
 		                                     <?php }; ?>
 		                                       <li><span class="uk-text-bold">A/C:</span> <?php echo $a_c;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Heat Type:</span> <?php echo $heating;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Heatng Fuel:</span> <?php echo $fuel;?><span class="uk-text-large"></span></li>
 		                                     <?php if($sewer != ''){ ?>
 		                                       <li><span class="uk-text-bold">Sewers:</span> <?php echo $sewer;?><span class="uk-text-large"></span></li>
 		                                     <?php } ?>
 		                                     <?php if($water != ''){ ?>

 		                                       <li><span class="uk-text-bold">Water:</span> <?php echo $water;?><span class="uk-text-large"></span></li>
 		                                     <?php } ?>
 		                                    </ul> 
 		                         </div>
 		                         <div class="uk-width-small-1-1 uk-width-medium-1-3">
 		                                    <ul class="uk-list uk-list-space">
 		                                      
 		                                      <?php if($gar_type != '' || $gar_spaces != 0    ){ ?>
 		                                       <li><span class="uk-text-bold">Garage:</span> <?php echo $gar_type ;if ($gar_spaces != 0 || $gar_spaces !=  ''){  printf(" / %.0f",$gar_spaces." car(s)" );}?><span class="uk-text-large"></span> </li>
 		                                      <?php } ?>
 		                                      <?php if($type_tr == 'CND'){ ?>
 		                                       <li><span class="uk-text-bold">Parking:</span> <?php echo trim($park_fac." ".$park_spcs);?> space(s)<span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Exposure:</span> <?php echo $condo_exp;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Level:</span> <?php echo $stories;?><span class="uk-text-large"></span></li>
 		                                       <li><span class="uk-text-bold">Locker:</span> <?php echo $locker;?><span class="uk-text-large"></span></li>
 		                                      <?php } ?>

 		                                     <?php if($drive != ''){ ?>
 		                                       <li><span class="uk-text-bold">Drive:</span> <?php echo $drive;?><span class="uk-text-large"></span></li>
 		                                      <?php } ?>
 		                                     <?php if($bsmt1_out != '' || $bsmt2_out != '' ){ ?>
 		                                       <li><span class="uk-text-bold">Basement:</span> <?php echo $bsmt1_out;if ($bsmt2_out != ''){ echo "/".$bsmt2_out; }?><span class="uk-text-large"></span></li>
 		                                      <?php } ?>
 		                                      <?php if($fpl_num != '' ){ ?>
 		                                       <li><span class="uk-text-bold">Fireplace:</span> <?php echo $fpl_num; ?><span class="uk-text-large"></span></li>
 		                                      <?php } ?>
 		                                      <?php if($central_vac != '' ){ ?>
 		                                       <li><span class="uk-text-bold">Central Vac:</span> <?php echo $central_vac; ?><span class="uk-text-large"></span></li>
 		                                      <?php } ?>
 		                                    </ul> 
 		                         </div>
 		                     </div>
 		            </div>
 		      </div>
 		      <div class="uk-hidden-small uk-width-1-1" > &nbsp; </div>
 		      <div class="uk-hidden-small uk-width-1-1" >
 		            <div class="uk-panel uk-panel-box"  >
 		            <h3 class="uk-panel-title"  ><b>Rooms</b></h3>
 		                         <table class="uk-table">
 		                                <thead>
 		                                    <tr>
 		                                         <th>Level</th>
 		                                         <th>Room</th>
 		                                         <th>Dimensions</th>
 		                                         <th>Description</th>
 		                                    </tr>   
 		                                </thead>
 		                                <tbody>

 		                                    <?php if($level1 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level1;?></td>
 		                                        <td><?php echo $rm1_out;?></td>
 		                                        <td><?php if($rm1_wth != '' || $rm1_len != '') {echo $rm1_wth."m x".$rm1_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm1_dc1_out != ''?$rm1_dc1_out:'';
 		                                          $desc= $desc.($rm1_dc2_out != ''?", ".$rm1_dc2_out:'');
 		                                          $desc= $desc.($rm1_dc3_out != ''?", ".$rm1_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level2 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level2;?></td>
 		                                        <td><?php echo $rm2_out;?></td>
 		                                        <td><?php if($rm2_wth != '' || $rm2_len != '') {echo $rm2_wth."m x".$rm2_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm2_dc1_out != ''?$rm2_dc1_out:'';
 		                                          $desc= $desc.($rm2_dc2_out != ''?", ".$rm2_dc2_out:'');
 		                                          $desc= $desc.($rm2_dc3_out != ''?", ".$rm2_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level3 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level3;?></td>
 		                                        <td><?php echo $rm3_out;?></td>
 		                                        <td><?php if($rm3_wth != '' || $rm3_len != '') {echo $rm3_wth."m x".$rm3_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm3_dc1_out != ''?$rm3_dc1_out:'';
 		                                          $desc= $desc.($rm3_dc2_out != ''?", ".$rm3_dc2_out:'');
 		                                          $desc= $desc.($rm3_dc3_out != ''?", ".$rm3_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level4 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level4;?></td>
 		                                        <td><?php echo $rm4_out;?></td>
 		                                        <td><?php if($rm4_wth != '' || $rm4_len != '') {echo $rm4_wth."m x".$rm4_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm4_dc1_out != ''?$rm4_dc1_out:'';
 		                                          $desc= $desc.($rm4_dc2_out != ''?", ".$rm4_dc2_out:'');
 		                                          $desc= $desc.($rm4_dc3_out != ''?", ".$rm4_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level5 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level5;?></td>
 		                                        <td><?php echo $rm5_out;?></td>
 		                                        <td><?php if($rm5_wth != '' || $rm5_len != '') {echo $rm5_wth."m x".$rm5_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm5_dc1_out != ''?$rm5_dc1_out:'';
 		                                          $desc= $desc.($rm5_dc2_out != ''?", ".$rm5_dc2_out:'');
 		                                          $desc= $desc.($rm5_dc3_out != ''?", ".$rm5_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level6 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level6;?></td>
 		                                        <td><?php echo $rm6_out;?></td>
 		                                        <td><?php if($rm6_wth != '' || $rm6_len != '') {echo $rm6_wth."m x".$rm6_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm6_dc1_out != ''?$rm6_dc1_out:'';
 		                                          $desc= $desc.($rm6_dc2_out != ''?", ".$rm6_dc2_out:'');
 		                                          $desc= $desc.($rm6_dc3_out != ''?", ".$rm6_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level7 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level7;?></td>
 		                                        <td><?php echo $rm7_out;?></td>
 		                                        <td><?php if($rm7_wth != '' || $rm7_len != '') {echo $rm7_wth."m x".$rm7_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm7_dc1_out != ''?$rm7_dc1_out:'';
 		                                          $desc= $desc.($rm7_dc2_out != ''?", ".$rm7_dc2_out:'');
 		                                          $desc= $desc.($rm7_dc3_out != ''?", ".$rm7_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level8 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level8;?></td>
 		                                        <td><?php echo $rm8_out;?></td>
 		                                        <td><?php if($rm8_wth != '' || $rm8_len != '') {echo $rm8_wth."m x".$rm8_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm8_dc1_out != ''?$rm8_dc1_out:'';
 		                                          $desc= $desc.($rm8_dc2_out != ''?", ".$rm8_dc2_out:'');
 		                                          $desc= $desc.($rm8_dc3_out != ''?", ".$rm8_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level9 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level9;?></td>
 		                                        <td><?php echo $rm9_out;?></td>
 		                                        <td><?php if($rm9_wth != '' || $rm9_len != '') {echo $rm9_wth."m x".$rm9_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm9_dc1_out != ''?$rm9_dc1_out:'';
 		                                          $desc= $desc.($rm9_dc2_out != ''?", ".$rm9_dc2_out:'');
 		                                          $desc= $desc.($rm9_dc3_out != ''?", ".$rm9_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level10 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level10;?></td>
 		                                        <td><?php echo $rm10_out;?></td>
 		                                        <td><?php if($rm10_wth != '' || $rm10_len != '') {echo $rm10_wth."m x".$rm10_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm10_dc1_out != ''?$rm10_dc1_out:'';
 		                                          $desc= $desc.($rm10_dc2_out != ''?", ".$rm10_dc2_out:'');
 		                                          $desc= $desc.($rm10_dc3_out != ''?", ".$rm10_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level11 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level11;?></td>
 		                                        <td><?php echo $rm11_out;?></td>
 		                                        <td><?php if($rm11_wth != '' || $rm11_len != '') {echo $rm11_wth."m x".$rm11_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm11_dc1_out != ''?$rm11_dc1_out:'';
 		                                          $desc= $desc.($rm11_dc2_out != ''?", ".$rm11_dc2_out:'');
 		                                          $desc= $desc.($rm11_dc3_out != ''?", ".$rm11_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                                    <?php if($level12 != ''){?>
 		                                    <tr>
 		                                        <td><?php echo $level12;?></td>
 		                                        <td><?php echo $rm12_out;?></td>
 		                                        <td><?php if($rm12_wth != '' || $rm12_len != '') {echo $rm12_wth."m x".$rm12_len."m" ;}?></td>
 		                                        <?php
 		                                          $desc= $rm12_dc1_out != ''?$rm12_dc1_out:'';
 		                                          $desc= $desc.($rm12_dc2_out != ''?", ".$rm12_dc2_out:'');
 		                                          $desc= $desc.($rm12_dc3_out != ''?", ".$rm12_dc3_out:'');
 		                                         ?>
 		                                        <td><?php echo $desc;?></td>
 		                                    </tr>
 		                                    <?php } ?>

 		                               </tbody>
 		                         </table>
 		                    </div> <!-- panel --!>
 		               </div> <!--inner width 1-1--!>
