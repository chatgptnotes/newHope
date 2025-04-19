<style>
.row_action img {
	float: inherit;
}
</style>
<p class="ht5"></p>
<?php
echo $this->Form->create ( 'Laboratory', array (
		'id' => 'labManagerfrm',
		'action' => 'lab_manager_test_order',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );
?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center">
	<tr>
		<th width="90">Patient ID</th>

	</tr>
	<tr>
		<td valign="top"><?php echo $data[0]['Patient']['patient_id']; ?></td>

		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="0"
				class="tabularForm">
				<tr>
					<th width="100%" style="text-align: center;">Labs</th>
				</tr>
				<tr>
                                      	<?php 	foreach($data as $testData){?>
                                      			<td valign="top" width="100%">
		                                        	<?php
																																								$labID = $testData ['Laboratory'] ['id'];
																																								echo $this->Html->link ( $testData ['Laboratory'] ['name'], '#', array (
																																										'escape' => false,
																																										'style' => "text-decoration:underline;",
																																										'id' => $labID,
																																										'class' => 'test-link' 
																																								) );
																																								?>
		                                          	<div class="ht5"></div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td style="padding: 0 10px 0 0;">Sp.ID</td>
								<td width="50%" style="padding: 0;">
		                                                    	<?php
																																								
																																								if (isset ( $testData ['LaboratoryToken'] )) {
																																									$id = $testData ['LaboratoryToken'] ['id'];
																																									$sp_id = $testData ['LaboratoryToken'] ['sp_id'];
																																									$ac_id = $testData ['LaboratoryToken'] ['ac_id'];
																																								} else {
																																									$id = '';
																																									$sp_id = '';
																																									$ac_id = '';
																																								}
																																								echo $this->Form->hidden ( '', array (
																																										'name' => "data[LaboratoryToken][$labID][id]",
																																										'value' => $id 
																																								) );
																																								echo $this->Form->hidden ( '', array (
																																										'name' => "data[LaboratoryToken][$labID][laboratory_id]",
																																										'value' => $labID 
																																								) );
																																								echo $this->Form->hidden ( '', array (
																																										'name' => "data[LaboratoryToken][$labID][laboratory_test_order_id]",
																																										'value' => $testData ['LaboratoryTestOrder'] ['id'] 
																																								) );
																																								echo $this->Form->hidden ( '', array (
																																										'name' => "data[LaboratoryToken][$labID][patient_id]",
																																										'value' => $testData ['Patient'] ['id'] 
																																								) );
																																								echo $this->Form->input ( '', array (
																																										'type' => 'text',
																																										'name' => "data[LaboratoryToken][$labID][sp_id]",
																																										'value' => $sp_id 
																																								) );
																																								?>
		                                                    	 
		                                                    </td>
							</tr>
							<tr>
								<td colspan="2" height="5" style="padding: 0;"></td>
							</tr>
							<tr>
								<td style="padding: 0 10px 0 0;">Ac.ID</td>
								<td width="50%" style="padding: 0;">
		                                                    <?php
																																								echo $this->Form->input ( '', array (
																																										'type' => 'text',
																																										'name' => "data[LaboratoryToken][$labID][ac_id]",
																																										'value' => $ac_id 
																																								) );
																																								?>
		                                                  </td>
							</tr>
							<tr>
								<td style="padding: 0 10px 0 0;">Sample Collected On :</td>
								<td width="50%" class="row_action">
		                                                    <?php
																																								if (! empty ( $testData ['LaboratoryToken'] ['collected_date'] )) {
																																									$sample_collected_date = $this->DateFormat->formatDate2Local ( $testData ['LaboratoryToken'] ['collected_date'], Configure::read ( 'date_format' ), true );
																																								} else {
																																									$sample_collected_date = '';
																																								}
																																								echo $this->Form->input ( '', array (
																																										'id' => 'collectedDate',
																																										'readonly' => 'readonly',
																																										'autocomplete' => 'off',
																																										'type' => 'text',
																																										'name' => "data[LaboratoryToken][$labID][collected_date]",
																																										'value' => $sample_collected_date 
																																								) );
																																								?>
		                                                  </td>
							</tr>
						</table>
					</td>
                                      	<?php } ?>
                                        
                                      </tr>
			</table>
		</td>
	</tr>
</table>
<p class="ht5"></p>
<p class="ht5"></p>
<div align="right">
                       		<?php
																									echo $this->Form->submit ( __ ( 'Save' ), array (
																											'id' => 'add-more',
																											'title' => 'Save',
																											'escape' => false,
																											'class' => 'blueBtn',
																											'label' => false,
																											'div' => false,
																											'error' => false 
																									) );
																									
																									echo $this->Html->link ( __ ( 'Cancel' ), "#", array (
																											'escape' => false,
																											'class' => 'grayBtn',
																											'id' => 'cancel-order-form' 
																									) );
																									
																									echo $this->Js->writeBuffer ();
																									?>
                       </div>
<?php echo $this->Form->end();	 ?>
   <?php
			echo $this->Form->create ( 'Laboratory', array (
					'url' => array (
							'controller' => 'laboratories',
							'action' => 'lab_result',
							$patient_id,
							$labID,
							$testData ['LaboratoryToken'] ['laboratory_test_order_id'] 
					),
					'id' => 'labResultfrm',
					'inputDefaults' => array (
							'label' => false,
							'div' => false,
							'error' => false 
					) 
			) );
			
			echo $this->Form->hidden ( 'laboratory_id', array (
					'id' => 'laboratory_ids' 
			) );
			echo $this->Form->end ();
			?>
<script>
		$(document).ready(function(){
			   $('#cancel-order-form').click(function(){
					$('#test-order').html('');
					$('#search-filter').delay(400).fadeIn('slow');			
					$('#flashMessage').remove();       					
					return false ;
			   });

			   $('.test-link').click(function(){
				   
				   $('#laboratory_ids').val($(this).attr('id'));				   
				   $('#labResultfrm').submit();
			   });
		});

		$("#collectedDate" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true, 
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
            onSelect:function(){
				$(this).focus();				
            },
            minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
            maxDate:new Date()
		});
		
		//function to check search filter
		$('#labManagerfrm').submit(function(){
			var msg = false ; 
			 
			$("form input:text").each(function(){
			       //access to form element via $(this)
			        
			       if($(this).val() !=''){
			       		msg = true  ;
			       }
			    }
			);
			if(!msg){
				alert("Please fill atleast one field .");
				return false ;
			}		
		});
	//EOF check on search filter
	
	
	</script>
