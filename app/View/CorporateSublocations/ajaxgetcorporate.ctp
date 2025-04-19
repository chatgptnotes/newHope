<select id="corporatename" class="validate[required,custom[mandatory-select]]" name="data[CorporateSublocation][corporate_id]">
 <option value="">Select Corporate</option>
 <?php foreach($corporate as $corporateval) { ?>
  <option value="<?php echo $corporateval['Corporate']['id'] ?>"><?php echo $corporateval['Corporate']['name']; ?></option>
 <?php } ?>
</select>