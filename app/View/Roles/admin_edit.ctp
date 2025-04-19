
<?php 
     echo $this->Html->css('validationEngine.jquery'); 
   //  echo $this->Html->script('jquery-1.5.1.min');
     echo $this->Html->script('jquery.validationEngine');
     echo $this->Html->script('/js/languages/jquery.validationEngine-en');  
?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#rolefrm").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Edit Role', true); ?></h3>

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
<?php } ?>
<form name="rolefrm" class="table_format" id="rolefrm" action="<?php echo $this->Html->url(array("controller" => "roles", "action" => "edit", "admin" => true)); ?>" method="post" >
	
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">

	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Role Name'); ?><font color="red">*</font>
	</td>
	<td>
		 <?php 
     	   echo $this->Form->input('Role.id', array( 'id' => 'roleid', 'label'=> false, 'div' => false, 'error' => false));
        
        echo $this->Form->input('Role.name', array('class' => 'validate[required,custom[rolename]]', 'id' => 'rolename', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	<tr>
		<td class="form_lables" align="right"><?php echo __('Code Name'); ?></td>
		<td><?php echo $this->Form->input('Role.code_name', array(
			 'id' =>'codeName', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 147px','readonly'=>'readonly'));?>
			<i>(For configuration purpose only)</i>
		</td>
	</tr>
	<tr>
		<td class="form_lables" align="right">
		<?php echo __('Has Speciality '); ?><font color="red">*</font>
		</td>
		<td>
	        <?php 
	        echo $this->Form->input('Role.hasspecility', array('class' => '','options' => array('0'=>'No','1'=>'Yes'),'empty'=>__('Please select'), 'id' => 'hasspecility', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
 <!--    <tr>
		<td class="form_lables" align="right">
		<?php echo __('Location'); ?><font color="red">*</font>
		</td>
		<td>
	        <?php 
	        echo $this->Form->input('Role.location_id', array('class' => 'validate[required,custom[mandatory-select]]','options' => $location,'empty'=>__('Please select'), 'id' => 'location_id', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr> -->
	  <tr>
		<td class="form_lables" align="right">
		<?php echo __('Default Location '); ?>
		</td>
		<td>
	        <?php 
	        echo $this->Form->input('Role.store_location_id', array('class' => '','options'=>array($StoreLocation),'empty'=>__('Please select'), 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" align="right">
		<?php echo __('Changable Roles'); ?>
		</td>
		<td>
	        <?php 
	        echo $this->Form->input('Role.accessable_role', array('multiple'=>true,'options'=>array($roles),'empty'=>__('Please select'), 'id' => 'accessableRole', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel'), array("action" => "index", "admin" => true), array('escape' => false,'class'=>'grayBtn'));
	?>
	<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>

<script>
	/*$(document).ready(function(){
		//$("#accessLoc").hide();
    	$('#location_id').change(function(){
			//$("#accessLoc").show();
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" =>'roles', "action" => "getChangableRoles", "admin" => true)); ?>"+"/"+$('#location_id').val(),
				  context: document.body,				  		  
				  success: function(data){
				  			data= $.parseJSON(data);
				  			$("#accessableRole option").remove();
							$.each(data, function(val, text) {
							    $("#accessableRole").append( "<option value='"+val+"'>"+text+"</option>" );
							});
									
				  }
			});			
			
		});
	});*/
	</script>