<div class="inner_title">
	<h3><?php echo __('Order Eyeglasses'); ?></h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"users","action"=>"common"),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>

<?php  echo $this->Form->create('',array('url'=>array('controller'=>'PatientAccess','action'=>'order_eyeglasses',$patient_id),'id'=>'','enctype' => 'multipart/form-data'));?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
 <tr>
                        <td width="100" valign="middle" class="tdLabel" id="boxSpace"><?php  echo $this->Html->link('Link for purchase','http://www.lens.com/?gclid=CNqKqcKW_rwCFYt9OgodcV0AXw',array('target'=>'_blank','escape'=>false,'style'=>'text-decoration:underline')); ?>
                        </td>
                        </tr>
		           	  <tr>
                        <td width="100" valign="middle" class="tdLabel" id="boxSpace">Name of vendor<font color="red"></font></td>
                        <td width="250"><?php echo $this->Form->input('vendor_name', array('label'=>false,'id' => 'vendor_name','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?></td>
                        <td></td>
                        </tr>
                       <tr>
                        <td width="100" class="tdLabel" id="boxSpace">Contact details<font color="red"></font></td>
                        <td width="250"><?php echo $this->Form->input('contact_details', array('label'=>false,'id' => 'contact_details','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
                        </td>
                        <td></td>
                      </tr>
                       <tr>
                       <td>&nbsp;</td>
                        <td class="tdLabel" id="boxSpace" style="float:right;">
                      <?php echo $this->Form->submit(__('Submit'), array('escape' => false,'class'=>'blueBtn','id'=>'submit'));?>
                       
					  </td>
  					</tr>
</table>
 <?php echo $this->Form->end();?>
