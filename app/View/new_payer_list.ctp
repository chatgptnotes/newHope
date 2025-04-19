<?php echo $this->Form->create('newBatch',array('type' => 'file','id'=>'newBatch','inputDefaults' => array(
		'label' => false,'action'=> 'newBatch',	'div' => false,	'error' => false))); ?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tbody>

		<tr class="row_title">
			<td class=" " align="right"><label>&nbsp; </label>
			</td>
			<td class=" " align="right"><label><?php echo __('Patient Id') ?> </label>
			</td>
			<td class=" " align="right"><label><?php echo __('Patient Name') ?> </label>
			</td>
			<td class=" " align="right" width=" "><label><?php echo __('Patient Age') ?>
			</label></td>
			<td class=" " align="right"><label><?php echo __('Gender') ?> </label>
			</td>
			<td class=" " align="right"><label><?php echo __('Payer Name') ?> </label>
			</td>
		</tr>
		<?php   if(count($getPayer) > 0) {
			foreach($getPayer as $key=>$patients){

							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }

							       ?>
		<td class=" " align=""><label><?php echo $this->Form->input('',array('type'=>'checkbox','name'=>'checkName[]'
				,'value'=>$patients['NewInsurance']['patient_uid'].",". $patients['Patient']['lookup_name'].",". $patients['Patient']['age']
				.",".$patients['Patient']['sex'].",".$patients['TariffStandard']['name'],'class'=>'getId','id'=>$key,'label'=>false)) ?>
		</label>
		</td>
		<td class=" " align="right"><label id=<?php echo "id$key";?>><?php echo $patients['NewInsurance']['patient_uid']; ?>
		</label>
		</td>
		<td class=" " align="right"><label><?php echo $patients['Patient']['lookup_name'];  ?>
		</label>
		</td>
		<td class=" " align="right" width=" "><label><?php echo $patients['Patient']['age']; ?>
		</label></td>
		<td class=" " align="right"><label><?php if(strtolower($patients['Patient']['sex'])=='male'){
			echo $this->Html->image('/img/icons/male.png');
		}else if(strtolower($patients['Patient']['sex'])=='female'){
																			echo $this->Html->image('/img/icons/female.png');
																		}  	?> </label>
		</td>
		<td class=" " align="right"><label><?php if(empty($patients['TariffStandard']['name']))echo __('Not Define');else echo $patients['TariffStandard']['name'];  ?>
		</label>
		</td>
		<?php }
}?>
		<tr>
			<td class=" " align="center"><?php
			echo $this->Form->submit(__('Create Batch'),array('class'=>'blueBtn','id'=>'Cbatch','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end();?>