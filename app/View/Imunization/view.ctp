<style>
.td_cell {
    font-size: 13px;
}</style>
<div class="inner_title">
	<h3 style="padding-left:20px;">
		<?php echo __('View Immunization'); ?>
		<div style="float:right;">
	<?php
	if($initialAssessment == 'initialAssessment'){
		echo $this->Html->link(__('Back to List'), array('controller'=>'imunization','action' => 'index',$patient_id,$id,'?'=>array('pageView'=>"ajax")), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 13px 0 0;'));
	}else{
		echo $this->Html->link(__('Back to List'), array('controller'=>'imunization','action' => 'index',$patient_id,$id), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 13px 0 0;'));
	}?>
	</div>
	</h3>
			
</div>
<?php echo $this->Form->create('Immunization',array('id'=>'Immunization','url'=>array('controller'=>'imunization','action'=>'marked_as_error',$patient_id,$id),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
echo $this->Form->hidden('patient_id',array('value'=>$patient_id));
echo $this->Form->hidden('id',array('value'=>$id));
?>
<div style="width:100%; text-align:center;">
<table width="40%" border="0" cellspacing="0" cellpadding="0"
	class="tbl" style=" border:1px solid #ccc; padding:20px;" align="center";>
	<?php 
	if($imu_detail['Immunization']['admin_note'] == 1){
                        			$displayValue='blank';
                        		}else{
											$displayValue='none';
										}?>
	<tr>
       
		<td class="td_cell"> <?php echo __('Administration Notes',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['PhvsImmunizationInformationSource']['description']; ?> <?php if(empty($imu_detail['PhvsImmunizationInformationSource']['description'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	<tr>
         
		<td class="td_cell" width="40%"> <?php echo __('Immunization',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['Imunization']['cpt_description']; ?>
		</td>
	</tr>
	
	
	
	<tr style="display:<?php echo $displayValue ?>;">
  
		<td class="td_cell"> <?php echo __('Administered Amount',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['Immunization']['amount']; ?>&nbsp;<?php echo $imu_detail['PhvsMeasureOfUnit']['value_code']; ?> <?php if(empty($imu_detail['Immunization']['amount'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	
	<tr>
   
		<td class="td_cell"> <?php echo __('Administering Provider',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['User']['first_name']; ?>&nbsp;<?php  echo $imu_detail['User']['last_name']; ?><?php  echo $imu_detail['Role']['name']; ?><?php if(empty($imu_detail['User']['first_name'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	
	<tr>
  
		<td class="td_cell"> <?php echo __('Lot Number',true); ?>
        
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['Immunization']['lot_number']; ?> <?php if(empty($imu_detail['Immunization']['lot_number'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	<tr>
    
		<td class="td_cell" valign="top"> <?php echo __('Start of Administration Date'); ?>
        
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $this->DateFormat->formatDate2Local($imu_detail['Immunization']['date'],Configure::read('date_format'),true); ?> <?php if(empty($imu_detail['Immunization']['date'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	<tr>
    
		<td class="td_cell" valign="top"> <?php echo __('Expiration Date'); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $this->DateFormat->formatDate2Local($imu_detail['Immunization']['expiry_date'],Configure::read('date_format'),true); ?> <?php if(empty($imu_detail['Immunization']['expiry_date'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	
	<tr>
       
		<td class="td_cell"> <?php echo __('Manufacturer Name',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['PhvsVaccinesMvx']['description']; ?> <?php if(empty($imu_detail['PhvsVaccinesMvx']['description'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	
	<tr>
    
		<td class="td_cell"> <?php echo __('Route',true); ?>
		</td>
		<td class="row_format" >:</td>
		<td class="row_format">
			<?php  echo $imu_detail['PhvsAdminsRoute']['description']; ?> <?php if(empty($imu_detail['PhvsAdminsRoute']['description'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	
	<tr>
    
		<td class="td_cell"> <?php echo __('Administration Site',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['PhvsAdminSite']['description']; ?> <?php if(empty($imu_detail['PhvsAdminSite']['description'])){echo ('Unkonwn'); } ?>
		</td>
	</tr>
	
	
	
	<tr style="display:<?php echo $displayValue ?>;">
  
		<td class="td_cell"> <?php echo __('Substance/Treatment Refusal Reason',true); ?>
		</td>
		<td class="row_format" >:</td>
		<td class="row_format">
			<?php  echo $nipCode003[$imu_detail['Immunization']['reason']]; ?> <?php if(empty($imu_detail['Immunization']['reason'])){echo Unkown; } ?>
		</td>
	</tr>
	<!--  new --> 
	<tr style="display:<?php echo $displayValue ?>;">
   
		<td class="td_cell"> <?php echo __('Immunization Registry Status',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $ImmunizationRegistryStatus[$imu_detail['Immunization']['registry_status']]; ?> <?php if(empty($imu_detail['Immunization']['registry_status'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr style="display:<?php echo $displayValue ?>;">
 
		<td class="td_cell"> <?php echo __('Publicity Code',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $publicitycode[$imu_detail['Immunization']['publicity_code']]; ?> <?php if(empty($imu_detail['Immunization']['publicity_code'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr>
   
		<td class="td_cell"> <?php echo __('Protection Indicator',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
		<?php if($imu_detail['Immunization']['protection_indicator'] == 'Y'){
					$protectionIndicator = 'Yes';
			}else if($imu_detail['Immunization']['protection_indicator'] == 'N'){
					$protectionIndicator = 'No';
			}else{$protectionIndicator = '';}?>
			<?php  echo $protectionIndicator; ?> <?php if(empty($imu_detail['Immunization']['protection_indicator'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr>
     
		<td class="td_cell"> <?php echo __('Protection Indicator Effective Date',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $this->DateFormat->formatDate2Local($imu_detail['Immunization']['indicator_date'],Configure::read('date_format'),true); ?> <?php if(empty($imu_detail['Immunization']['indicator_date'])){echo Unkown; } ?>
		</td>
	</tr>
     
	<tr style="display:<?php echo $displayValue ?>;">
    
		<td class="td_cell"> <?php echo __('Publicity Code Effective Date',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $this->DateFormat->formatDate2Local($imu_detail['Immunization']['publicity_date'],Configure::read('date_format'),true); ?> <?php if(empty($imu_detail['Immunization']['publicity_date'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr style="display:<?php echo $displayValue ?>;">
  
		<td class="td_cell"> <?php echo __('Registry Status Effective Date',true); ?>
		</td>
		<td class="row_format" >:</td>
		<td class="row_format">
			<?php  echo $this->DateFormat->formatDate2Local($imu_detail['Immunization']['registry_status_date'],Configure::read('date_format'),true); ?> <?php if(empty($imu_detail['Immunization']['registry_status_date'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr style="display:<?php echo $displayValue ?>;">
    
		<td class="td_cell"> <?php echo __('Vaccine funding program eligibility category',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $PhvsObservationIdentifier[$imu_detail['Immunization']['funding_category']]; ?> <?php if(empty($imu_detail['Immunization']['funding_category'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr>
  
		<td class="td_cell"> <?php echo __('Presented Date',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $this->DateFormat->formatDate2Local($imu_detail['Immunization']['presented_date'],Configure::read('date_format'),true); ?> <?php if(empty($imu_detail['Immunization']['presented_date'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr style="display:<?php echo $displayValue ?>;">
   
		<td class="td_cell"> <?php echo __('Date/Time of Observation',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $this->DateFormat->formatDate2Local($imu_detail['Immunization']['observation_date'],Configure::read('date_format'),true); ?> <?php if(empty($imu_detail['Immunization']['observation_date'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr style="display:<?php echo $displayValue ?>;">
  
		<td class="td_cell"> <?php echo __('Observation Method',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $imu_detail['Immunization']['observation_method']; ?> <?php if(empty($imu_detail['Immunization']['observation_method'])){echo Unkown; } ?>
		</td>
	</tr>
	<tr style="display:<?php echo $displayValue ?>;">
 
		<td class="td_cell"> <?php echo __('Observation value',true); ?>
		</td>
		<td class="row_format">:</td>
		<td class="row_format">
			<?php  echo $PhvsFinancialClass[$imu_detail['Immunization']['observation_value']]; ?> <?php if(empty($imu_detail['Immunization']['observation_value'])){echo Unkown; } ?>
		</td>
	</tr>
	<!--Eof new  -->
	<!-- 
	<tr>
		<td class="td_cell"> <?php echo __('Completion Status',true); ?>
		</td>
		<td class="row_format"  width="5%">:</td>
		<td class="row_format">
			<?php  
			echo $this->Form->input('completion_status', array('label' => false,'options'=>$completetionOptions,'empty'=>array(''=>__('Please Select'))));
			?>
		</td>
	</tr>
	
	<tr>
		<td class="td_cell"> <?php echo __('Due Date',true); ?>
		</td>
		<td class="row_format"  width="5%">:</td>
		<td class="row_format">
			<?php  
			echo $this->Form->input('due_date',array('type'=>'text','id'=>"due_date","label"=>false));
			?>
		</td>
	</tr>
	
	<tr>
		<td class="td_cell"> <?php echo __('Marked as error',true); ?>
		</td>
		<td class="row_format"  width="5%">:</td>
		<td class="row_format">
			<?php  
			echo $this->Form->input('error_status', array('value'=>$imu_detail['Immunization']['error_status'],'readonly'=>'readonly','style'=>'width:160px','options'=>array(''=>__('Please Select'),'Entered In Error'=>__('Entered in error'))));
			?>
		</td>
	</tr>
	
	 -->
	
</table>
</div>
<table width="100%">
	<!-- 
	<tr>
	<td width="270">
          <?php echo $this->Form->input('error_status', array('value'=>$imu_detail['Immunization']['error_status'],'readonly'=>'readonly','style'=>'width:160px','options'=>array(''=>__('Please Select'),'Entered In Error'=>__('Entered in error')))); ?>	
         	                       		
	</td>
	</tr>
	-->
	<tr>
		
		<td align="right"><?php 
		//echo $this->Html->link(__('Cancel'), array('controller'=>'imunization','action' => 'index',$patient_id), array('escape' => false,'class'=>'blueBtn'));
	//	echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false));
		?>
		</td>
	</tr>
</table>
<?php 
echo $this->Form->end();
?>
<script>
var firstYr = new Date().getFullYear()-100;
var lastYr = new Date().getFullYear()+10;
$("#due_date").datepicker({	
	changeMonth : true,
	changeYear : true,
	yearRange: firstYr+':'+lastYr,
//	minDate : new Date(explode[0], explode[1] - 1,
//			explode[2]),
	dateFormat : 'mm/dd/yy HH:II:SS',
	showOn : 'button',
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	onSelect : function() {
		$(this).focus();
	}
});

</script>