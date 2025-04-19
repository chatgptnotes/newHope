<style>
.tddate img{float:inherit;}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Medication Administered Report', true); ?>
	</h3>
</div>
<?php echo $this->Form->create('Nursings',array('action'=>'medication_record/'.$patient_id,'type'=>'post')); ?>
<table border="0" cellpadding="0" cellspacing="0" width="50%"
	align="left">

	<tr>

		<td width="23%" class="tdLabel"><?php echo __('Medication Date') ?> :</td>

		<td width="20%" align="left" class="tddate" style="padding-top:8px;" ><?php 
		echo  $this->Form->input('Nursing.search_date', array( 'id' => 'search_date', 'label'=> false,'readonly'=>'readonly', 'div' => false, 'error' => false,'autocomplete'=>false,));
		?>
		</td><td></td>
	</tr>

	<tr>
		<td width="20%" class="tdLabel"><?php echo __('User Name') ?> :</td>

		<td width="91%" class="row_format"><select
			name="data[Nursing][user]">
				<option value="">Select User</option>
				<?php
				foreach($users as $key => $value){
				?>
				<option value="<?php echo $value['User']['id'];?>"
				<?php if(isset($user) && $user[$model]['id']==$value[$model]['id']){ echo " selected=selected";}?>>
					<?php echo $value['User']['first_name']." ".$value['User']['middle_name']." ".$value['User']['last_name'];?>
					(
					<?php echo $value['Role']['name'];?>
					)
				</option>
				<?php
					}
					?>
		</select>
		</td>
	</tr>
	<tr>
		<td class="row_format" align="right" colspan="2"> <a  class="grayBtn" href="javascript:history.back();">Cancel</a> <?php
		echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));
		?> <?php
		//echo $this->Html->link(__('Cancel'), array('action' => 'patient_information',$patient_id), array('escape' => false,'class'=>'blueBtn'));
		?>
		 
		</td>

	</tr>

</table>
<?php echo $this->Form->end();

?>

<table border="0" class="table_format" width="100%">
	<?php if(isset($username)){ ?>
	<tr>
		<td class="row_format" colspan=""><strong> <?php echo __('Medicine Administered By ',true); echo $username['User']['first_name']." ".$username['User']['last_name']." (".$username['User']['username'].")"; ?>
		</strong>
		</td>
	</tr>
	<?php } ?>
	<tr>

		<td width="100%" valign="top" align="left" colspan="6">
<?php if(isset($patientMedicat) && !empty($patientMedicat)){ ?>
			<table width="100%" border="0" cellspacing="1" cellpadding="0"
				id='DrugGroup' class="tabularForm">
				<tr>
					<td width="27%" height="20" align="left" valign="top"><b>Name of
							Medication</b></td>
					<td width="7%" align="left" valign="top"><b>Routes</b></td>
					<td width="8%" align="left" valign="top"><b>Frequency</b></td>
					<td width="8%" align="left" valign="top"><b>Dose</b></td>
					<td width="9%" align="left" valign="top"><b>Administered Date/Time</b>
					</td>

				</tr>
				
				<tr>
					<?php  
					//$last_key = key(array_slice($patientMedicat[0],-1,1,true));
					$i=0;
					foreach($patientMedicat as $Medicat) {
					$last_key = key(array_slice($Medicat,-1,1,true));

					$counter=0;
					foreach($Medicat as $Medicat) {
								if($counter == $last_key){
									echo "<td>".$reportData[$i]['PrescriptionRecord']['create_time']."</td>";
									$i++;
									}
									if(!empty($Medicat)){
									if($counter%4==0 )
										echo "</tr ><tr>";
									?>

					<td><?php echo $Medicat;  ?></td>

					<?php }


					$counter++;


				}

				echo "</tr >";
} ?>
			
			</table>
			<?php  	}else{?>
				<tr>
					<td align="center" colspan='5' border='none'>No Data Recorded
				
				</tr>
				<?php  }?>

		</td>
		
	</tr>




</table>


<?php ?>

<script>

$("#search_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>'
});
</script>
