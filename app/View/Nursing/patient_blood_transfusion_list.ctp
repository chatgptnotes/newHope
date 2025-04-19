<style>
.formError .formErrorContent{
width:60px;
}
.row_action img{float:inherit;}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}

</style>
 <div class="inner_title">
	<h3><?php echo __('Blood Transfusion Program List'); ?></h3>
	<span>
	<?php 
	echo $this->Html->link(__('Add Blood Transfusion Details'),array("controller" => "nursings", "action" => "patient_blood_transfusion",$patient['Patient']['id']),array('escape' => false,'class'=>'blueBtn')) ;
	echo $this->Html->link(__('Back'), array('action' => 'patient_information', $patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
 </div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>

<div class="clr ht5"></div>

   <table width="98%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" style="margin:5px 10px">
                      <tr>
                      		<th width="190"  align="left">Transfusion Date</th>
                            <th width="140"  align="left">Blood Group Donor</th>
                            <th width=""  align="left">Expiry Date</th>
							<th width=""  align="left">Time of termination of transfusion</th>
							 <th width=""  align="left">Action</th>
                      </tr>

	<?php
	if(count($patient['PatientBloodTransfusion'])>0){
	foreach($patient['PatientBloodTransfusion'] as $value){

	?>
                      <tr>
                      		<td  align="left">
                              <?php
								//echo $value['transfusion_date'];
								echo $this->DateFormat->formatDate2local($value['transfusion_date'],Configure::read('date_format'),true);
							  ?>
                            </td>
						   <td  align="left">
                              <?php
								echo $value['blood_group_donor'];
							  ?>
                            </td>

						    <td  align="left">
                              <?php
								echo $this->DateFormat->formatDate2local($value['expiry_date'],Configure::read('date_format'),false);
							  ?>
                            </td>
							<td>
                              <?php
								//echo $value['transfusion_date'];
								echo $this->DateFormat->formatDate2local($value['time_termination_of_tranfusion'],Configure::read('date_format'),true);
							  ?>
                            </td>
								<td  class ="row_action" align="left">

							  <?php
							   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Blood Transfusion Detail', true),'title' => __('Edit Blood Transfusion Detail', true))),array('action' => 'patient_blood_transfusion',$patient['Patient']['id'],$value['id'] ), array('escape' => false));
							   ?> &nbsp;
							  <?php
							   echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Blood Transfusion Detail', true),'title' => __('Print Blood Transfusion Detail', true))),array('action' => 'patient_blood_transfusion',$patient['Patient']['id'],$value['id'],true ), array('escape' => false,'target' => '_blank'));
							   ?>
							   <?php
							 echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true),'title' => __('Delete', true))), array('action' => 'delete_record_form', $patient['Patient']['id'],"blood_transfusion",$value['id']), array('escape' => false),__('Are you sure?', true));
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