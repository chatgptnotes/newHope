<style>
.formError .formErrorContent{
width:60px;
}
.row_action img{float:inherit;}
</style>
 <div class="inner_title">
	<h3><?php echo __('Ventilator Check Lists'); ?></h3>
	<span><?php echo $this->Html->link('Back',array("controller" => "nursings", "action" => "patient_information",$patient['Patient']['id']),array('class'=>'blueBtn'));?></span>
 </div>

<div class="clr ht5"></div>
<?php //echo "<pre>"; print_r($patient);?>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="98%" border="0" cellspacing="1" cellpadding="0"  style="margin:5px 10px">
 <tr >
 <td colspan="4" width="70%">&nbsp;&nbsp;</td><?php if(!empty($patient['VentilatorCheckList'])){?>
 <td  align="right"><?php echo $this->Html->link('Add Ventilator Check List',array("controller" => "nursings", "action" => "ventilator_nurse_checklist",$patient['Patient']['id']),array('class'=>'blueBtn')); ?></td>
 <?php }else{ echo "<td  align='right' colspan='2'>&nbsp;</td>";} ?>
 </tr>
 </table>
 <div class="clr ht5"></div>
   <table width="98%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" style="margin:5px 10px">
                      <tr>
                      		<th class="table_cell"  align="left">Date</th>

							 <th width=""  align="left">Action</th>
                      </tr>

	<?php
	if(count($patient['VentilatorNurseCheckList'])>0){
	foreach($patient['VentilatorNurseCheckList'] as $value){

	?>
                      <tr>
                      		<td  align="left">
                              <?php
								echo $this->DateFormat->formatDate2local($value['create_time'],Configure::read('date_format_us'),true);
							  ?>
                            </td>


								<td align="left" class="row_action">

							  <?php
							   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Ventilator Order Detail', true),'title' => __('Edit Ventilator Check List', true))),array('action' => 'ventilator_nurse_checklist',$patient['Patient']['id'],$value['id'],$value['ventilator_check_list_id'] ), array('escape' => false));
							   ?> &nbsp;
							  
                            <?php
							 echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true),'title' => __('Delete', true))), array('action' => 'delete_nurse_check_list', $patient['Patient']['id'],$value['id']), array('escape' => false),__('Are you sure?', true));
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
