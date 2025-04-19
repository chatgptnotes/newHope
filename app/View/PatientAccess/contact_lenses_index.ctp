<?php if($_SESSION['roleid'] == '45'){?>
<?php //echo $this->element('portal_header');?>
<!--  <div align="right" > <a href="#" id="change_login_date"><?php echo __("Change Login Date");?></a></div>-->
<?php }?>
<div class="inner_title" >
	<h3><?php echo __('Contact Lenses'); ?></h3>
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