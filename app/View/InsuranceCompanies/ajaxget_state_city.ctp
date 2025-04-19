<?php	
	if($dropdown == 'State'){
       echo $this->Form->input('InsuranceCompany.state_id', array('class' => 'validate[required,custom[customstate]]', 'options' => $data, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('action' => 'get_state_city','reference'=>'City','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
	} else if($dropdown == 'City'){
		echo $this->Form->input('InsuranceCompany.city_id', array('class' => 'validate[required,custom[customcity]]', 'options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));	
	} 
  ?>