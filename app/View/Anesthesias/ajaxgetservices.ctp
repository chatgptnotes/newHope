<select id="anesthesiaservices" class="validate[required,custom[mandatory-select]]" name="data[Anesthesia][tariff_list_id]" style="width:450px;">
 <option value="">Select Service</option>
 <?php foreach($services as $servicesval) { ?>
  <option value="<?php echo $servicesval['TariffList']['id'] ?>"><?php echo $servicesval['TariffList']['name']; ?></option>
 <?php } ?>
</select>