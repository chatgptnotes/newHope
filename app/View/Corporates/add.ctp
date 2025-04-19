<div class="inner_title">
 <h3><?php echo __('Add Corporate', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#corporatefrm").validationEngine();
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
<form name="corporatefrm" id="corporatefrm" action="<?php echo $this->Html->url(array("action" => "add")); ?>" method="post" onSubmit="return Validate(this);" >
        <?php echo $this->Form->input('Corporate.credit_type_id', array('type' => 'hidden', 'value' => 1)); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Corporate Location',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('Corporate.corporate_location_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $corporatelocation, 'empty' => 'Select Corporate Location', 'id' => 'corporatelocation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
         <tr>
	  <td class="form_lables" align="right">
	   <?php echo __('Corporate Name',true); ?><font color="red">*</font>
	  </td>
	  <td>
	   <?php 
	          echo $this->Form->input('Corporate.name', array('class' => 'validate[required,custom[name]]','id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
 	 <tr>
	  <td class="form_lables" align="right">
           <?php echo __('Description',true); ?>
	   <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Corporate.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'customdescription', 'label'=> false, 'div' => false, 'error' => false));
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