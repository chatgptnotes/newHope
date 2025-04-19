
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	                    	 
	                        <?php 
							      $cnt =0;
							      if(count($data) > 0) {
							       foreach($data as $doctortemp):
							       $cnt++;
							  ?>
								   <tr>	
								   <td align="right">
									   <?php
									   		if($doctortemp['DischargeTemplate']['user_id']=='0'){
									   			echo  $this->Html->image('icons/favourite-icon.png', array('title'=> __('Admin Template', true), 'alt'=> __('Discharge Template Edit', true)));
									   		}else{
									   			echo "&nbsp;";
									   		}  
									   ?>
									   </td>  	  
								   <td class="row_format leftPad10" style="font-size:11px;">
								   		<?php 
								   		 
								   		 	echo $this->Js->link($doctortemp['DischargeTemplate']['template_name'] , array('action' => 'add_template_text', $doctortemp['DischargeTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    	 											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
								   			 
								   		?>
								   </td>
								   <td>
								   <?php
								   if($doctortemp['DischargeTemplate']['user_id']=='0'){
								   	echo "&nbsp;";
								   }else{
								   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))),
								   								 array('action' => 'add',$template_type, $doctortemp['DischargeTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
										
								   }		  
								
								   			/*echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))), array('action' => 'edit', $doctortemp['DischargeTemplate']['id']), array('escape' => false,'update'=>'#doctemp_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
											echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template Delete', true), 'alt'=> __('Doctor Template Delete', true))), array('action' => 'delete', $doctortemp['DischargeTemplate']['id']), array('update'=>'#doctemp_content','method'=>'post','escape' => false,'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'confirm'=>"Are you sure you wish to delete this template?"));
								  			*/
								   ?>
								  </tr>
							  <?php endforeach;  ?>				   
					  <?php		  
					      } else {
					  ?>
						  <tr>
						   		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
						  </tr>
					  <?php
					      }	
					      ?>
	                    </table>
	                    <?php
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>