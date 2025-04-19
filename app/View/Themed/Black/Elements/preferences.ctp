<?php
if($this->name != "Preferences"){
$preference_data = unserialize($this->Session->read('preferences'));
 if($preference_data['mode'] == "Custom"){echo "sdssssd";
		$script = "<script>";
		if(!empty($preference_data['backgroundColor'])){
			$script .= "document.body.style.background = '".$preference_data['backgroundColor']."';";  
		} 
		if(!empty($preference_data['fontColor'])){
			$script .= "$('body').find('*').filter(function() {
				  $(this).css('color','".$preference_data['fontColor']."');
			});";		
		}	
		if(!empty($preference_data['HeaderbackgroundColor'])){
			$script .= " $('.header_internal').css('background', '".$preference_data['HeaderbackgroundColor']."');";
		}
		if(!empty($preference_data['menuNavigation']) || $preference_data['menuNavigation'] != "Left" ){
			if($preference_data['menuNavigation'] == "Right"){
					$script .= " $('.left_template').insertAfter($('.rightTopBg'));";				 
			}
			if($preference_data['menuNavigation'] == "Bottom"){
					$script .= " var left = $('.left_template');$('.left_template').remove();";					
					$script .= " $('#main-grid').append('<tr id=\"bottom-row\"></tr>'); ";		
					$script .= "$('#bottom-row').append(left);";
			}
			if($preference_data['menuNavigation'] == "Top"){
					$script .= " var right = $('.rightTopBg');$('.rightTopBg').remove();";					
					$script .= " $('#main-grid').append('<tr id=\"bottom-row\"></tr>'); ";		
					$script .= "$('#bottom-row').append(right);";
			}
		}	
		
	   $script .= "</script>";
	   
	   $script .= "<style>";
	   if(!empty($preference_data['BackgroundColorforInputField'])){
			$script .= ".textBoxExpnd,input[type='text'],select,textarea {background: none repeat scroll 0 0 ".$preference_data['BackgroundColorforInputField']." !important;}\n";	
			$script .= ".textBoxExpnd,input[type='text'],select,textarea {background: none repeat scroll 0 0 ".$preference_data['BackgroundColorforInputField']." !important;}\n";
	   }
		if(!empty($preference_data['textColorforInputField'])){
			$script .= ".textBoxExpnd,input[type='text'],select,option,textarea {color: ".$preference_data['textColorforInputField']." !important;}\n";
		}	
		if(!empty($preference_data['fontColor'])){	 
			$script .= "label,p,td,strong {color:".$preference_data['fontColor'].";}\n";
		}	
		if(!empty($preference_data['BackgroundColorforleftPanel'])){	 
			$script .= ".left_template{background-color:".$preference_data['BackgroundColorforleftPanel'].";background:'';background-image:none}\n";
		}	
		if(!empty($preference_data['BackgroundColorforRightPanel'])){	 
			$script .= ".rightTopBg{background-color:".$preference_data['BackgroundColorforRightPanel'].";background:'';background-image:none}\n";
		}	
					
		
		$script .= "</style>";
	   echo $script;
   }
  }
?>
 