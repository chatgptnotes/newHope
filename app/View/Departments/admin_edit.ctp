<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#departmentfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Edit Speciality ', true); ?></h3>
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
<form name="departmentfrm" id="departmentfrm" action="<?php echo $this->Html->url(array("action" => "edit", "admin" => true)); ?>" method="post" >
	<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
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
		</tr> -->
		<tr>
			<td class="form_lables" class="form_lables" align="center">
			<?php echo __('Name'); ?><font color="red">*</font>
			</td>
			<td>
		        <?php 
		         echo $this->Form->input('Department.id', array( 'id' => 'departmentsid', 'label'=> false, 'div' => false, 'error' => false));
		        echo $this->Form->input('Department.name', array('class' => 'validate[required,custom[name]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
		        ?>
			</td>
		</tr>
		 <tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<?php if(in_array('Asset',$this->request->data['Department']['inventory_type'],true)){
					$checked = true;
				}?>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('checked'=>$checked,'id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Asset','name'=>'data[Department][inventory_type][]'));?><label
					style="width: 40px">Asset</label>
				</td>
			</tr>
			<tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<?php if(in_array('Expense',$this->request->data['Department']['inventory_type'],true)){
					$checked_exp = true;
				}?>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('checked'=>$checked_exp,'id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Expense','name'=>'data[Department][inventory_type][]'));?><label
					style="width: 55px">Expense</label>
				</td>
			</tr>
			<tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<?php if(in_array('Chargeable',$this->request->data['Department']['inventory_type'],true)){
					$checked_char = true;
				}?>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('checked'=>$checked_char,'id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Chargeable','name'=>'data[Department][inventory_type][]'));?><label
					style="width: 68px">Chargeable</label>
				</td>
			</tr>
			<tr>
				<td class="form_lables" align="center">&nbsp;</td>
				<?php if(in_array('Non-Chargeable',$this->request->data['Department']['inventory_type'],true)){
					$checked_non_char = true;
				}?>
				<td>
					<?php echo $this->Form->checkbox('Department.inventory_type',array('checked'=>$checked_non_char,'id'=>'checkbox','hiddenField' => false,'style'=>'float:left', 'value'=>'Non-Chargeable','name'=>'data[Department][inventory_type][]'));?><label
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
	<td colspan="2" align="center">
		<?php				    			 
					echo $this->Html->link(__('Cancel'),
						 					array('action' => 'index'),array('escape' => false,'class'=>'grayBtn')); 							 
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));			
	    ?>	
		
	</td>
	</tr>
	</table>
</form>