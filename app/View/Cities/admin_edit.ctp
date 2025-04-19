<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#cityfrm").validationEngine();
	});
	
	
</script>
<div class="inner_title">
<h3><?php echo __('Edit City', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="47%"  align="center">
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

<?php 
		echo $this->Form->create('cities',array('controller'=>$this->params['controller'],'action'=>'edit','id'=>'cityfrm','inputDefaults' => array(
												'label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));
		   echo $this->Form->input('City.id', array( 'id' => 'cityid', 'label'=> false, 'div' => false, 'error' => false)); 
			?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="47%"  align="center">
	
		<tr>
		<td width="5%" class="form_lables">
		<?php echo __('Country'); ?><font color="red">*</font>
		</td>
		<td width="12%" class="form_lables">
	        <?php 
			 echo $this->Form->input('City.country_id', array('default'=>$this->data['Country']['id'],'class' => 'validate[required,custom[customcountry]] textBoxExpnd', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
	        ?>
		</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('States'); ?><font color="red">*</font>
	</td>
	<td id="changeStates">
	<?php 
        
        if(!empty($this->request->data)) {
        	$disabled = 'enabled';
        }else{
        	$disabled = 'enabled';
        }
        echo $this->Form->input('City.state_id', array('options'=>$states,'empty'=>__('Select State'),'class' => 'validate[required,custom[cities_statename]] textBoxExpnd', 'id' => 'cities_statename', 'label'=> false, 'div' => false, 'error' => false ));
        ?>
	
	</td>
	</tr>	 
	<tr>
	<td class="form_lables">
	<?php echo __('City'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('City.name', array('class' => 'validate[required,custom[cityname]] textBoxExpnd', 'id' => 'cityname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>	 
	<tr>
	<td colspan="2" align="right">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>
<script>
	$(document).ready(function(){
		
		$('#countryname').change(function(){
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "getStates", "admin" => true)); ?>"+"/"+$('#countryname').val(),
				  context: document.body,				  		  
				  success: function(data){
				  			data= $.parseJSON(data);
				  			$("#cities_statename option").remove();
							$.each(data, function(val, text) {
							    $('#cities_statename').append( new Option(text,val) );
							});
											  			
				    		$('#cities_statename').attr('disabled', '');
				  }
			});			
			
		});
		$('#cities_statename').change(function(){
			$('#cityname').attr('disabled', '');
		});
		
	});
</script>