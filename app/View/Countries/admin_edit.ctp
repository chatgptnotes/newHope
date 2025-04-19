<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#countryfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Country', true); ?></h3>

</div>
<form name="countryfrm" id="countryfrm" action="<?php echo $this->Html->url(array("controller" => "countries", "action" => "edit", "admin" => true)); ?>" method="post" >
	<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td class="form_lables">
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
         echo $this->Form->input('Country.id', array( 'id' => 'countriesid', 'label'=> false, 'div' => false, 'error' => false));
        echo $this->Form->input('Country.name', array('class' => 'validate[required,custom[countryname]]', 'id' => 'countryname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	 
	 
	<tr>
	<td colspan="2" align="center">
	<?php
		echo $this->Html->link(__('Cancel'),
						 					array('action' => 'index'),array('escape' => false,'class'=>'grayBtn'));
	?>
	<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>