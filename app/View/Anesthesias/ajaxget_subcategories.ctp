<select id="anesthesiasubcategory" name="data[Anesthesia][anesthesia_subcategory_id]" style="width:450px;">
 <option value="">Select Subcategory</option>
 <?php foreach($anesthesia_subcategory as $anesthesia_subcategoryval) { ?>
  <option value="<?php echo $anesthesia_subcategoryval['AnesthesiaSubcategory']['id'] ?>"><?php echo $anesthesia_subcategoryval['AnesthesiaSubcategory']['name']; ?></option>
 <?php } ?>
</select>