<?php	
	if($dropdown == 'State'){
		/* if($controllertype == "hospitals") {
			echo $this->Form->input('Facility.state_id', array('class' => 'validate[required,custom[customstate]] textBoxExpnd1', 'options' => $data, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'City','controllertype'=>'hospitals','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
		}elseif ($controllertype == "doctors") {
			echo $this->Form->input('DoctorProfile.state_id', array('options' => $data, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'app','action' => 'get_state_city','reference'=>'City','controllertype'=>'doctors','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
		} else {
			echo $this->Form->input('User.state_id', array('options' => $data, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'City','controllertype'=>'users','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
		} */
		//removed ajax call for city 
		if($controllertype == "hospitals") {
			echo $this->Form->input('Facility.state_id', array('class' => 'validate[required,custom[customstate]] textBoxExpnd', 'options' => $data, 'empty' => 'Select State',
					 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
		}elseif ($controllertype == "doctors") {
			echo $this->Form->input('DoctorProfile.state_id', array('options' => $data, 'empty' => 'Select State', 'id' => 'customstate','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 
					'error' => false ));
		} else {
			echo $this->Form->input('User.state_id', array('options' => $data, 'empty' => 'Select State', 'id' => 'customstate','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false ));
		}
	} else if($dropdown == 'City'){
		if($controllertype == "hospitals") {
			echo $this->Form->input('Facility.city_id', array('class' => 'validate[required,custom[customcity]] textBoxExpnd', 'options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
		}elseif($controllertype == "doctors")  {
			echo $this->Form->input('DoctorProfile.city_id', array('options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
		} else {
			echo $this->Form->input('User.city_id', array('options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
		}
	}
  ?> 
  
  