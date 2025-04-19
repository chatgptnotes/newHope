<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?php 
if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }

     ?></td>
	</tr>
</table>
<?php } ?>

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#tarifflist").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>
		<?php echo __('Edit Service'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Tariff',array('type' => 'file','id'=>'tarifflist','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('TariffList.id', array('value'=>$this->request->data['TariffList']['id']));
?>
<table class="table_format" border="0" cellpadding="0"
	cellspacing="0" width="60%" align="center">

	<!-- <tr>
	<td align="right"><?php echo __('Code Type'); ?><font color="red">*</font></td>
	<td><?php $code_option = array(''=>'Please select','CPT'=>'CPT','Custom Code'=>'Custom Code','HCPCS'=>'HCPCS','ICD9'=>'ICD9','ICD10PCS'=>'ICD10PCS','NDC'=>'NDC');
	echo $this->Form->input('TariffList.code_type', array('value'=>ucfirst($this->request->data['TariffList']['code_type']),'class' => 'validate[required,custom[mandatory-select]] codeType','options' => $code_option, 'id' => 'code_type', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 215px'));?>
	</td>
	</tr> -->

	<?php //if(ucfirst($this->request->data['TariffList']['code_type'])!='CPT'){?>
	<!-- <tr id='cpt' style="display: none;">
	<td align="right"><?php echo __('CPT Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.cbt', array('value'=>ucfirst($this->request->data['TariffList']['cbt']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'cbt', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr> -->
	<?php// }else{?>
	<!-- <tr id='cpt'>
	<td align="right"><?php echo __('CPT Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.cbt', array('value'=>ucfirst($this->request->data['TariffList']['cbt']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'cbt', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr> -->
	<?php // }?>

	<?php //if(ucfirst($this->request->data['TariffList']['code_type'])!='Custom Code'){?>
	<!-- <tr id='custom_code' style="display: none;">
	<td align="right"><?php echo __('Custom Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.custom_code', array('value'=>ucfirst($this->request->data['TariffList']['custom_code']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'CustomCode', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr> -->
	<?php //}else{?>
	<!-- <tr id='custom_code'>
	<td align="right"><?php echo __('Custom Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.custom_code', array('value'=>ucfirst($this->request->data['TariffList']['custom_code']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'CustomCode', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr> -->
	<?php //}?>

	<?php if(ucfirst($this->request->data['TariffList']['code_type'])!='HCPCS'){?>
	<tr id='hcpcs' style="display: none;">
		<td align="right"><?php echo __('HCPCS Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.hcpcs', array('value'=>ucfirst($this->request->data['TariffList']['hcpcs']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'hcpcs', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }else{?>
	<tr id='hcpcs'>
		<td align="right"><?php echo __('HCPCS Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.hcpcs', array('value'=>ucfirst($this->request->data['TariffList']['hcpcs']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'hcpcs', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }?>

	<?php if(ucfirst($this->request->data['TariffList']['code_type'])!='ICD9'){?>
	<tr id='icd9' style="display: none;">
		<td align="right"><?php echo __('ICD 9 Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.icd_9', array('value'=>ucfirst($this->request->data['TariffList']['icd_9']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'icd_9', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }else{?>
	<tr id='icd9'>
		<td align="right"><?php echo __('ICD 9 Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.icd_9', array('value'=>ucfirst($this->request->data['TariffList']['icd_9']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'icd_9', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }?>

	<?php if(ucfirst($this->request->data['TariffList']['code_type'])!='ICD10PCS'){?>
	<tr id='icd10' style="display: none;">
		<td align="right"><?php echo __('ICD 10 Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.icd_10', array('value'=>ucfirst($this->request->data['TariffList']['icd_10']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'icd_10', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }else{?>
	<tr id='icd10'>
		<td align="right"><?php echo __('ICD 10 Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.icd_10', array('value'=>ucfirst($this->request->data['TariffList']['icd_10']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'icd_10', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }?>

	<?php if(ucfirst($this->request->data['TariffList']['code_type'])!='NDC'){?>
	<tr id='ndc' style="display: none;">
		<td align="right"><?php echo __('NDC Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.ndc_code', array('value'=>ucfirst($this->request->data['TariffList']['ndc_code']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'ndc_code', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }else{?>
	<tr id='ndc'>
		<td align="right"><?php echo __('NDC Code'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.ndc_code', array('value'=>ucfirst($this->request->data['TariffList']['ndc_code']),'class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'ndc_code', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }?>

	<tr>
		<td align="right"><?php echo __('Name'); ?><font color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.name', array('class' => 'validate[required,custom[mandatory-enter-only]]','value'=>ucfirst($this->request->data['TariffList']['name']), 'id' => 'tariffname', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));
		?>
		<!-- Trigger the modal with a button -->
		<button type="button" data-toggle="modal" data-target="#myModal">Add Sub Package</button>
			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Sub Package Details</h4>
			      </div>
			      <div class="modal-body">
			      	<table width="100%">
			      		<tr>
			      			<td>Package Name :</td>
			      			<td><?php echo ucfirst(($this->request->data['TariffList']['name']))?>
			      				<input type="hidden" name="name_pack" id="name_pack" value='<?php echo ($this->request->data["TariffList"]["name"])?>'/>
			      			</td>
			      		</tr>
			      		<tr>
			      			<td>Sub Package Name :</td>
			      			<td><input type="text" name="name" id="sub_grp"/></td>
			      		</tr>
			      		<tr>
			      			<td>OT Notes Template :</td>
			      			<td><textarea name="template_name" id="template_name"></textarea></td>
			      		</tr>
			      		<tr>
			      			<td colspan="2">
			      				<input type="hidden" name="id" id="id"/> 
			      				<button id="saveBtn" class="btn btn-default" data-dismiss="modal" type="button">Save</button>
			      			</td>
			      		</tr>
			      	</table>
			      	<br>
			        <p></p>
			        <table width="100%">
			        	<tr>
			        		<td colspan="3"><b>List Of OT Notes Template</b></td>
			        	</tr>
			      		<tr>
			      			<th>Sub Group Name</th>
			      			<th>OT Notes Template</th>
			      			<th>Action</th>
			      			
			      		</tr>
			      		<?php foreach($subpackValues as $key=>$data){
			      			$subArry[$data['PackageSubCategory']['id']]=$data['PackageSubCategory']['name']?>
			      		<tr>
			      			<td id="sub_grp_<?php echo $key?>">
			      				<?php 
			      					echo ucfirst($data['PackageSubCategory']['name']);
			      				?>
			      			</td>
			      			
			      			<td id="template_name_<?php echo $key?>">
			      				<?php echo ucfirst($data['PackageSubCategory']['template_name'])?>
			      			</td>
			      			
			      			<td>
			      				<input type="hidden" name="tariff_id_old" id="tariff_id_old_<?php echo $key?>" value="<?php echo $data['PackageSubCategory']['id']?>"/>
			      				
			      				<input type="hidden" name="id" id="tbl_id_<?php echo $key?>" value="<?php echo $data['PackageSubCategory']['id']?>"/>
			      				
			      				<?php echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('id'=>$key,'class'=>'copy')),'javascript:void(0)',array('escape'=>false));?></td>
			      		</tr>
			      		<?php }?> 
			      	</table> 
			      </div>
			      <div class="modal-footer">
			        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			      </div>
			    </div>

			  </div>
			</div>
			<!--EOD -->
			<button type="button" data-toggle="modal" data-target="#myModalSub">Add Sub Sub Package</button>
			<!-- Modal -->
			<div id="myModalSub" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Sub Sub Package Details</h4>
			      </div>
			      <div class="modal-body">
			      	<table width="100%">
			      		<tr>
			      			<td>Package Name :</td>
			      			<td><?php echo ucfirst(($this->request->data['TariffList']['name']))?>
			      				<input type="hidden" name="name_pack" id="name_pack_sub" value='<?php echo ($this->request->data["TariffList"]["name"])?>'/>
			      			</td>
			      		</tr>
			      		<tr>
			      			<td>Sub Package Name :</td>
			      			<td><?php 

			      			echo $this->Form->input('name_sub_pack',array('empty'=>'Please Select','options'=>$subArry,'id'=>'sub_cat_id'))?></td>
			      		</tr>
			      		<tr>
			      			<td>Sub Sub Package Name :</td>
			      			<td><input type="text" name="name" id="name_sub"/></td>
			      		</tr>
			      		<tr>
			      			<td>OT Notes Template :</td>
			      			<td><textarea name="template_name" id="sub_template_name"></textarea></td>
			      		</tr>
			      		<tr>
			      			<td colspan="2">
			      				<input type="hidden" name="id" id=""/> 
			      				<button id="saveBtnSub" class="btn btn-default" data-dismiss="modal" type="button">Save</button>
			      			</td>
			      		</tr>
			      	</table>
			      	<br>
			        <p></p>
			        <table width="100%">
			        	<tr>
			        		<td colspan="4"><b>List Of Sub Sub OT Notes Template</b></td>
			        	</tr>
			      		<tr>
			      			<th>Sub Sub Group Name</th>
			      			<th>Sub Group Name</th>
			      			<th>OT Notes Template</th>
			      			<!-- <th>Action</th> -->
			      			
			      		</tr>
			      		<?php foreach($subSubPackValues as $key=>$data){?>
			      		<tr>
			      			<td id="sub_grp_<?php echo $key?>">
			      				<?php 
			      					echo ucfirst($data['PackageSubSubCategory']['name']);
			      				?>
			      			</td>
			      			
			      			<td id="template_name_sub_<?php echo $key?>">
			      				<?php echo ucfirst($subArry[$data['PackageSubSubCategory']['package_sub_category_id']])?>
			      			</td>

			      			<td id="template_name_<?php echo $key?>">
			      				<?php echo ucfirst($data['PackageSubSubCategory']['template_name'])?>
			      			</td>
			      			
			      			<!-- <td>
			      				<input type="hidden" name="tariff_id_old" id="tariff_id_old_<?php //echo $key?>" value="<?php //echo $data['PackageSubSubCategory']['id']?>"/>
			      				
			      				<!--<input type="hidden" name="id" id="tbl_id_<?php //echo $key?>" value="<?php //echo $data['PackageSubSubCategory']['id']?>"/>
			      				
			      				<?php //echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('id'=>$key,'class'=>'copy')),'javascript:void(0)',array('escape'=>false));?>
			      			<!--</td> -->
			      		</tr>
			      		<?php }?> 
			      	</table> 
			      </div>
			      <div class="modal-footer">
			        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			      </div>
			    </div>

			  </div>
			</div>
		
		</td>
	</tr>

	<tr>
		<td align="right"><?php echo __('Code Name'); ?></td>
		<td><?php echo $this->Form->input('TariffList.code_name', array(
			 'id' =>'codeName', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px','readonly'=>'readonly'));?>
			<i>(For configuration purpose only)</i>
		</td>
	</tr>

	<tr>
		<td align="right"><?php echo __('Visit Type',true); ?><font
			color="red"></font>
		</td>
		<td><?php
		echo $this->Form->input('TariffList.check_status',array('id'=>'check_status','type'=>'checkBox','class'=>''));
		?>
		</td>
	</tr>
	<!-- leena -->
	<tr>
		<td align="right"><?php echo __('Type',true); ?><font color="red">*</font>
		</td>
		<td><?php
		echo $this->Form->input('TariffList.service_type',array('id'=>'service_type','type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','BOTH'=>'BOTH'),'class'=>'validate[required,custom[mandatory-select]]','default'=>'BOTH'));
		?>
		</td>
	</tr>
	<!-- Added by Atul -->
	<?php if($this->Session->read('website.instance')=='vadodara'){?>
	<tr>
		<td align="right"><?php echo __('Service Location',true); ?>
		</td>
		<td><?php
		
		echo $this->Form->input('TariffList.service_location',array('id'=>'service_location','type'=>'select','options'=>array('All'=>'All', $location)));
		?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td align="right"><?php echo __('CGHS Code'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.cghs_code', array('value'=>ucfirst($this->request->data['TariffList']['cghs_code']), 'id' => 'cghs_code', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));
		?>
		</td>
	</tr>
	
	<!-- field added by- Pooja -->
	<tr>
		<td align="right"><?php echo __('CGHS Service Alias Name'); ?></td>
		<td><?php echo $this->Form->input('TariffList.cghs_alias_name', array('value'=>ucfirst($this->request->data['TariffList']['cghs_alias_name']),'id' => 'cghs_name', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));?>
		</td>
	</tr>

	<?php if(ucfirst($this->request->data['TariffList']['code_type'])!='NDC'){?>
	<tr id='ndc_quality' style="display: none;">
		<td align="right"><?php echo __('NDC Quality'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.NdcQuality', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'NDC_QUALITY', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }else{?>
	<tr id='ndc_quality'>
		<td align="right"><?php echo __('NDC Quality'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.NdcQuality', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'NDC_QUALITY', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }?>

	<?php if(ucfirst($this->request->data['TariffList']['code_type'])!='NDC'){?>
	<tr id='ndc_units' style="display: none;">
		<td align="right"><?php echo __('NDC Units'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.NdcUnit', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'NDC_UNITS', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }else{?>
	<tr id='ndc_units'>
		<td align="right"><?php echo __('NDC Units'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.NdcUnit', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'NDC_UNITS', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
		</td>
	</tr>
	<?php }?>

	<!-- 
	<tr>
	<td align="right">
	<?php echo __('NABH Code'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('TariffList.cghs_nabh', array('class' => 'validate[required,custom[mandatory-enter-only]]','value'=>ucfirst($this->request->data['TariffList']['cghs_nabh']), 'id' => 'cghs_nabh', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);'));
        ?>
	</td>
	</tr>
	
	<tr>
	<td align="right">
	<?php echo __('Non NABH Code'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('TariffList.cghs_non_nabh', array('class' => 'validate[required,custom[mandatory-enter-only]]','value'=>ucfirst($this->request->data['TariffList']['cghs_non_nabh']), 'id' => 'cghs_non_nabh', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);'));
        ?>
	</td>
	</tr>
	 -->
	<tr>
		<td align="right"><?php echo __('Apply in a Day'); ?><font color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.apply_in_a_day', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'apply_in_a_day', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<!--<tr>
	<td align="right">
	<?php echo __('Service Group',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
		// Dont change this options. They are fixed and used and service groups
         
       // echo $this->Form->input('TariffList.service_group', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $servicegroup, 'empty' => 'Select Service Group', 'id' => 'service_group', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr> -->
	<tr>
		<td align="right"><?php echo __('Service Group',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		// Dont change this options. They are fixed and used and service groups
			
		echo $this->Form->input('TariffList.service_category_id', array('onchange'=>'getListOfSubGroup(this.value)','class' => 'validate[required,custom[mandatory-select]]', 'options' => $service_group_category, 'empty' => 'Select Service Group', 'id' => 'service_group_category', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 215px'));
		 
		 	$display = ($service_group_category[$this->data[TariffList][service_category_id]] !=  'Room Tariff') ? 'none' : '';
		?></td>
	</tr>
	<?php if($this->Session->read('website.instance')=='vadodara'){
				$class= 'validate[required,custom[mandatory-select]]';
				$fontColor='<font color="red">*</font>';
	     	}else{
				$class='';
				$fontColor='';
	  		}
	?>
	<tr>
		<td align="right"><?php echo __('Service Sub Group',true); ?><?php echo $fontColor;?>
		</td>
		<td valign="middle" style="text-align: left;"><?php
		echo $this->Form->input('TariffList.service_sub_category_id', array( 'options' => $service_sub_group_category, 'empty' => 'Please Select','class'=>$class, 'id' => 'service_sub_category_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 215px'));
		
		?>
		</td>

	</tr>
	<tr class='roomRelatesService' style='display: <?php echo $display?>'>
		<td align="right"><?php echo __('i-Assist'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.i_assist', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'iAssist', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr class='roomRelatesService' style='display: <?php echo $display?>'>
		<td align="right"><?php echo __('PSI'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.psi', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'psi', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Hospital costs for private patient'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.price_for_private', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'price_for_private', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Hospital costs for CGHS patients'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.price_for_cghs', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'price_for_cghs', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Hospital costs for company patients'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.price_for_other', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'price_for_other', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Enable For Nurse Billing Activity'); ?>
		</td>
		<td><?php echo $this->Form->input('TariffList.enable_for_billing_activity',array('id'=>'enableForNurse','type'=>'checkBox','class'=>''));?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('OT Note Template');?>
		</td>
		<td><?php echo $this->Form->input('TariffList.template_name',array('id'=>'enableForNurse','type'=>'textArea','class'=>'','value'=>$packCntVal['PackageCategory']['template_name']));?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Pre-Investigation'); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('TariffList.pre_investigation', array('type'=>'text','class' => ' ',
        	'id' => 'pre_investigation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        <i>(For Package Only)</i>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Post-Investigation'); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('TariffList.post_investigation', array('type'=>'text','class' => ' ',
        	'id' => 'post_investigation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        <i>(For Package Only)</i>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center"><?php				    			 
		echo $this->Html->link(__('Cancel'),
						 					array('action' => 'viewTariff'),array('escape' => false,'class'=>'grayBtn'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));
	    ?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>

<script>	

$('.codeType').change(function ()
{	//alert($('#code_type').val());
			if($('#code_type').val()=='NDC')
			{
				$("#ndc").show();
				$("#ndc_quality").show();
				$("#ndc_units").show();
			}else{
				$("#ndc").hide();
				$("#ndc_quality").hide();
				$("#ndc_units").hide();
			}

			if($('#code_type').val()=='CPT')
			{
				$("#cpt").show();
			}else{
				$("#cpt").hide();
			}

			if($('#code_type').val()=='Custom Code')
			{
				$("#custom_code").show();
			}else{
				$("#custom_code").hide();
			}

			if($('#code_type').val()=='HCPCS')
			{
				$("#hcpcs").show();
			}else{
				$("#hcpcs").hide();
			}

			if($('#code_type').val()=='ICD9')
			{
				$("#icd9").show();
			}else{
				$("#icd9").hide();
			}

			if($('#code_type').val()=='ICD10PCS')
			{
				$("#icd10").show();
			}else{
				$("#icd10").hide();
			}
});
	    
// Functios to trem left and right white spaces.
// Left space
function ltrim(str) { 
	for(var k = 0; k < str.length && isWhitespace(str.charAt(k)); k++);
		
	return str.substring(k, str.length);
}
// FOr right spaces
function rtrim(str) {
	for(var j=str.length-1; j>=0 && isWhitespace(str.charAt(j)) ; j--) ;

	return str.substring(0,j+1);
}
// To check both spaces
function isWhitespace(charToCheck) {
	var whitespaceChars = " \t\n\r\f";
	return (whitespaceChars.indexOf(charToCheck) != -1);
}

// To remove spaces
function removeSpaces(id){
	var str = document.getElementById('name').value;
	
	//var trimmed = str.replace(/[\s\n\r]+/g, '') ;
	$('#name').val(ltrim(str));	
	
}
function getListOfSubGroup(obj){
	if($("#service_group_category option:selected").text() == 'Room Tariff'){
		$('#iAssist').val('<?php echo $this->data['TariffList']['is_assist']?>');
		$('#iAssist, #psi').val('<?php echo $this->data['TariffList']['psi']?>');
		$('.roomRelatesService').show('slow');
	}else{
		$('#iAssist, #psi').val('');
		$('.roomRelatesService').hide('slow');
	}
 	 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getListOfSubGroup", "admin" => false)); ?>"+"/"+obj,
			  context: document.body,				  		  
			  success: function(data){//alert(data);
			  	data1= $.parseJSON(data);
			  	$("#service_sub_category_id option").remove();
			  	$("#service_sub_category_id").append( "<option value=''>Please Select</option>" );
				$.each(data1, function(val, text) {
					 
				    $("#service_sub_category_id").append( "<option value='"+text.id+"'>"+text.value+"</option>" );
				}); 
			  }
		}); 
 }

 $('#saveBtn').click(function(){
 	var subGrp=$('#sub_grp').val();
 	var templateName=$('#template_name').val();
 	var tariffId=$('#tariff_id').val();;
 	var name_pack=$('#name_pack').val();
 	var id=$('#id').val();;
 	$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'Tariffs', "action" => "saveTemplate", "admin" => false)); ?>",
			  type: 'POST',
			  context: document.body,
			  data:{"subGrp" : subGrp,"templateName" : templateName,"tariffId" : tariffId,"id":id,'name_pack':name_pack},				  		  
			  success: function(data){//alert(data);

			  }
		}); 
 });

 $('#saveBtnSub').click(function(){//sub_id
 	var sub_cat_id=$('#sub_cat_id').val();
 	var name_sub=$('#name_sub').val();
 	var sub_template_name=$('#sub_template_name').val();;
 	var id=$('#sub_id').val();;
 	$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'Tariffs', "action" => "saveSubTemplate", "admin" => false)); ?>",
			  type: 'POST',
			  context: document.body,
			  data:{"sub_cat_id" : sub_cat_id,"name_sub" : name_sub,"sub_template_name" : sub_template_name,"id":id,'sub_template_name':sub_template_name},				  		  
			  success: function(data){//alert(data);

			  }
		}); 
 });
  //copy sub_grp_   template_name_
  $('.copy').on("click",function(){
  	var currentID=$(this).attr('id');
  	$('#sub_grp').val($.trim($('#sub_grp_'+currentID).html()));
  	$('#template_name').val($.trim($('#template_name_'+currentID).html()));
  	$('#tariff_id').val($.trim($('#tariff_id_old_'+currentID).val()));
  	$('#id').val($.trim($('#tbl_id_'+currentID).val()));
  });
</script>
