<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Surgical Site Infections', true); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Add Surgical Site Infections', true),array('action' => 'add_ssi', $patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'),array('controller'=>'HospitalAcquireInfections','action'=>'index',$patient['Patient']['id']),array('escape' => false,'class'=>'blueBtn')) ;?></span>
</div>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<div class="clr"></div>
<div
	style="text-align: right;" class="clr inner_title"></div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">

	<tr class="row_title">
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('SurgicalSiteInfection.operation_type', __('Operation Type', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('SurgicalSiteInfection.wound_location', __('Wound Location', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('SurgicalSiteInfection.wound_type', __('Wound Type', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $ssi):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format"><?php echo $ssi['PatientInitial']['name'].' '.$ssi['Patient']['lookup_name']; ?>
		</td>
		<td class="row_format"><?php echo $ssi['SurgicalSiteInfection']['operation_type']; ?>
		</td>
		<td class="row_format"><?php echo $ssi['SurgicalSiteInfection']['wound_location']; ?>
		</td>
		<td class="row_format"><?php echo $ssi['SurgicalSiteInfection']['wound_type']; ?>
		</td>
		<td><?php 
		//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_ssi', $ssi['SurgicalSiteInfection']['id'],$patient['Patient']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print')),'#',
										     array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_ssi',$ssi['SurgicalSiteInfection']['id']))."', '_blank',
										           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'edit_ssi', $ssi['SurgicalSiteInfection']['id'],$patient['Patient']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_ssi', $ssi['SurgicalSiteInfection']['id'],$patient['Patient']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));

   ?></td>
	</tr>
	<?php endforeach;  ?>
	<?php
         } else {
  ?>
	<tr>
		<TD colspan="5" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>

