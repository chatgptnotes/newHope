<font color="red">*</font>&nbsp;&nbsp;<select class="validate[required,custom[mandatory-select]] textBoxExpnd1" id="ajaxcorporateid" name="data[Patient][corporate_id]" onchange='<?php echo $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList', 'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true));?>'>
 <option value="">Select Corporate</option>
 <?php foreach($corporatelist as $corporatelistval) { ?>
  <option value="<?php echo $corporatelistval['Corporate']['id'] ?>"><?php echo $corporatelistval['Corporate']['name']; ?></option>
 <?php } ?>
</select>
<span id="changeCorporateSublocList">
</span><br>