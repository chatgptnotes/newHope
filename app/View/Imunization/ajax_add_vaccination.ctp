                              	<td valign="top" style="padding-top:10px;"><?php echo $counter+1; ?></td>
                                <td valign="top">                                	 
                                	<?php echo $this->Form->input('', array('name'=>"data[VaccinationRemainder][$counter][vaccination_name]",
                                		 'class' => "validate[required,custom[mandatory-enter]] textBoxExpnd", 'label' => false,'div' => false,'error'=>false,'id'=>'','value'=>$getData,'type'=>'text','style'=>'width:400px;')); 
                                    	?>
                                </td>
                                <td style="padding-top:10px;" id="showDateTbl_<?php echo $counter ?>"> 
                                <?php $count  = 1 ;
 									for($i=0;$i<$count;){?>	
                                <table width="100%" cellpadding="0" cellspacing="1" border="0" class="getTblId getRowInner" align="center" >
                               <tr id="TestGroupVaccinationInner_<?php echo $counter;?>_<?php echo $i ?>"  class="block_<?php echo $counter;?> uniqueRow_<?php echo $counter;?>_<?php echo $i ?> "> 				
                                <td style="float:left">
								<?php $dataAll=$this->DateFormat->formatDate2Local($getDateExp[0],Configure::read('date_format'));
								echo $this->Form->input('', array('name'=>"data[VaccinationRemainder][$counter][date][$i]",'id' => 'vaccinationdate_'.$counter.'_'.$i, 'label' => false,'div' => false,'error'=>false,'type'=>'text','class'=>"validate[required,custom[mandatory-date]] textBoxExpnd vaccinationdatecls1 vaccinationdatecls_$counter_$i",'value'=>$dataAll));
								echo $this->Form->hidden('',array('id'=>'recordId_'.$counter.'_'.$i,'value'=>$getDateExp[1],'name'=>"data[VaccinationRemainder][$counter][id][$i]",'class'=>'recordId'));
								echo '</n>';				           
 								echo $this->Form->hidden('',array('id'=>'vaccinationId_'.$counter.'_'.$i,'value'=>$counter,'name'=>"data[VaccinationRemainder][$counter][vaccination_id][$i]",'class'=>'vaccinationId')); 
							?>
							<span style="float:left" class="removeButtonVaccCls" id="removeButtonVaccLink_<?php echo $counter.'_'.$i;?>">
							<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?>  
				            </span>
				                 </td> 
				                  </tr>
				                 </table> 
                                    <?php $i++;}?>
                                   </td>   
                                     <td valign="top">  <?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'class' => 'addButtonDatecls','id'=>'addButtonDate_'.$counter));
                                     ?>						 
				                 </td>                              
	                             <!--  <td valign="top" align="center" style="padding-top:15px;">
                          		  <?php 
                          		  		echo $this->Html->link($this->Html->image('icons/close-icon.png'),
					 			                       '#',array('id'=>"removeButtonHistopathology_$counter",'escape' => false,'class'=>'removeBtnHistopathology','title'=>'Remove')) ;
					 			     
                          		  ?>
                          		  </td> -->
                          		 
