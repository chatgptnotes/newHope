<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('EKG List') ?>
	</h3>
	<span> <?php	echo $this->Html->link(__('Back'), array('action' => 'ekg_manager'), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<p class="ht5"></p>


<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<?php echo $this->Form->create('Ekg', array('url' => array('controller' => 'EKG', 'action' => 'ekg_result',$ekgData['EKG']['patient_id']),'id'=>'ekgfrm',
														'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
<table>
	<tr>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%" style="text-align: center;">
			<?php if(isset($ekgData) && !empty($ekgData)){ ?>
			<tr class="row_title">
				<td class="table_cell" align="left"><strong> <?php echo  __('History', true); ?>
				</strong></td>
				<td class="table_cell" align="left"><strong> <?php echo  __('Pacemaker', true); ?>
				</strong></td>
				<td class="table_cell" align="left"><strong> <?php echo  __('Assignment Accepted ', true); ?>
				</strong></td>
				<td class="table_cell" align="left"><strong> <?php echo  __('Cardiac Medications', true); ?>
				</strong></td>
				<td class="table_cell" align="left"><strong><?php echo  __('Status'); ?> </strong>
				</td>
				<td class="table_cell" align="left"><strong> <?php echo  __('Action'); ?>
				</strong></td>
			</tr>
			<?php
			$toggle =0;
			if(count($ekgData) > 0) {
									foreach($ekgData as $key=>$ekgDisplay){

											 if(!empty($ekgDisplay)) {
											}else{
		                                 			echo "<tr class='row_title'><td colspan='5>&nbsp;</td></tr>" ;
		                                 		}
		                                 		if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   if($ekgDisplay['EkgResult']['confirm_result']==1){
										   		$status = 'Report Delivered';

										   }else{
										   		$status = 'Pending';

										   }
										   ?>

			<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['history']; ?></td>
			<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['pacemaker']; ?>
			</td>
			<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['assignment_accepted']; ?>
			</td>
			<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['cardiac_medication']; ?>
			</td>
			<td class="row_format" align="left"><?php echo $status; ?>
			</td>

			<td class="row_action" align="left"><?php $patient_id=$ekgDisplay['EKG']['patient_id'];
			$ekg_id=$ekgDisplay['EKG']['id'];

			$publishTime = strtotime($ekgDisplay['EkgResult']['result_publish_date']) ;
			$currentTime = time();
			$diffHours = date("H",$currentTime - $publishTime) ;
			if($ekgDisplay['EkgResult']['confirm_result'] ==1 &&  ($diffHours < 25)){
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'View/Edit Published Result')),
								array('controller'=>'EKG','action' => 'incharge_ekg_result',
										$patient_id,$ekg_id), array('escape'=>false));
					}
					if($ekgDisplay['EkgResult']['confirm_result'] !=1){

			echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Add/Edit EKG')),array('controller'=>'EKG','action' => 'ekg_result',
							$patient_id,$ekg_id), array('escape'=>false));
					}
					if($ekgDisplay['EkgResult']['confirm_result'] == 1){
			echo $this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'View Result')),array('controller'=>'EKG','action' => 'view_result',
							$patient_id,$ekg_id), array('escape'=>false));
				}
				?></td>
			</tr>
			<?php } ?>
			<tr>
				<TD colspan="8" align="center">
					<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
					<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
					<!-- prints X of Y, where X is current page and Y is number of pages -->
					<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
				</span>
				</TD>
			</tr>
			<?php }?>
			<?php } else {?>
			<tr>
				<TD colspan="5" align="center" class="error"><?php echo __('No EKG Results for selected patients', true); ?>.
				</TD>
			</tr>
			<?php } ?>
		</table>
	</tr>

</table>
<?php echo $this->Form->end();	 ?>