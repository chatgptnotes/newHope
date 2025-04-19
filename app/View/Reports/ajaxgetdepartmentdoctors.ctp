<select id="doctor" name="data[doctor]">
 <option value="">Select Doctor</option>
 <?php foreach($doctorlist as $key=> $val) { ?>
  <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
 <?php } ?>
</select>

