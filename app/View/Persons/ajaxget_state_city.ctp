<?php	
//debug($reference_id);
	if($dropdown == 'State' || $dropdown == 'guar_state' || $dropdown == 'gau_state'){
		if($controllertype == "hospitals") {
                   echo $this->Form->input('Facility.state_id', array('class' => 'validate[required,custom[customstate]] textBoxExpnd', 'options' => $data, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'City','controllertype'=>'hospitals','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate1").val()}', 'dataExpression' => true, 'div'=>false))));
		}elseif ($controllertype == "doctors") {
	echo $this->Form->input('DoctorProfile.state_id', array('options' => $data, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'app','action' => 'get_state_city','reference'=>'City','controllertype'=>'doctors','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
		} else {
		if($reference_id == '2' || $reference_id == 'USA'){
			if($dropdown == 'State') {$dropdown1 = 'customstate';$dropdown = 'state'; $model = 'Person';}
			if($dropdown == 'guar_state') {$dropdown1 = 'guar_state';$dropdown = 'guar_state'; $model = 'Guardian';}
			if($dropdown == 'gau_state') {$dropdown1 = 'gau_state';$dropdown = 'gau_state'; $model = 'Guarantor';}
	echo $this->Form->input($model.'.'.$dropdown, array('class'=>'textBoxExpnd','options' =>  $data, 'empty' => 'Select State', 'id' => $dropdown1, 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'City','controllertype'=>'persons','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
	}
	else{
	echo $this->Form->input('Person.state', array('class'=>'textBoxExpnd','options' =>  array_combine($data,$data), 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'City','controllertype'=>'persons','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
	}
		}
	} else if($dropdown == 'City'){
		if($controllertype == "hospitals") {
                   echo $this->Form->input('Facility.city_id', array('class' => 'validate[required,custom[customcity]] textBoxExpnd', 'options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
		}elseif($controllertype == "doctors")  {
			echo $this->Form->input('DoctorProfile.city_id', array('options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));	
		} else {
			echo $this->Form->input('User.city_id', array('class'=>'textBoxExpnd','options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));	
		}
	} 
	
	if($dropdown == 'State1'){
		if($controllertype == "hospitals") {
			echo $this->Form->input('Facility.state_id_second', array('class' => 'validate[required,custom[customstate]] textBoxExpnd', 'options' => $data, 'empty' => 'Select State', 'id' => 'customstate2', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city1','reference'=>'City','controllertype'=>'hospitals','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate2").val()}', 'dataExpression' => true, 'div'=>false))));
		}elseif ($controllertype == "doctors") {
			echo $this->Form->input('DoctorProfile.state_id_second', array('options' => $data, 'empty' => 'Select State', 'id' => 'customstate2', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'app','action' => 'get_state_city','reference'=>'City','controllertype'=>'doctors','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate2").val()}', 'dataExpression' => true, 'div'=>false))));
		} else {
			if($reference_id == '2'){
				echo $this->Form->input('Person.state_second', array('class'=>'textBoxExpnd','options' =>  $data, 'empty' => 'Select State', 'id' => 'customstate2', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city1','reference'=>'City','controllertype'=>'persons','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate2").val()}', 'dataExpression' => true, 'div'=>false))));
			}
			else{
				echo $this->Form->input('Person.state_second', array('class'=>'textBoxExpnd','options' =>  array_combine($data,$data), 'empty' => 'Select State', 'id' => 'customstate2', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city1','reference'=>'City','controllertype'=>'persons','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate2").val()}', 'dataExpression' => true, 'div'=>false))));
			}
		}
	} else if($dropdown == 'City'){
		if($controllertype == "hospitals") {
			echo $this->Form->input('Facility.city_id_second', array('class' => 'validate[required,custom[customcity]] textBoxExpnd', 'options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
		}elseif($controllertype == "doctors")  {
			echo $this->Form->input('DoctorProfile.city_id_second', array('class'=>'textBoxExpnd','options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
		} else {
			echo $this->Form->input('User.city_id_second', array('class'=>'textBoxExpnd','options' => $data,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
		}
	}
  ?>
  
  