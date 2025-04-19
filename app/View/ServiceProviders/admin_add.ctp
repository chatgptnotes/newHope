<style>
.tdLabel2{
	color:#000;
}
</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Service Provider', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error"><div  >
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
 

<!--BOF lab Forms -->
<div>&nbsp;</div>
<?php echo $this->Form->create('ServiceProvider', array('url'=>array('controller'=>$this->params['Controller'],'action'=>'add'),'id'=>'servicerFrm',
												    	'inputDefaults' => array(
												        'label' => false,
												        'div' => false,'error'=>false
												    )
));?>
					<table width="420" cellpadding="0" cellspacing="0" border="0" align="center">
						<!-- <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Account No</td>
                            <td width="300">  <?php // echo $accountNo;   
                          //  echo $this->Form->input('account_no',array('value'=>$accountNo));
                            ?> </td>                         
                        </tr> -->
						<tr>
                      	 	<td width="120" class="tdLabel2" align="right">Category<font color="red"> *</font></td>
                            <td width="300">
                            <?php
                            	echo $this->Form->input('category', array('options'=>Configure::read('service_provider_category'),'empty'=>__('Please Select'),'class' => 'textBoxExpnd validate[required,custom[mandatory-select]]','id' => 'category'));
                            ?>
                            </td>                         
                       </tr>
                       <tr id = "costArea">
                      	 	<td width="120" class="tdLabel2" align="right">Cost to Hospital</td>
                            <td width="300">
                            <?php
                            	echo $this->Form->input('cost_to_hospital', array('type'=>'text','id' => 'cost'/*,'class'=>'validate[required,custom[mandatory-select]]'*/));
                            ?>
                            </td>                         
                       </tr>
                   
                       <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Name<font color="red"> *</font></td>
                            <td width="300">
                            <?php 
                            	echo $this->Form->input('name', array('class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'name'));
                            	echo $this->Form->hidden('id', array());
                            ?>
                            </td>                         
                       </tr>
                         
                        <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Contact Person</td>
                            <td width="300">
                            <?php 
                            	echo $this->Form->input('contact_person', array('class' => 'textBoxExpnd','id' => 'contact_person'));
                            	 
                            ?>
                            </td>                         
                       </tr>
                        <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Contact No.</td>
                            <td width="300">
                            <?php 
                            	echo $this->Form->input('contact_no', array('class' => 'validate[custom[onlyNumber] textBoxExpnd','id' => 'contact_no')); 
                            ?>
                            </td>                         
                       </tr>
                       <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Location</td>
                            <td width="300">
                            <?php 
                            	echo $this->Form->input('location', array('class' => 'textBoxExpnd','id' => 'location'));
                            ?>
                            </td>                         
                       </tr>
                       <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Account Group</td>
                            <td width="300">
                            <?php echo $this->Form->input('accounting_group_id', array('type'=>'select','id' => 'group_id','value'=>$groupId,'options'=>$group,'class'=>'','empty'=>'Please Select'));
                            ?></td>                         
                       </tr>
                       
                        <tr>
                      	 	<td width="120" class="tdLabel2" align="right">Provider Type</td>
                            <td width="300">
                            <?php echo $this->Form->input('provider_type', array('type'=>'select','id' => 'provider_type','options'=>Configure :: read('hospital_mode'),'empty'=>'Please Select'));
                            ?></td>                         
                       </tr>
					   <tr>
		<th width="120" class="tdLabel2" align="right" colspan="2">Bank account details<?php echo $this->Form->hidden('HrDetail.id',array('id'=>'HrDetailId','value'=>$hrDetails['HrDetail']['id']));?></th>
	</tr>
	<tr>
		<td width="120" class="tdLabel2" align="right">Bank name</td>
		<td><?php echo $this->Form->input('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd','value'=>$hrDetails['HrDetail']['bank_name'])); ?>
		</td>
	</tr>
	<tr>
		<td width="120" class="tdLabel2" align="right">Bank Branch</td>
		<td><?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' => 'branch_name','class'=>'textBoxExpnd','value'=>$hrDetails['HrDetail']['branch_name'])); ?>
		</td>			
	</tr>
	<tr>
		<td width="120" class="tdLabel2" align="right">Account number</td>
		<td><?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no','class'=>'textBoxExpnd validate["",custom[onlyNumber]]','value'=>$hrDetails['HrDetail']['account_no'])); ?></td>
	</tr>
	<tr>
		<td width="120" class="tdLabel2" align="right">IFSC Code</td>
		<td><?php echo $this->Form->input('HrDetail.ifsc_code', array('type'=>'text','label'=>false,'id' => 'ifsc_code','class'=>'textBoxExpnd','maxlength'=>'11','value'=>$hrDetails['HrDetail']['ifsc_code'])); ?></td>
	</tr>
	<tr>
		<td width="120" class="tdLabel2" align="right">Bank pass book copy obtained</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.pass_book_copy', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['pass_book_copy'])); ?>
		</td>
	</tr>
  
	<tr>
		<td  width="120" class="tdLabel2" align="right">NEFT authorization received</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['neft_authorized_received'])); ?>
		</td>
	</tr>  		
	<tr>
		<td width="120" class="tdLabel2" align="right">PAN</td>
		<td><?php 	echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','value'=>$hrDetails['HrDetail']['pan']));?>
		</td>
	</tr> 
                       
                       <tr>
                       		<td height="10" colspan="4">&nbsp;</td>
                       </tr> 
                       <tr>
                       <td colspan="4" height="10"></td>
                       </tr>
                    </table>   
                      <p class="ht5"></p>
                      <table width="750" cellpadding="0" cellspacing="0" border="0" align="center">
                      	<tr> 
                                <td width="50%" align="right"> 
                                	<?php 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		
                                		echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class' => 'grayBtn'));
                                	?>
                                </td>
                            </tr>
                      </table>  
                      <?php echo $this->Form->end();?>         
<script>
	$(document).ready(function(){
		//$("#costArea").hide();
	// binds form submission and fields to the validation engine
		$("#servicerFrm").validationEngine();
	});
	
	//by amit jain for blood bank cost 
	//$("#category").change(function(){
		//if($("#category").val()=="blood")
		//{	
		//	$("#costArea").show();
		//}else
		//{
		//	$("#costArea").hide();
		//}
	//});	
</script>            
<!-- EOF lab Forms -->

   