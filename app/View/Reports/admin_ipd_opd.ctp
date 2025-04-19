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
 <h3>&nbsp; <?php echo __('Time Taken For Check-in', true); ?></h3>
</div>
 
<form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "ipd_opd", )); ?>" method="post" >
 <table align="center">
	 
	 <tr>
		 <td colspan="8" align="right">Format</td>
		 <td><b>:</b></td>
		 <td colspan="8" align="left"><?php
			echo $this->Form->input('format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
		 ?></td>
	 </tr>
	 <tr id="year" style="display:none">
		 <td colspan="8" align="right">From<font color="red">*</font></td>
		 <td><b>:</b></td>
		  <td colspan="8" align="left">
			<?php 
				for($i=2012;$i<=$endyear;$i++){
					$years[$i]= $i	;
				}
	
		        echo $this->Form->input('year', array('options'=>$years,'id'=>'year','label'=> false, 'div' => false, 'error' => false));
			?>
		  </td>
	  </tr> 
	<tr id="fromDate">
	 <td colspan="8" align="right"><?php echo __('From'); ?><font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left" style="width: 215px;" >
		<?php 
        echo $this->Form->input('PatientAdmissionReport.from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr id="toDate">
	   <td colspan="8" align="right"><?php echo __('To'); ?><font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.to', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	   
	</tr>
  	<tr>
	   <td colspan="8" align="right">Patient Type</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('type', array('id'=>'type','label'=> false, 'div' => false, 'error' => false,'empty'=>'All','options'=>array('IPD'=>'IPD','OPD'=>'OPD')));?>
		
	  </td>
	   
  </tr>
 
 </table>
 
	   <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input id="get-report" type="submit" value="Get Report" class="blueBtn"   onclick = "return getValidate();">&nbsp;&nbsp;
				<input style="display:none;" id="show-chart" type="submit" value="Show Graph" class="blueBtn"  >&nbsp;&nbsp;
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
		</div>
		
	 </div>

 </form>
 <script language="javascript" type="text/javascript">

 	$(document).ready(function(){
		$('#formattype').change(function(){
			if($(this).val()=='GRAPH'){
				$('#to').fadeOut('fast');
				$('#from').fadeOut('fast');
				$('#get-report').fadeOut('fast');
				$('#show-chart').fadeIn('slow');
				$('#year').fadeIn('slow');
				$('#show-chart').fadeIn('slow');
			}else{
				$('#to').fadeIn('slow');
				$('#from').fadeIn('slow');
				$('#get-report').fadeIn('slow');
				$('#show-chart').fadeOut('fast');
				$('#year').fadeOut('fast');
				$('#show-chart').fadeOut('fast');
			}
		});
 	});
    $( "#reportfrm" ).click(function(){
        var fromdate = new Date($( '#from' ).val());
        var todate = new Date($( '#to' ).val());
        if(fromdate.getTime() > todate.getTime()) {
         alert("To date should be greater than from date");
         return false;
        }
        
});	
  /*  function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;
		
		var from = SDate.split('-');
		var to = EDate.split('-');
		
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];

		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		//alert(endDate);
		
		 if (SDate == '' || EDate == '') {
			alert("Plesae enter both the dates!");
			return false;


		} else if((startDate) > (endDate)){
			alert("Please ensure that the To Date is greater than to the From Date.");
			
			return false;
		}
		
		
	}*/
	

	</script> 