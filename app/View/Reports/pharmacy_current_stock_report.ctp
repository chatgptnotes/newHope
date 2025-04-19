<div class="inner_title">
	<h3>
		<?php echo __('Pharmacy Current Stock Status Report', true); ?>
	</h3>
	<span>
	<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	 </span>
</div> 
<br/>

<?php  echo $this->Form->create('',array('action'=>'pharmacyCurrentStockReport','type' => 'POST','id'=>'noofFollowupfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>
 <table align="center">  
 	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PharmacySale.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	
	 <tr>
	 <td colspan="8" align="right">From<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PharmacySale.from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
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
$(function() {
	 var currentDate = new Date();
	 var currentDate1=currentDate.format('d/m/Y');
	   $('#from').val(currentDate1);
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		defaultDate: currentDate,
		dateFormat: '<?php echo $this->General->GeneralDate();?>',
					
	});	
		
 
});	
</script>