<select id="departmentid" name="data[User][department_id]" class=" validate[required,custom[mandatory-select]] textBoxExpnd " >
 <option value="">Select Specialty</option>
 <?php foreach($departmenttypelist as $departmenttypelistval) { ?>
  <option value="<?php echo $departmenttypelistval['Department']['id'] ?>"><?php echo $departmenttypelistval['Department']['name']; ?></option>
 <?php } ?> 
</select>


