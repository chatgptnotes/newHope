<?php 
	echo $this->Form->input('PatientRegistrationReport.corporate_id', array('style'=>'width:160px;','label'=>false,'empty'=>__('All'),'options'=>$corporatelist,'id' => 'subLocation','onchange'=> $this->Js->request(array('action' => 'getcorpsublocation','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocation', 'data' => 
	'{ajaxcorporateid:$("#subLocation").val()}', 'dataExpression' => true, 'div'=>false)))); 

	//echo $this->Form->input('PatientRegistrationReport.corporate_id', array('style'=>'width:60%;','label'=>false,'div'=>false, 'empty'=>__('Select Corporate'),'options'=>$corporatelist,'id' => 'subLocation'));
?>

<span id="changeCorporateSublocation">
</span>