<div class="inner_title">
<h3><?php echo __('Add Chamber', true); ?></h3>
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
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#Chamberfrm").validationEngine();
	});
	
</script>

 
<?php echo $this->Form->create('Chamber',array('controller'=>'Chamber','action'=>'add','id'=>'Chamberfrm','admin'=>true));?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td colspan="2" align="center">
		<br>
		</td>
	</tr>  
	  
	<tr>
	<td class="form_lables">
	<?php echo __('Chamber'); ?><font color="red">*</font>
	</td>
	<td>
        <?php
        	echo $this->Form->hidden('id'); 
        	echo $this->Form->input('Chamber.name', array('class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'Chambername', 'label'=> false, 'div' => false, 'error' => false)  );
        ?>
	</td>
	</tr>	 
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<!-- <script>
	$(document).ready(function(){
		
		$('#countryname').change(function(){
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "getStates", "admin" => true)); ?>"+"/"+$('#countryname').val(),
				  context: document.body,				  		  
				  success: function(data){
				  			data= $.parseJSON(data);
				  			$("#cities_statename option").remove();
							$.each(data, function(val, text) {
							    $("#cities_statename").append( "<option value='"+val+"'>"+text+"</option>" );
							});
											  			
				    		$('#cities_statename').attr('disabled', '');
				  }
			});			
			
		});
		$('#cities_statename').change(function(){
			$('#Chambername').attr('disabled', '');
		});
		
	});
</script>
 -->