<div class="inner_title">
	<h3>&nbsp; <?php echo __('Add Parameters', true); ?></h3>
</div>
<?php
if (! empty ( $errors )) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
   <?php
	foreach ( $errors as $errorsval ) {
		echo $errorsval [0];
		echo "<br />";
	}
	
	?></div></td>
	</tr>
</table>
<?php } ?>

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#servicefrm").validationEngine();
	});
	
</script>

<form name="laboratoryfrm" id="laboratoryfrm"
	action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "add")); ?>"
	method="post">

	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<tr>
			<td colspan="2" align="center"><br></td>
		</tr>
		<tr>
			<td class="form_lables" align="right" valign="top">
		<?php echo __('Test Name'); ?><font color="red"> *</font>
			</td>
			<td> 
	        <?php
									echo $this->Form->input ( 'Laboratory.name', array (
											'class' => 'validate[required,custom[name]]',
											'id' => 'name',
											'label' => false,
											'div' => false,
											'error' => false 
									) );
									?>
		</td>
		</tr>
		<tr>
			<td class="form_lables" align="right" valign="top">
			<?php echo __('Parameters'); ?><font color="red">*</font>
			</td>
			<td>
				<table>
					<tr>
						<td>
							<div id='TextBoxesGroup'>
								<div id="TextBoxDiv1">
							<?php
							echo $this->Form->input ( '', array (
									'name' => "data[LaboratoryParameters][0]",
									'class' => 'validate[required,custom[mandatory-enter]]',
									'id' => 'parameter',
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?>
				        	</div>
							</div>
						</td>

					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="form_lables" align="right">&nbsp;</td>
			<td><input type="button" id="addButton" value="Add more"> <input
				type="button" id="removeButton" value="remove"
				style="display: none;"></td>
		</tr>

		<tr>
			<td colspan="2" align="center">
	<?php
	echo $this->Html->link ( __ ( 'Cancel' ), array (
			'action' => 'index' 
	), array (
			'escape' => false,
			'class' => 'grayBtn' 
	) );
	?>
		&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
			</td>
		</tr>
	</table>
</form>
<script><!--
		$(document).ready(function(){
	 
		    var counter = 1;
		 
		    $("#addButton").click(function () {		 
				if(counter>10){
			            alert("Only 10 textboxes allow");
			            return false;
				}   			 
				var newTextBoxDiv = $(document.createElement('div'))
				     .attr("id", 'TextBoxDiv' + counter);
			 
				newTextBoxDiv.append().html('<input type="text" id="textbox' + counter + '" value="" class="validate[required,custom[mandatory-enter]]" name="data[LaboratoryParameters][' + counter + ']">');			 
				newTextBoxDiv.appendTo("#TextBoxesGroup");
				
					
							 			 
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
					if(counter == 1) $('#removeButton').hide('slow');
			  });
			 
			      
	  });
	
--></script>
