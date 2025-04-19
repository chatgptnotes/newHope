<?php  echo $this->Html->script('fckeditor'); ?>

<div class="inner_title">
<h3><?php echo __('Edit Product', true); ?></h3>
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
	<?php echo __('Product Name',true); ?><font color="red">*</font>
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
    	<td class="form_lables" align="right" width="30%"><?php echo __('Header Image'); ?></td>
		<td>
			<?php echo $this->Form->input('Location.header_image', array('type'=>'file','id' => 'hospital_logo', 'label'=> false,
					 	'div' => false, 'error' => false));
			 
				if($this->data['Location']['header_image']){
					echo $this->Html->link($this->Html->image('/uploads/image/'.$this->data['Location']['header_image'],array('width'=>'100','height'=>100)),'/uploads/image/'.$this->data['Location']['header_image'],array('escape'=>false,'target'=>'__blank'));
				}
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
