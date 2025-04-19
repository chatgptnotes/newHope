<style>
.formError .formErrorContent {
	width: 60px;
}
.row_action img{float:inherit;}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('I.V.F. List'); ?>
	</h3>
	<span><?php
	echo $this->Html->link(__('Add I.V.F. Details'),array("controller" => "nursings", "action" => "patient_ivf",$patient['Patient']['id']),array('escape' => false,'class'=>'blueBtn')) ;
	echo $this->Html->link(__('Back'), array('action' => 'patient_information',$patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" style="margin: 5px 10px">
	<tr>
		<th class="table_cell" align="left">Date</th>

		<th width="" align="left">Action</th>
	</tr>

	<?php
	if(count($patient['PatientIvf'])>0){
	foreach($patient['PatientIvf'] as $value){

	?>
	<tr>
		<td><?php
		//echo $value['transfusion_date'];
		echo $this->DateFormat->formatDate2local($value['date'],Configure::read('date_format'),false);
		?>
		</td>


		<td align="left" class="row_action"><?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit I.V.F.', true),'title' => __('Edit I.V.F.', true))),array('action' => 'patient_ivf',$patient['Patient']['id'],$value['id'] ), array('escape' => false));
		?> &nbsp; <?php
		echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('PrintI.V.F. Detail', true),'title' => __('Print I.V.F.', true))),array('action' => 'patient_ivf',$patient['Patient']['id'],$value['id'],true ), array('escape' => false,'target' => '_blank'));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true),'title' => __('Delete', true))), array('action' => 'delete_record_form', $patient['Patient']['id'],"ivf",$value['id']), array('escape' => false),__('Are you sure?', true));
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
