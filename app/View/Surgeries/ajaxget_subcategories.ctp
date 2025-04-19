<select id="surgerysubcategory" name="data[Surgery][surgery_subcategory_id]" style="width:450px;">
 <option value="">Select Subcategory</option>
 <?php foreach($surgery_subcategory as $surgery_subcategoryval) { ?>
  <option value="<?php echo $surgery_subcategoryval['SurgerySubcategory']['id'] ?>"><?php echo $surgery_subcategoryval['SurgerySubcategory']['name']; ?></option>
 <?php } ?>
</select>