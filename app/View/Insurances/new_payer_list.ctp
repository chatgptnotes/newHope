<?php echo $this->Html->script(array('pager'));?>
<?php 
$this->Paginator->options(array(
		'update' => '#showList',
		'evalScripts' => true,
		'before' => $this->Js->get('#busy-indicator')->effect(
				'fadeIn',
				array('buffer' => false)
		),
		'url'=>array('controller'=>'Insurances',
				'action'=>'newPayerList'),
		'complete' => $this->Js->get('#busy-indicator')->effect(
				'fadeOut',
				array('buffer' => false)
		),
));
?>
<?php echo $this->Form->create('newPayerList',array('type' => 'file','id'=>'newBatch','inputDefaults' => array(
		'label' => false,'action'=> 'newPayerList',	'div' => false,	'error' => false))); ?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tbody>
<?php if(count($getPayer) > 0) {?>
		<tr class="row_title">
			<td class=" " align="right"><label>&nbsp; </label>
			</td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('Patient Id') ?> </label>
			</td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('Patient Name') ?> </label>
			</td>
			<td  id="boxSpace" align="right" style="padding: 0 0 0 30px;"><label><?php echo __('Patient Age') ?>
			</label></td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('Gender') ?> </label>
			</td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('Payer Name') ?> </label>
			</td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('File Wuth') ?> </label>
			</td>
		</tr>
		<?php   
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
				,'value'=>$patients['Patient']['id'].",1500,". $patients['NewInsurance']['tariff_standard_id']
				.",".$patients['Encounter']['id'],'class'=>'getId','id'=>$key,'label'=>false)) ?>
		</label>
		</td>
		<td id="boxSpace" align="right" style=" padding: 0 0 0 24px;"><label id=<?php echo "id$key";?>><?php echo $patients['Patient']['patient_id']; ?>
		</label>
		</td>
		<td id="boxSpace" style="padding:0px;"><label><?php echo $patients['Patient']['lookup_name'];  ?>
		</label>
		</td>
		<td id="boxSpace" style="text-align:center; padding:0 84px 0 0;"><label><?php echo $patients['Patient']['age']; ?>
		</label></td>
		<td class=" " id="boxSpace" style="padding: 0 0 0 74px;"><label><?php if(strtolower($patients['Patient']['sex'])=='male'){
			echo $this->Html->image('/img/icons/male.png');
		}else if(strtolower($patients['Patient']['sex'])=='female'){
																			echo $this->Html->image('/img/icons/female.png');
																		}  	?> </label>
		</td>
		<td class=" " id="boxSpace" style="padding: 0 0 0 10px;"><label><?php if(empty($patients['NewInsurance']['tariff_standard_name']))echo __('Not Define');else echo $patients['NewInsurance']['tariff_standard_name'];  ?>
		</label>
		</td>
		<td class=" " id="boxSpace" style="padding: 0 0 0 20px;"><label><?php if(empty($patients['Encounter']['file_with']))echo __('Not Define');else echo $patients['Encounter']['file_with'];  ?>
		</label>
		</td>
		<?php }?>
		<table width="100%">
	<tr>
		<td align='center'><?php
		echo $this->Paginator->prev('<< ' . __('Previous '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | '));
		echo $this->Paginator->next(__(' Next') . ' >>', array(), null, array('class' => 'next disabled'));
		echo $this->Js->writeBuffer();
		?>
		</td>
	</tr>
</table>
		<tr>
			<td class=" " align="center" style="padding: 30px 0 0;"><?php
			echo $this->Form->submit(__('Create Batch'),array('class'=>'blueBtn','id'=>'Cbatch','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
<?php }else{?>
<tr>
			<td class=" " align="center"><?php
			echo __('No Record Found');
			?>
			</td>
		</tr>
<?php }?>
		
	</tbody>
</table>
<?php echo $this->Form->end();?>