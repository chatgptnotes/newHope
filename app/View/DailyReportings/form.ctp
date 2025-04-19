<script>
	$(function() {
			
	 $("#date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});

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
<center><h3>&nbsp; <?php echo __('Daily Reporting By CMO', true); ?></h3></center>
</div>
<table align="right">
	<tr>
		<td>Date</td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'date', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
</table>
<table class="table_format"  border="1" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	<tr>
		<th>Sr. No</th>
		<th>Documentation in IPD file</th>
		<th>Status</th>
		<th>Remark</th>
	</tr>
	<tr>
		<td valign="top">1</td>
		<td align="left">MRN notes are complete
			
			<ul>
			  <li>Relative Sign</li>
			  <li>Dr. Sign and Name</li>
			  <li>Plan of care to be completed</li>
			  <li>Patient Sticker</li>
			</ul>
		</td>
		<td valign="middle">
		<?php $options = array('1'=>'YES','2'=>'NO','3'=>'N/A');?>
			<?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?>
		</td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>2</td>
		<td align="left">Treatment Sheet are Completed</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>3</td>
		<td align="left">Observation Chart</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>4</td>
		<td align="left">investigation/Consent</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>5</td>
		<td align="left">Dr. Progress Note(name,time,date)</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>6</td>
		<td align="left">Nurses Note(name,time,date)</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>7</td>
		<td align="left">No Incomplete Fileds in Form</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>8</td>
		<td align="left">List of Critical Patient</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>9</td>
		<td align="left">List of patient not attaended by treating(main) consultant</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
	<tr>
		<td>10</td>
		<td  align="left">Any Issue in Pharmacy and Lab</td>
		<td><?php echo $this->Form->input('LaundryItem.harm', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$options));?></td>
		<td><?php echo $this->Form->input('LaundryItem.age', array('id' => 'name', 'label'=> false, 'div' => false, 'error' => false, ));?></td>
	</tr>
 </table>
 </br></br></br>
 <table align="left">
	<tr>
		<td valign="top">Directors Remark</td>
		<td valign="top">:</td>
		<td><textarea rows="4" cols="4"></textarea></td>
	</tr>
</table>
	
