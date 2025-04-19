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
<h3>&nbsp; <?php echo __('Incident Report', true); ?></h3>

</div>
 <?php 
echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'admin_incedence_report')
																	,'id'=>'orderfrm', 
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
						));
?>
 <table align="center">
	
	 
	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL', 'PDF'=>'PDF',)));
	 ?></td>
	 </tr>
	<tr>
	 <td colspan="8" align="right">Year</td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
	   <?php 
			$currentYear = date("Y");
			 for($i=0;$i<=10;$i++) {
				$lastTenYear[$currentYear] = $currentYear;
				$currentYear--;
			 }
	   ?>
		<?php 
			

	        echo $this->Form->input('year', array('options'=>$lastTenYear,'id'=>'year','label'=> false, 'div' => false, 'error' => false));
		?>
	  </td>
	  </tr> 
 </table>
 
	   <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit" >&nbsp;&nbsp;
				<input type="submit" value="Show Graph" class="blueBtn" id="submit1" onclick="changeRequest('<?php echo $this->Html->url(array('action' => 'admin_incedence_chart_report','admin'=>true));?>');">&nbsp;&nbsp;
				 
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
		</div>
		
	 </div> 
 </form>
 <script language="javascript" type="text/javascript">

 function changeRequest(action){
	 $('#orderfrm').attr('action',action);
	 $('#orderfrm').submit;
 }
   /* function getValidate(){  
		
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