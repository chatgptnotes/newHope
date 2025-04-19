<font color="red">*</font>&nbsp;&nbsp;<select class="validate[required,custom[mandatory-select]] textBoxExpnd1" id="insurancetypeid" name="data[Patient][insurance_type_id]" onchange='<?php echo $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true));?>'>
 <option value="">Select Insurance Type</option>
 <?php foreach($insurancetypelist as $insurancetypelistval) { ?>
  <option value="<?php echo $insurancetypelistval['InsuranceType']['id'] ?>"><?php echo $insurancetypelistval['InsuranceType']['name']; ?></option>
 <?php } ?>
</select>
<span id="changeInsuranceCompanyList">
</span>