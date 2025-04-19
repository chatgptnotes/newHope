<div class="inner_title">
 <h3>&nbsp; <?php echo __('OT Scheduling') ?></h3>
</div> 
 <div class="patient_info">
			<table width="100%">
				<tr>
					
					<td width="100%" valign="top">
						<?php 
							echo $this->Form->create(null, array('url' => array('controller' => 'opt_appointments', 'action'=>'optevent'), 'id'=>'appointmentfrm', 'inputDefaults' => array('label' => false,'div' => false))); 
						?>
						<table width="50%">
							<tr>
								<td colspan="3"><?php 	echo __('OT Room')?></td>
							</tr>
							<tr>
								<td>
                                                                 <?php										  	 
								echo $this->Form->input(null,array('name' => 'opt_id', 'id'=> 'opt_id', 'empty'=>__('Select OT'),'options'=>$opts,'onchange'=> $this->Js->request(array('action' => 'getOptTableList'),array(
    'before' => $this->Js->get('#busy-indicator')->effect('show'),'complete' => $this->Js->get('#busy-indicator')->effect('hide'), 'async' => true, 'update' => '#changeOptTableList', 'data' => '{opt_id:$("#opt_id").val()}', 'dataExpression' => true, 'div'=>false))));											
									?>
                                                                
								</td>
                                                        	</tr>
                                                              <tr><td colspan="3" height="10"></td></tr>
                                                              <tr>
								<td colspan="3" id="ottable" style="display:none;"></td>
							      </tr>
							      <tr>
								<td id="changeOptTableList">
                                                               </td>
                                                              </tr>
                                                              <tr>
                                                                 <td colspan="3">
                                                                  <?php
											echo $this->Form->submit(__('Show'),array('class'=>'blueBtn','label' => false,'div' => false));										
									?>
                                                                 </td>
                                                              </tr> 
						</table>
						<?php echo $this->Form->end(); ?>
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>			 
		</div>	
		 