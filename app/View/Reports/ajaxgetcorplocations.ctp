<?php 
	echo $this->Form->input('PatientRegistrationReport.corporate_location_id', array('style'=>'width:160px;','label'=>false,'empty'=>__('All'),'options'=>$corporatelocationlist,'class' => 'textBoxExpnd','id' => 'corporate','onchange'=> $this->Js->request(array('action' => 'getCropList','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporateid:$("#corporate").val()}', 'dataExpression' => true, 'div'=>false)))); 
?>
<span id="changeCorporateList">
</span>