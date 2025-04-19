<style>
.formError .formErrorContent{
width:60px;
}

</style>
 <div class="inner_title">
	<h3><?php echo __('Ventilator Order List'); ?></h3>
 </div>

<div class="clr ht5"></div>
<?php //echo "<pre>"; print_r($patient);?>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="98%" border="0" cellspacing="1" cellpadding="0"  style="margin:5px 10px">
 <tr >
 <td colspan="4" width="70%">&nbsp;&nbsp;</td>
 <td  align="right"><?php echo $this->Html->link('Add Ventilator Order Set',array("controller" => "nursings", "action" => "ventilator_doctors_form",$patient['Patient']['id']),array('class'=>'blueBtn')); ?></td>
 <td><?php echo $this->Html->link('Back',array("controller" => "patients", "action" => "patient_information",$patient['Patient']['id']),array('class'=>'blueBtn')); ?></td></tr>
 </table>
 <div class="clr ht5"></div>
   <table width="98%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" style="margin:5px 10px">
                      <tr>
                      		<th width="190">Date</th>

							 <th width="" style="text-align:center;">Action</th>
                      </tr>

	<?php
	if(count($patient['VentilatorCheckList'])>0){
	foreach($patient['VentilatorCheckList'] as $value){

	?>
                      <tr>
                      		<td>
                              <?php
								//echo $value['transfusion_date'];
								echo $this->DateFormat->formatDate2local($value['create_time'],Configure::read('date_format_us'),true);
							  ?>
                            </td>


								<td align="center">

							  <?php
							   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Ventilator Order Detail', true),'title' => __('Edit Ventilator Order Detail', true))),array('action' => 'ventilator_doctors_form',$patient['Patient']['id'],$value['id'] ), array('escape' => false));
							   ?> &nbsp;
							  
                            <?php
							 echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true),'title' => __('Delete', true))), array('action' => 'delete_doctors_form', $patient['Patient']['id'],$value['id']), array('escape' => false),__('Are you sure?', true));
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