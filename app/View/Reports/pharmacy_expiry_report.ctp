<div class="inner_title">
	<h3>
		<?php echo __('Pharmacy Expiry Report', true); ?>
	</h3>
	<span>
	<?php //echo $this->Html->link(__('Generate Excel Sheet'),array('controller'=>'Reports','action'=>'pharmacyExpiryReport','?'=>array('flag'=>'excel')), array('escape' => false,'class'=>'blueBtn'));
		 echo $this->Html->link(__('Back to Report'), array('controller'=>'Pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	 </span>
</div> 
<br/>

<?php  echo $this->Form->create('',array('action'=>'pharmacyExpiryReport','type' => 'POST','id'=>'reportfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>
 <table align="center">  
	 <tr>
	 <td  align="right" width="20%">Format</td>
	 <td width="1%"><b>:</b></td>
	 <td  align="left" width="25%"><?php
		echo $this->Form->input('PharmacySale.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	<!--  <tr>
	 <td  align="right"><?php echo __('Show Date'); ?></td>
	 <td><b>:</b></td>
	 <td align="left">
	  <?php 
             echo $this->Form->checkbox('PharmacySale.show_item', array('id'=>'show_expiry_date','label'=> false, 'div' => false, 'error' => false));
          ?>
	 </td>
	</tr>
	<tr style="display: none;" id="expirydate">
	 <td align="right">Expiry Date<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td align="left">
		<?php 
        echo $this->Form->input('PharmacySale.expiry_date', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from_date','label'=> false, 'div' => false, 'error' => false));?>
	</td>
	  </tr>	 -->

	<tr>
	 <td align="right">From Date<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td align="left">
		<?php 
        echo $this->Form->input('PharmacySale.from_date', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from_date','label'=> false, 'div' => false, 'error' => false));?>
	</td>
	</tr>
	<tr>
	 <td align="right">To Date<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td align="left">
		<?php 
        echo $this->Form->input('PharmacySale.to_date', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'to_date','label'=> false, 'div' => false, 'error' => false));?>
		</td>
	</tr>	
 </table>
 <div align="center"  style="display: none; color:red;font-weight: italic;" id="expirydate1"> <strong>Note : </strong> Expiry Date range within 3 Months
 </div>
 <div class="clr ht5"></div>   
   <div align="center">  
	<div class="btns" style="float:none">
	<?php   echo $this->Form->submit(__('Get Report'), array('id'=>'submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
        //echo $this->Html->link(__('Cancel'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
 	 <a  class="grayBtn" href="javascript:history.back();">Cancel</a>  
 	</div>
	
 </div>


 <?php echo $this->Form->end(); ?>

<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	});
$(document).ready(function(){
	
	$("#from_date").datepicker({
		showOn : "both",	
		changeMonth : true,
		changeYear : true,
		yearRange: '1950',	
		//maxDate: new Date('<?php echo date('Y') ?>',parseInt('<?php echo date('m')?>')+2,'<?php echo date('d') ?>'), 
		//minDate: new Date(),
		dateFormat : '<?php echo $this->General->GeneralDate();?>',
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		onSelect : function() {
			$(this).focus();			
		}	
	});	

	$("#to_date").datepicker({
		showOn : "both",	
		changeMonth : true,
		changeYear : true,
		yearRange: '1950',	
		//maxDate: new Date('<?php echo date('Y') ?>',parseInt('<?php echo date('m')?>')+2,'<?php echo date('d') ?>'), 
		//minDate: new Date(),
		dateFormat : '<?php echo $this->General->GeneralDate();?>',
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		onSelect : function() {
			$(this).focus();			
		}	
	});	


	 $("#show_expiry_date").click(function () {  
	
	if($(this).is(':checked') == true) {  	
		 $('#expirydate').show();
		 $('#expirydate1').show();
	 }else{
		 $('#expirydate').hide();
		 $('#expirydate1').hide();
		 $('#from_date').val("");
	 }
 });
	
});
</script>