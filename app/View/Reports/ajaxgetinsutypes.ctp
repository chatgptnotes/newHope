<?php 
	echo $this->Form->input('PatientRegistrationReport.insurance_type_id', array('style'=>'width:160px;','label'=>false,'empty'=>__('All'),'options'=>$insurancetypelist,'class' => 'textBoxExpnd','id' => 'insType','onchange'=> $this->Js->request(array('action' => 'getInsComList','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insType").val()}', 'dataExpression' => true, 'div'=>false)))); 
?>

<span id="changeInsuranceCompanyList">
</span>