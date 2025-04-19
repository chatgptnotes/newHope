<font color="red">*</font>&nbsp;&nbsp;<select class="validate[required,custom[mandatory-select]] textBoxExpnd1" id="ajaxcorporatelocationid" name="data[Patient][corporate_location_id]" onchange='<?php echo $this->Js->request(array('action' => 'getCorporateList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true));?>'>
 <option value="">Select Corporate Location</option>
 <?php foreach($corporatelocationlist as $corporatelocationlistval) { ?>
  <option value="<?php echo $corporatelocationlistval['CorporateLocation']['id'] ?>"><?php echo $corporatelocationlistval['CorporateLocation']['name']; ?></option>
 <?php } ?>
</select>
<span id="changeCorporateList">
</span>