<font color="red">*</font>&nbsp;&nbsp;<select class="validate[required,custom[mandatory-select]] textBoxExpnd1" id="paymentCategoryId" name="data[Patient][credit_type_id]" onchange='<?php echo $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false));?>'>
 <option value="">Select Credit Type</option>
 <option value="1">Corporate</option>
 <option value="2">Insurance</option>
</select><br/>
<span id="changeCorprateLocationList">
</span><br>