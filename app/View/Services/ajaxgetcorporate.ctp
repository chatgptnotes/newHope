<!--<select id="ajaxcorporateid" name="data[Patient][corporate_id]" onchange='<?php echo $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList', 'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true));?>'>
 <option value="">Select Corporate</option>
 <?php foreach($corporatelist as $corporatelistval) { ?>
  <option value="<?php echo $corporatelistval['Corporate']['id'] ?>"><?php echo $corporatelistval['Corporate']['name']; ?></option>
 <?php } ?>
</select>
<span id="changeCorporateSublocList">
</span><br>-->


	<?php 
	  if($corporate_type != ''){
		 if($corporate_type == 'corporate'){
			echo $this->Form->input('Service.corporate_id', array('class' => 'validate[required,custom[mandatory-select]]','empty'=>'Select Corporate','options'=>$corporate_list,'id' => 'corporate_id', 'label'=> false, 'div' => false, 'error' => false));
		 } else if($corporate_type == 'insurance') {
			echo $this->Form->input('Service.insurance_company_id', array('class' => 'validate[required,custom[mandatory-select]]', 'empty'=>'Select Insurance', 'options'=>$corporate_list,'id' => 'corporate_id', 'label'=> false, 'div' => false, 'error' => false));
		 }  
	}
	
	?>
 