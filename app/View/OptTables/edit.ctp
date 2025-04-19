<div class="inner_title">
 <h3><?php echo __('Edit OR Table', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#opttablefrm").validationEngine();
	});
	
</script>

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
<?php } ?>
<form name="opttablefrm" id="opttablefrm" action="<?php echo $this->Html->url(array("action" => "edit")); ?>" method="post" onSubmit="return Validate(this);">
        <?php
              echo $this->Form->input('OptTable.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
        <tr>
	<td class="form_lables">
	<?php echo __('OR',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('OptTable.opt_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $opt, 'empty' => 'Select OT', 'id' => 'opt', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	  <td class="form_lables">
	   <?php echo __('OR Table Number',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('OptTable.number', array('class' => 'validate[required,custom[number]]','id' => 'customnumber', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
         <tr>
	  <td class="form_lables">
	   <?php echo __('OR Table Name',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('OptTable.name', array('class' => 'validate[required,custom[name]]','id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
 	 <tr>
	  <td class="form_lables">
           <?php echo __('Description',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('OptTable.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'customdescription', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td colspan="2" align="center">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn')); ?>
	 <input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>