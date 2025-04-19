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
				//foramtEnddate(); //is not defined hence commented
			}			
		});	
			
	 $("#to").datepicker({
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
				//foramtEnddate(); //is not defined hence commented
			}			
		});
	});	

	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	});
</script>

<?php 
//pr($data);exit;
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Laundry Items Management - Report', true); ?></h3>
<span> <a class="blueBtn" href="#" onclick="Javascript:history.back();"><?php echo __('Back'); ?></a></span>
</div>
 <form name="itemfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "inventory_laundry_report/", )); ?>" method="post" >
 <table align="center">
 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('LaundryReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	 <tr>
		 <td colspan="8" align="right">From<font color="red">*</font></td>
		 <td><b>:</b></td>
		  <td colspan="8" align="left">
			<?php 
			echo $this->Form->input('LaundryReport.from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly'));?>
			
		  </td>
		  </tr>
		<tr>
		   <td colspan="8" align="right">To<font color="red">*</font></td>
		   <td><b>:</b></td>
		   <td colspan="8" align="left">
			<?php 
			echo $this->Form->input('LaundryReport.to', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'to','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly'));?>
			
		  </td>
		   
	  </tr>
	<tr>
		<td colspan="8" align="right">&nbsp;&nbsp;Room</td>
		<td><b>:</b></td>
		<td colspan="8" align="left"><?php
		
		echo $this->Form->input('LaundryReport.ward_id', array('options'=>$wards,'empty'=>'All','label'=> false, 'div' => false, 'error' => false));
	 ?></td>
	</tr>
	<tr>
	 <td colspan="8" align="right">Type</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('LaundryReport.type', array('id' => 'itemtype', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Both','options'=>array('In Linen'=>'In Linen','Out Linen'=>'Out Linen')));
	 ?></td>
	 </tr>
	 
	
 </table>
 
	   <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit">&nbsp;&nbsp;
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'manager','inventory'=>true), array('escape' => false,'class'=>'grayBtn'));?>
		</div>
		
	 </div>

 </form>

<script>
// On submit get validate the inputs	
	$(document).ready(function(){
	 $("#submit").click(function() {
		return getValidate();
	 });

	})
	
	   $( "#reportfrm" ).click(function(){
           var fromdate_split = $( "#from" ).val().split("/");
           var todate_split = $( "#to" ).val().split("/");
var fromdate = new Date(fromdate_split[2], fromdate_split[1], fromdate_split[0]);
           var todate = new Date(todate_split[2], todate_split[1], todate_split[0]);
           if(fromdate > todate) {
            alert("To date should be greater than from date");
            return false;
           }
           
});	
	  
	
	/*function getValidate(){

		var SDate = document.getElementById('from').value.split('-');
		var EDate = document.getElementById('to').value.split('-');    

		if (SDate == '' || EDate == '') {
		  alert("Plesae enter dates!");
		  return false;
		}

		
		var endDate = Date.parse(EDate);
		var startDate = Date.parse(SDate);
		
		if(startDate > endDate)
		{
			alert("Please ensure that the 'FROM' Date is greater than or equal to the 'TO' Date.");
			//theForm.txtEnd.focus();
			return false;
		}
		
	}*/
</script>

