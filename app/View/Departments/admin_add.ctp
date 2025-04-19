<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error">
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
 
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#departmentfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Add Speciality', true); ?></h3>
</div>
<form name="departmentfrm" id="departmentfrm" action="<?php echo $this->Html->url(array("action" => "add", "admin" => true)); ?>" method="post" >
	<table class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
			 
			<!--<tr>
				<td class="form_lables" align="center">
				<?php echo __('Location'); ?><font color="red">*</font>
				</td>
				<td>
			        <?php 
			       	 	//echo $this->Form->input('Department.location_id', array('empty'=>__('Please select'),'options'=>$locations,'class' => 'validate[required,custom[mandatory-select]]',
			       	 	//'id'=>'name','label'=> false, 'div' => false, 'error' => false));
			        ?>
				</td>
			</tr>-->
			
			<tr>
			<td class="form_lables" align="center">
			<?php echo __('Name'); ?><font color="red">*</font>
			</td>
			<td>
		        <?php 
		       	 	echo $this->Form->input('Department.name', array('class' => 'validate[required,custom[name]]','id'=>'name','label'=> false, 'div' => false, 'error' => false));
		        ?>
			</td>
			</tr>
			<tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Asset','name'=>'data[Department][inventory_type][]'));?><label
					style="width: 40px">Asset</label>
				</td>
			</tr>
			<tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Expense','name'=>'data[Department][inventory_type][]'));?><label
					style="width: 55px">Expense</label>
				</td>
			</tr>
			<tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Chargeable','name'=>'data[Department][inventory_type][]'));?><label
					style="width: 70px">Chargeable</label>
				</td>
			</tr>
			<tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Non-Chargeable','name'=>'data[Department][inventory_type][]'));?><label
					style="width: 98px">Non-Chargeable</label>
				</td>
				
			</tr>
			<tr>
			<td class="form_lables" align="center">Select Accounting Class</td>
			<td valign="top">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
             		<tr>
						<td valign="top">
							<?php
		                       echo $this->Form->input('Department.accounting_class',array('options'=>array('8300 Supplies','3900 Other Medical Supplies'),'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectLeft','label'=>false));
		                    ?>
						</td>
						<td width="15%">
		                      <input id="MoveRight" type="button" value=" >> " />
						      <input id="MoveLeft" type="button" value=" << " />
		                </td>
		                <td valign="top" width="35%">
                            	<?php 
	                            		echo $this->Form->input('Department.inventory_type_id',array('options'=>array(),'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectRight','label'=>false));
	                            ?>
	                        </td>
		             </tr>
		            </table>
			</tr>
			
	<tr>
		<td>
			 &nbsp;
		</td>
		<td>
			<?php				    			 
						echo $this->Html->link(__('Cancel', true), array('action' => 'index'), array('class' => 'blueBtn','escape' => false));
					 
						echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));			
		    ?>	
			
		</td>
	</tr>
	</table>
</form>
<script>
$(function() {
    $("#MoveRight,#MoveLeft").click(function(event) {
        var id = $(event.target).attr("id");
        var selectFrom = id == "MoveRight" ? "#SelectLeft" : "#SelectRight";
        var moveTo = id == "MoveRight" ? "#SelectRight" : "#SelectLeft";

        var selectedItems = $(selectFrom + " :selected").toArray();
        $(moveTo).append(selectedItems);
        selectedItems.remove;
    });
});
</script>