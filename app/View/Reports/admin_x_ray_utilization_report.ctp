
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
<h3>&nbsp; <?php echo __('OT Utilization Rate Report', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_x_ray_utilization_report", )); ?>" method="post" >
 <table align="center">
	
	
	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PatientOtReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'checkFormat(this.value);','options'=>array('PDF'=>'PDF','EXCEL'=>'EXCEL','GRAPH'=>'GRAPH')));
	 ?></td>
	 </tr>
	  <td colspan="8" align="right">Year</td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
	  <?php
	  $years = range (date("Y"), 2000);
		echo '<select name="year">';
		foreach ($years as $value) {
		echo "<option value=\"$value\">$value</option>\n";
		}
		echo '</select>';
		
		?>
	  </td>
	 </tr>
	 <tr id="fromDate">
	 <td colspan="8" align="right">From Month<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td> <select name="fromMonth">
	   	<option value="1">January</option>
	   	<option value="2">February</option>
		<option value="3">March</option>
		<option value="4">April</option>
		<option value="5">May</option>
		<option value="6">June</option>
		<option value="7">July</option>
		<option value="8">August</option>
		<option value="9">September</option>
		<option value="10">Octomber</option>
		<option value="11">November</option>
		<option value="12">December</option>
			   
	   </select>
	    </td>
	  </tr>
	

	<tr >
	 <td colspan="8" align="right">To Month<font color="red">*</font></td>
	 <td><b>:</b></td>
	
	   <td> <select name="toMonth">
	   	<option value="1">January</option>
	   	<option value="2">February</option>
		<option value="3">March</option>
		<option value="4">April</option>
		<option value="5">May</option>
		<option value="6">June</option>
		<option value="7">July</option>
		<option value="8">August</option>
		<option value="9">September</option>
		<option value="10">Octomber</option>
		<option value="11">November</option>
		<option value="12" selected="selected">December</option>
			   
	   </select>
	    </td>
	</tr>



 </table>
 
	   <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit" onClick="return getValidate();">&nbsp;&nbsp;
				
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
		</div>
		
	 </div>

 </form>
