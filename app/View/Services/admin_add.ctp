<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Service', true); ?></h3>
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

<form name="servicefrm" id="servicefrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "add", "admin" => true)); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="650"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
		<td class="form_lables" valign="top">
		<?php echo __('Credit Type'); ?> <font color="red"> *</font>
		</td>
		<td> 
	         
	        <?php echo $this->Form->input('Service.credit_type_id', array('div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('1'=>'Corporate','2'=>'Insurance'),'id' => 'corporate_id','class' => 'validate[required,custom[mandatory-select]]','onchange'=> $this->Js->request(array('action' => 'getcorporate','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{corporateType:$("#corporate_id").val()}', 'dataExpression' => true, 'div'=>false))));  ?>
			

		</td>
	</tr>
	<tr style="display:none;" id = 'company'>
		<td class="form_lables" valign="top">
		<?php echo __('Company'); ?> <font color="red"> *</font>
		</td>
		<td id="changeCreditTypeList"> &nbsp;</td>
	</tr>
	<tr>
		<td class="form_lables" valign="top">
		<?php echo __('Service Name'); ?><font color="red"> *</font>
		</td>
		<td> 
	        <?php 
	        	echo $this->Form->input('Service.name', array('class' => 'validate[required,custom[name]]', 'id' => 'service', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
			
		</td>
		 
	</tr>
	<tr>
		<td class="form_lables" valign="top">
			<?php echo __('Sub Service'); ?>/<?php echo __('Cost'); ?><font color="red"> *</font>
		</td>
		<td>
			<table>
				<tr>
					<td>
						<div id='TextBoxesGroup'>
							<div id="TextBoxDiv1">
							<?php 
				        			echo $this->Form->input('', array('name'=>"data[SubService][sub_service][0]",'class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'sub_service', 'label'=> false, 'div' => false, 'error' => false));
				        	?>
				        	</div>
				        </div>
					 </td>
					 <td>
						<div id='CostGroup'>
							<div id="CostGroup1"><font color="red">*</font>			 
						        <?php 
						        	echo $this->Form->input('', array('name'=>"data[SubService][cost][0]",'class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'cost', 'label'=> false, 'div' => false, 'error' => false ));
						        ?>
						    </div>
						 </div>
					</td>
				</tr>
			</table>
		</td>		 
	</tr>
	<tr>
		<td class="form_lables">&nbsp;</td>
		<td>
			<input type="button"  id="addButton" value="Add more" class="blueBtn"> 
		 	<input type="button"   id="removeButton" value="Remove" style="display:none;" class="blueBtn"> 
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
		echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class' => 'grayBtn'));
	?>
		&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
	$(document).ready(function(){
		$("#corporate_id").change(function(){
			if($("#corporate_id").val() != ''){
				$("#company").show();
			} else {
				$("#company").hide();
			}
		});

		/*$(".blueBtn").click(function(){
			alert();
			if($("#corporate_id").val() == ''){
				alert('Please select company from list');
				$("#corporate_id").focus();
				return false;
			}
		})*/
	});
</script>
<script>
		$(document).ready(function(){
	 
		    var counter = 1;
		 
		    $("#addButton").click(function () {		 
			  			 
				var newTextBoxDiv = $(document.createElement('div'))
				     .attr("id", 'TextBoxDiv' + counter);
			 
				newTextBoxDiv.append().html('<input type="text" id="textbox' + counter + '" value="" class="validate[required,custom[mandatory-enter]]" name="data[SubService][sub_service][' + counter + ']">');			 
				newTextBoxDiv.appendTo("#TextBoxesGroup");
				
				var newCostDiv = $(document.createElement('div'))
				     .attr("id", 'CostDiv' + counter);
			 
				newCostDiv.append().html('<font color="red">*</font> <input type="text" id="textbox' + counter + '" value="" class="validate[required,custom[mandatory-enter]]" name="data[SubService][cost][' + counter + ']">');			 
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
 