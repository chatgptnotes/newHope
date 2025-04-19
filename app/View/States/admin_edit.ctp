<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#statefrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Edit State', true); ?></h3>

</div>
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
<form name="statefrm" id="statefrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "edit", "admin" => true)); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	
	<tr>
	<td class="form_lables">
	<?php echo __('Country'); ?><font color="red">*</font>
	</td>
	<td>
        <?php
        echo $this->Form->input('State.id', array( 'id' => 'stateid', 'label'=> false, 'div' => false, 'error' => false)); 
        echo $this->Form->input('State.country_id', array('options'=>$countries,'empty'=>__('Please select'),'class' => 'validate[required,custom[countryname]]', 'id' => 'countryname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>	 
	<tr>
	<td class="form_lables">
	<?php echo __('State'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('State.name', array('class' => 'validate[required,custom[statename]]', 'id' => 'statename', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>	 
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
	<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>