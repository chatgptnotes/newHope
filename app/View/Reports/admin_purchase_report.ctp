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
<h3>&nbsp; <?php echo __('Pharmacy Purchase Report', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_purchase_report/", )); ?>" method="post" >
 <table align="center"> 
 
	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PharmacyPurchase.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	<tr>
	 <td colspan="8" align="right">From<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PharmacyPurchase.from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr>
	   <td colspan="8" align="right">To<font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PharmacyPurchase.to', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	   
  </tr>
  <tr>
	   <td colspan="8" align="right">Report For</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PharmacyPurchase.for', array('id'=>'for','label'=> false, 'div' => false, 'error' => false,"options"=>array("Purchase"=>"Purchase","Return"=>"Return")));?>
		
	  </td>
	   
  </tr>
  <tr id="paymenttype">
	 <td colspan="8" align="right"><?php echo __('Payment Type'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
             echo $this->Form->input('PharmacyPurchase.payment_type', array('id'=>'payment_type','label'=> false, 'div' => false, 'error' => false, 'options'=>array('cash'=>'Cash','credit'=>'Credit','all'=>'All')));
          ?>
	 </td>
	</tr>
 
 </table>
 <div class="clr ht5"></div>
 
   <p class="ht5"></p>
   <div align="center">
  
	<div class="btns" style="float:none">
			<input type="submit" value="Get Report" class="blueBtn" id="submit" onclick = "return getValidate();">
                        &nbsp;&nbsp;
                         
			<a  class="grayBtn" href="javascript:history.back();">Cancel</a>  
	</div>
	
 </div>

 </form>
 <script>
 jQuery(document).ready(function(){
     $("#for").change(function(){
	  	if($("#for").val() ==  'Return'){
			$('#paymenttype').hide();
		} else {
			$('#paymenttype').show();
		}
	  });
	});
/* $( "#reportfrm" ).click(function(){
	 var fromdate = new Date($( '#from' ).val());
     var todate = new Date($( '#to' ).val());
     if(fromdate.getTime() > todate.getTime()) {
     // alert("To date should be greater than from date");
      return false;
     }
     
});	*/
  function getValidate(){  
		
		var SDate = document.getElementById('from').value; 
		var EDate = document.getElementById('to').value;
	 
                
		//if(type=='EXCEL'){
			var from = SDate.split('-');
			var to = EDate.split('-');
			
			var fromDate = from[1]+'/'+from[0]+'/'+from[2];
			var toDate = to[1]+'/'+to[0]+'/'+to[2];
			
			var startDate = new Date(fromDate);
			var endDate = new Date(toDate);
			
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