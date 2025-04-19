<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Prescription List', true); ?>
	</h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
			</div></td>
	</tr>
</table>
<?php } ?>

<p class="ht5"></p>

<?php 
           	echo $this->element('patient_information'); 
           ?>
      <div style="margin-left: 30px;"><h3><?php // echo __('Prescriptions'); ?></h3> </div>     
           <?php if((count($allergiesSpecific))==1) { ?>
<table align="center">
	<tr>
		<td  text-align="center" style="color:red"><?php echo"There are no recorded prescriptions for this patient at this time." ?></td>
	</tr>
</table>
<?php } else{?>
           <?php // echo $this->Html->link(__('Comment'),'#', array('escape' => false,'class'=>'blueBtn', 'id'=>'comment'));?>

	
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	<tr>
		
		<td>
			<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>Sr. #</strong></td>
					<td class="table_cell"><strong>Prescription Id</strong></td>
					<td class="table_cell"><strong>Prescription Name</strong></td>
					<td class="table_cell"><strong>Date Of Perscription</strong></td>
					<td class="table_cell"><strong>Route</strong></td>
					<td class="table_cell"><strong>DosageFrequencyDescription</strong></td>
					<td class="table_cell"><strong>DosageNumberDescription</strong></td>
					<td class="table_cell"><strong>Strength</strong></td>
				</tr>
				<?php
				$count=0; 
				$toggle =0;

				$CountOfPrescriptionRecord=count($allergiesSpecific);

	 							for($counter=0;$counter < $CountOfPrescriptionRecord-1;$counter++){
							
						if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;	 ?>
				
			<tr class="row_gray">
					<td class="row_format">&nbsp;<?php echo $counter+1; ?>
					<td class="row_format">&nbsp;<?php echo $allergiesSpecific[$counter][1]; ?></td>
					<td class="row_format">&nbsp;<?php echo $allergiesSpecific[$counter][0];  ?></td>
					
					<td class="row_format">&nbsp;<?php echo $allergiesSpecific[$counter][2];  ?></td>
					<td class="row_format">&nbsp;<?php echo $allergiesSpecific[$counter][4];  ?></td>
					<td class="row_format">&nbsp;<?php echo $allergiesSpecific[$counter][5];  ?></td>
					<td class="row_format">&nbsp;<?php echo $allergiesSpecific[$counter][6];  ?></td>
					<td class="row_format">&nbsp;<?php echo $allergiesSpecific[$counter][7].$allergiesSpecific[$counter][8];?></td>
				</tr>
				
				<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>
			<?php }} ?>
			</table>
		</td>
	</tr>

</table>
<?php ?>

<script>
	$(document).ready(function(){
		  $("#comment").click(function(){
			 var count=0; 
			$("td span").each(function(){ 
				count++; 
		    $("#cmnt_presc"+count).toggle();
		  });
			  });
		});
</script>
