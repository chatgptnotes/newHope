<div class="inner_title">
<h3><?php echo __('Edit Manufacturer', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php }   echo $this->Form->create('Location',array("action" => "edit", "admin" => true,'type' => 'file','id'=>'locationfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
        <?php echo $this->Form->input('Location.id', array('type' => 'hidden')); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
	
   
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Manufacturer Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.name', array('class' => 'validate[required,custom[customname]]', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Is Active',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Location.is_active', array('options' => array('0' => 'No','1' => 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false, 'selected' => $this->data['Location']['is_active']));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Phone',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.phone1', array('class' => 'validate[required,custom[customphone1]]', 'id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
        <?php echo __('Address',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Location.address1', array('class' => 'validate[required,custom[customaddress1]]', 'cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td colspan="2" align="center">
        <?php 
    	 
        
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
        ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>
	
	
	
	
	
     