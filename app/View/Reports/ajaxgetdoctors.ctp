<select id="doctorlisting" name="data[PatientAdmissionReport][reference_doctor]" class="textBoxExpnd">
 <option value="">Select Doctor</option>
 <?php foreach($doctorlist as $key =>$doctorlistval) { ?>
  <?php if($familyknown == 4) { ?>
   <option value="<?php echo $key ?>"><?php echo $doctorlistval; ?></option>
  <?php } else { ?>
   <option value="<?php echo $doctorlistval['Consultant']['id'] ?>"><?php echo $doctorlistval['Consultant']['full_name']; ?></option>
  <?php } ?>
 <?php } ?>
</select>