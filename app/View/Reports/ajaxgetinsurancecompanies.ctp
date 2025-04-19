<select id="insurancecompanyid" name="data[Person][insurance_company_id]" >
 <option value="">All</option>
 <?php foreach($insurancecompanylist as $insurancecompanylistval) { ?>
  <option value="<?php echo $insurancecompanylistval['InsuranceCompany']['id'] ?>"><?php echo $insurancecompanylistval['InsuranceCompany']['name']; ?></option>
 <?php } ?>
</select>
