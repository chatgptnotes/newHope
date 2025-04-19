
<style>
.formError .formErrorContent {
	width: 60px;
}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Hippa Consent List'); ?>
	</h3>

	<span><?php 
	echo $this->Html->Link(__('Add Hippa Consent'),array('controller'=>'nursings','action'=>'hippa_consent',$patient_id),array('class'=>'blueBtn'));
	//echo $this->Html->link(__('Back'),array('action'=>'patient_information',$patient['Patient']['id']),array('escape' => false,'class'=>'blueBtn')) ;?>
	</span>
</div>


<div class="clr ht5"></div>
<?php //echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" style="margin: 5px 10px">
	<tr>
		<th width="190">Date</th>

		<th width="" style="text-align: left;">Action</th>
	</tr>

	<?php 
	if(count($patient['HippaConsent'])>0){
	foreach($patient['HippaConsent'] as $value){

	?>
	<tr>
		<td><?php
		echo $this->DateFormat->formatDate2local($value['create_time'],Configure::read('date_format'),true);
		//echo $this->DateFormat->formatDate2local($value['HippaConsent']['create_time'],Configure::read('date_format'),true);
		?>
		</td>


		<td align="center"><?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Hippa Consent Detail', true),'title' => __('Edit Hippa Consent Detail', true))),array('action' => 'hippa_consent',$patient['Patient']['id'],$value['id'] ), array('escape' => false));
		?> &nbsp; <?php
		echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Hippa Consent Detail', true),'title' => __('Print Hippa Consent Detail', true))),array('action' => 'hippa_consent',$patient['Patient']['id'],$value['id'],true ), array('escape' => false,'target' => '_blank'));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true),'title' => __('Delete', true))), array('action' => 'delete_record_form', $value['patient_id'],"hippa_consent",$value['id']), array('escape' => false),__('Are you sure?', true));
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
