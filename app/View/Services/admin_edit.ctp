<div class="inner_title">
<h3>&nbsp; <?php echo __('Edit Service', true); ?></h3>
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
		jQuery("#servicefrm").validationEngine();
	});
	
</script>

<form name="servicefrm" id="servicefrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "edit", "admin" => true)); ?>" method="post" >
	<?php echo $this->Form->hidden('Service.id');?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
		<td width="250" class="form_lables" valign="middle">
		<?php echo __('Corporate Company'); ?> 
		</td>
		<td> 
	         
	        <font color="red"> *</font> <?php echo $this->Form->input('Service.corporate_id', array('div' => false,'label' => false,'empty'=>__('Please select'),'options'=>$corporates,'class' => 'validate[required,custom[mandatory-select]] textBox','id' => 'corporate_id')); ?>
	        
		</td>
	</tr>
	<tr>
		<td class="form_lables" valign="top">
		<?php echo __('Service'); ?>
		</td>
		<td ><font color="red">*</font>
	        <?php 
	        	echo $this->Form->input('Service.name', array('class' => 'validate[required,custom[name]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
	<tr>
		
			<td class="form_lables" valign="top">
			<?php echo __('Sub Service'); ?>/<?php echo __('Cost'); ?>
			</td>
			<td>
				<table>
					<tr>
						<td>
							<div id='TextBoxesGroup'>
								<?php 
							 		$count = count($services) ;
							 		 
									for($i=0;$i<$count;){
								?>
									<div id="TextBoxDiv<?php echo $i ;?>"><font color="red">*</font>
											<?php 
						        					echo $this->Form->input('', array('value'=>$services[$i]['SubService']['service'],'name'=>"data[SubService][sub_service][$i]",'class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'sub_service', 'label'=> false, 'div' => false, 'error' => false));
						        			?>
						        	</div>
					        	<?php
					        		 $i++ ;					        		
					        	 } 
					        	 ?>
					        </div>
						 </td>
						 <td>
							<div id='CostGroup'>
								<?php 
							 		$count = count($services) ;
									for($j=0;$j<$count;){
								?>
								<div id="CostDiv<?php echo $j ;?>"><font color="red">*</font>			 
							        <?php 
							        	echo $this->Form->input('', array('value'=>$services[$j]['SubService']['cost'],'name'=>"data[SubService][cost][$j]",'class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'cost', 'label'=> false, 'div' => false, 'error' => false ));
							        ?>
							    </div>
							    <?php 
							    	$j++ ;
							    	} 
							    ?>
							 </div>
						</td>
					</tr>
					<tr>
						
						<td>
							<input type="button" id="addButton" value="Add more" class="blueBtn"> 
						 	<input type="button" id="removeButton" value="Remove" style="display:none;" class="blueBtn">
						 </td>
						 <td class="form_lables">&nbsp;</td>
					</tr>	
				</table>
			</td>
		
	</tr>	 
	<tr>
	<td class="form_lables">
	<?php echo __('Description'); ?> 
	</td>
	<td>
        <?php 
        echo $this->Form->input('Service.description', array('id' => 'services_desc', 'label'=> false, 'div' => false, 'error' => false)  );
        ?>
	</td>
	</tr>	 
	<tr>
	<td colspan="2" align="center">
	<?php 
		echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class'=>"blueBtn"));
	?>
		&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
		$(document).ready(function(){
	 
		    var counter = "<?php echo $count ; ?>";
		 
		    $("#addButton").click(function () {		 
				  			 
				var newTextBoxDiv = $(document.createElement('div'))
				     .attr("id", 'TextBoxDiv' + counter);
			 
				newTextBoxDiv.append().html('<font color="red">* </font><input type="text" id="textbox' + counter + '" value="" class="validate[required,custom[mandatory-enter]]" name="data[SubService][sub_service][' + counter + ']">');			 
				newTextBoxDiv.appendTo("#TextBoxesGroup");
				
				var newCostDiv = $(document.createElement('div'))
				     .attr("id", 'CostDiv' + counter);
			 
				newCostDiv.append().html('<font color="red">* </font><input type="text" id="textbox' + counter + '" value="" class="validate[required,custom[mandatory-enter]]" name="data[SubService][cost][' + counter + ']">');			 
				newCostDiv.appendTo("#CostGroup");		
							 			 
				counter++;
				if(counter > 1) $('#removeButton').show('slow');
		     });
		 
		     $("#removeButton").click(function () {
					if(counter==1){
			          alert("No more textbox to remove");
			          return false;
			        }   			 
					counter--;			 
			        $("#TextBoxDiv" + counter).remove();
			        $("#CostDiv" + counter).remove();
			 		if(counter == 1) $('#removeButton').hide('slow');
			  });
			 
			      
	  });
	
</script>
 