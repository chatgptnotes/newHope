<select class="textBoxExpnd" id="ajaxcorporatesublocationid" name="data[Person][corporate_sublocation_id]">
 <option value="">Select Corporate Sublocations</option>
 <?php foreach($corporatesulloclist as $corporatesulloclistval) { ?>
  <option value="<?php echo $corporatesulloclistval['CorporateSublocation']['id'] ?>"><?php echo $corporatesulloclistval['CorporateSublocation']['name']; ?></option>
 <?php } ?>
</select>
 <br /> <br />
 <?php echo __('Other Details:');
 echo "<br/>" ?>
 <textarea row="3" id="otherdetails" class="textBoxExpnd" name="data[Person][corporate_otherdetails]"></textarea>