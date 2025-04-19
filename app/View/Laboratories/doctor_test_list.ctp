<div class="inner_title">
	<h3>Lab Result</h3>
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php
echo $this->element ( 'patient_information' );
?>
<div class="clr ht5"></div>
<?php
echo $this->Form->create ( 'Laboratory', array (
		'url' => array (
				'controller' => 'laboratories',
				'action' => 'lab_result',
				$patient_id 
		),
		'id' => 'labResultfrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>

		<td width="300" class="tdLabel2">
                            	<?php
																													echo $this->Html->link ( 'Back to Patient Info', array (
																															'controller' => 'patients',
																															'action' => 'patient_information',
																															$patient_id 
																													), array (
																															'escape' => false,
																															'class' => 'blueBtn' 
																													) );
																													
																													?>
                            </td>

	</tr>
</table>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
				<?php
				
				if (isset ( $testOrdered ) && ! empty ( $testOrdered )) {
					?> 
						  <tr class="row_title">
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('LabManager.order_id', __('Lab Order id', true)); ?></strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('LabManager.create_time', __('Order Time', true)); ?></strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Laboratory.name', __('Test Name', true)); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Status'); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
	</tr>
						  <?php
					$toggle = 0;
					if (count ( $testOrdered ) > 0) {
						foreach ( $testOrdered as $labs ) {
							
							if ($toggle == 0) {
								echo "<tr class='row_gray'>";
								$toggle = 1;
							} else {
								echo "<tr>";
								$toggle = 0;
							}
							// status of the report
							if ($labs ['LaboratoryResult'] ['confirm_result'] == 1) {
								$status = 'Resulted';
							} else {
								$status = 'Pending';
							}
							
							?>								  
										   <td class="row_format"><?php echo $labs['LabManager']['order_id']; ?></td>
	<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($labs['LabManager']['create_time'],Configure::read('date_format'),true); ?> </td>
	<td class="row_format"><?php echo ucfirst($labs['Laboratory']['name']); ?> </td>
	<td class="row_format"><?php echo $status; ?> </td>
	<td class="row_format" align="center">
										    <?php
							if ($labs ['LaboratoryResult'] ['confirm_result'] == 1) {
								echo $this->Html->link ( $this->Html->image ( 'icons/view-icon.png' ), array (
										'controller' => 'Laboratories',
										'action' => 'lab_result',
										$labs ['LaboratoryTestOrder'] ['patient_id'],
										$labs ['Laboratory'] ['id'],
										$labs ['LaboratoryTestOrder'] ['id'] 
								), array (
										'escape' => false 
								) );
								echo $this->Html->link ( __ ( 'Print Preview' ), '#', array (
										'escape' => false,
										'class' => 'blueBtn',
										'onclick' => "var openWin = window.open('" . $this->Html->url ( array (
												'action' => 'print_preview',
												$labs ['LaboratoryTestOrder'] ['patient_id'],
												$labs ['Laboratory'] ['id'],
												$labs ['LaboratoryTestOrder'] ['id'] 
										) ) . "', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;" 
								) );
								// echo $this->Html->link(__('Generate PDF'), array('controller'=>'laboratories','action' => 'viewPdf',$labs['LaboratoryTestOrder']['patient_id'],$labs['Laboratory']['id'],$labs['LaboratoryTestOrder']['id']), array('escape'=>false));
							}
							?>
											</td>
	</tr>
							  <?php
						}
						
						// set get variables to pagination url
						$this->Paginator->options ( array (
								'url' => array (
										"?" => $this->params->query 
								) 
						) );
						?>
							   <tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		</TD>
	</tr>
					<?php } ?> <?php
				} else {
					?>
					  <tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.</TD>
	</tr>
					  <?php
				}
				
				?>
		</table>



<?php echo $this->Form->end();	 ?>