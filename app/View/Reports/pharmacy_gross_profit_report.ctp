<div class="inner_title">
	<h3>
		<?php echo __('Pharmacy Gross Profit Report', true); ?>
	</h3>
	<span>
	<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	 </span>
</div> 
<br/>

<?php  echo $this->Form->create('',array('action'=>'pharmacyGrossProfitReport','type' => 'POST','id'=>'reportfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>
 <table align="center">  
	  <tr>
	 <td  align="right" width="25%">Format</td>
	 <td width="1%"><b>:</b></td>
	 <td  align="left" width="25%"><?php
		echo $this->Form->input('PharmacySale.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	 <tr>
	 <td  align="right"><?php echo __('From'); ?><font color="red">*</font></td>
	 <td><b>:</b></td>
	 <td align="left">
	  <?php echo $this->Form->input('PharmacySale.from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd dateFromTo','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
	
	 </td>
	</tr>
	<tr>
	 <td align="right">To<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td align="left">
		<?php echo $this->Form->input('PharmacySale.to', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd dateFromTo','style'=>'width:120px;','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
	</td>
	  </tr>	
 </table>
 
 <div class="clr ht5"></div>   
   <div align="center">  
	<div class="btns" style="float:none">
	<?php   echo $this->Form->submit(__('Get Report'), array('id'=>'submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false,'onclick' => "return getValidate();"));
        //echo $this->Html->link(__('Cancel'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
 	 <a  class="grayBtn" href="javascript:history.back();">Cancel</a>  
 	</div>
	
 </div>


 <?php echo $this->Form->end(); ?>

<script>
$(function() {
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();				
                   var thisVal = $(this).val();	                 
                   var splitDate=thisVal.split("/");	                          
                   $("#to").datepicker('option', 'minDate', new Date(new Date(splitDate[2],splitDate[1]-1,splitDate[0]))) ;
                   $("#to").val(thisVal);
		
		}				
	});	
		
 $("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		minDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',
		
	});
});	

jQuery(document).ready(function(){
// binds form submission and fields to the validation engine
jQuery("#reportfrm").validationEngine();
});
function getValidate(){  
	
	var SDate = document.getElementById('from').value;
	var EDate = document.getElementById('to').value;
 
            
	//if(type=='EXCEL'){
		var from = SDate.split('/');
		var to = EDate.split('/');
		
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];

		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		//alert(endDate);
		 if (SDate == '' || EDate == '') {
			alert("Plesae enter both the dates!");
			return false;

		} else if((startDate) > (endDate)){
			alert("Please ensure that the End Date is greater than to the Start Date.");
			
			return false;
		}
	//}
	
	
}
</script>