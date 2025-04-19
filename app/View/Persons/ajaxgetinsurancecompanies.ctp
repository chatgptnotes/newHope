<font color="red">*</font>&nbsp;&nbsp;<select class="validate[required,custom[mandatory-select]] textBoxExpnd1" id="insurancecompanyid" name="data[Person][insurance_company_id]" >
 <option value="">Select Insurance Company</option>
 <?php foreach($insurancecompanylist as $insurancecompanylistval) { ?>
  <option value="<?php echo $insurancecompanylistval['InsuranceCompany']['id'] ?>"><?php echo $insurancecompanylistval['InsuranceCompany']['name']; ?></option>
 <?php } ?>
</select>
