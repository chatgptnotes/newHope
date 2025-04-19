
<style>
.formError .formErrorContent {
	width: 60px;
}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
.row_action img{float:inherit;}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('ICU Consent List'); ?>
	</h3>

	<span> <?php 
	echo $this->Html->Link(__('Add ICU Consent Form'),array('controller'=>'nursings','action'=>'ventilator_consent',$patient['Patient']['id']),array('class'=>'blueBtn'));
	echo $this->Html->link(__('Back'),array('action'=>'patient_information',$patient['Patient']['id']),array('escape' => false,'class'=>'blueBtn')) ;?>
	</span>
</div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" style="margin: 5px 10px">
	<tr>
		<th class="table_cell"  align="left">Date</th>

		<th width=""  align="left">Action</th>
	</tr>

	<?php
	if(count($patient['PatientVentilatorConsent'])>0){
	foreach($patient['PatientVentilatorConsent'] as $value){

	?>
	<tr>
		<td  align="left"><?php
		//echo $value['transfusion_date'];
		echo $this->DateFormat->formatDate2local($value['created_time'],Configure::read('date_format'),true);
		?>
		</td>


		<td align="left" class="row_action"><?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Ventilator Consent Detail', true),'title' => __('Edit Ventilator Consent Detail', true))),array('action' => 'ventilator_consent',$patient['Patient']['id'],$value['id'] ), array('escape' => false));
		?> &nbsp; <?php
		echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Ventilator Consent Detail', true),'title' => __('Print Ventilator Consent Detail', true))),array('action' => 'ventilator_consent',$patient['Patient']['id'],$value['id'],true ), array('escape' => false,'target' => '_blank'));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true),'title' => __('Delete', true))), array('action' => 'delete_record_form', $patient['Patient']['id'],"ventilator_consent",$value['id']), array('escape' => false),__('Are you sure?', true));

		?>
		</td>
	</tr>
	<?php
	}
	}else{?>
	<tr>
		<td align="center" colspan="6">No Data Found.</td>
	</tr>
	<?php }
	?>
</table>
