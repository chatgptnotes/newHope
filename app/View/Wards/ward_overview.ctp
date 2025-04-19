<?php  echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
	 echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
	 echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>
 <style>
 .loginContainer {
    position:relative;
    float:right;
    font-size:12px;
    margin-top:40px;
    z-index:100;
}



/* A Line added to overlap the border */
#loginButton.active em {
    position:absolute;
    width:100%;
    height:1px;
    background:#ffffff;
    bottom:-1px;
}

/* Login Form */
.loginForm {
    width:338px; 
    border:1px solid #000000;
    border-radius:3px 3px 3px 3px;
    -moz-border-radius:3px 3px 3px 3px;
    -webkit-border-radius:3px 3px 3px 3px;
    -o-border-radius:3px 3px 3px 3px;
    margin-top:-1px;
    background:#ffffff;
    padding:6px;
    -moz-box-shadow:    0px 0px 3px 2px #3C3C3C;
  	-webkit-box-shadow: 0px 0px 3px 2px #3C3C3C;
  	box-shadow:         0px 0px 3px 2px #3C3C3C;
}

.loginForm fieldset {
    margin:0 0 12px 0;
    display:block;
    border:0;
    padding:0;
}

fieldset#body {
    background:#fff;
    border-radius:3px;
    -moz-border-radius:3px;
    padding:10px 13px;
    margin:0;
}

.loginForm #checkbox {
    width:auto;
    margin:1px 9px 0 0;
    float:left;
    padding:0;
    border:0;
    *margin:-3px 9px 0 0; /* IE7 Fix */
}

.loginForm .label {
    color:#3a454d;
    margin:0 0 0 0;
    display:block;
    float:left;
    width:100px;
   margin-bottom:5px;	
   font-weight:normal;
}

/*.loginForm #body fieldset label {
    display:block;
    float:none;
    margin:0 0 6px 0;
}*/
.loginForm .content{
	float:left;
	color:#3a454d;	
	width:200px;	
	margin-bottom:5px;	
	
}
/* Default Input */
.loginForm input {
    width:92%;
    border:1px solid #899caa;
    border-radius:3px;
    -moz-border-radius:3px;
    color:#3a454d;
    font-weight:bold;
    padding:8px 8px;
    box-shadow:inset 0px 1px 3px #bbb;
    -webkit-box-shadow:inset 0px 1px 3px #bbb;
    -moz-box-shadow:inset 0px 1px 3px #bbb;
    font-size:12px;
}

/* Sign In Button */
.loginForm #login {
    width:auto;
    float:left;
    background:#339cdf;
	background-image: -ms-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -moz-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -o-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #59ACEA), color-stop(1, #0197D8));
	background-image: -webkit-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: linear-gradient(top, #59ACEA 0%, #0197D8 100%);
    color:#fff;
	font-size:13px;
    padding:7px 10px 8px 10px;
    text-shadow:0px -1px #278db8;
    border:1px solid #339cdf;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    margin:0 12px 0 0;
    cursor:pointer;
    *padding:7px 2px 8px 2px; /* IE7 Fix */
}

/* Forgot your password */
.loginForm span {
    text-align:center;
    display:block;
    padding:7px 0 4px 0;
}

.loginForm span a {
    color:#3a454d;
    text-shadow:1px 1px #fff;
    font-size:12px;
}

input:focus {
    outline:none;
}
.loginBox {
     display:none;
    position: absolute;
    right: 0;
    top: 34px;
    z-index: 29;
}
.proHead{
	font-size:14px;
	font-weight:bold;
	color:#000000;
	padding:5px 0;
}
.profImg{
	width:150px;
	float:left;	
}
.profText{
	width:300px;
	float:right;	
}
.blueBtn {
    -moz-border-radius: 4px 4px 4px 4px;
    background: url("../img/submit-bg.gif") repeat-x scroll center center #A1B6BE;
    border: 1px solid #B0C0C5;
    color: #000000;
    cursor: pointer;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 0;
    margin: 10px;
    overflow: visible;
    padding: 3px 12px;
    text-shadow: 1px 1px 2px #E2E8EA;
    text-transform: none;
  }  
  
   
 </style>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Room Overview', true); ?></h3>
	<span>
	<?php 
		
		            		//echo $this->Html->link('Ward Mgmt',array('action'=>'ward_occupancy'),array('escape'=>false,'class'=>"blueBtn"));		            
		            	//	echo $this->Html->link('Ward Occupancy',array('action'=>'ward_management'),array('escape'=>false,'class'=>"blueBtn"));
		            	//	echo $this->Html->link('Ward Master',array('action'=>'index','admin'=>true),array('escape'=>false,'class'=>"blueBtn"));
		            		 
		 
	?>
	</span>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div> 
  </td>
 </tr>
</table>
<?php } ?> 
  
		     
			<!--
			BOF Pankaj
			-->
			<?php 
				$i=0;
	            $currentWard =0;
	             //count no of bed per ward
	                 	 
	            foreach($bedData as $roomKey =>$roomVal){
	                     $roomArr[$roomVal['Bed']['id']] = $roomVal; 
	            } 
			?> 
			<div class="clr"></div>
			<div  >
                   	  
                        <div class="tdLabel2" style="float:right;">
                         <table width="" style="color:#A8B9BE;">
                            <tr>
                                 <td width="10" class="roomAvail">&nbsp;</td>
                                    <td width="70">Available</td>
                                  <td width="10" class="roomOccupied">&nbsp;</td>
                                    <td width="70">Occupied</td>
                                    <td width="10" class="roomTotal">&nbsp;</td>
                                    <td width="70">Total </td>
                                    <td width="105" align="right" class="tdLabel2" style="text-align:right;">Total Beds : 
                                    <strong><?php echo count($bedData); ?></strong></td>
                            </tr>
                          </table>
                        </div>
                        <div class="clr"></div>
                  	</div>
                   <div class="clr ht5"></div> 
                    <table width="95%" cellpadding="0" cellspacing="0" border="0" align="center">
             <?php
             $countRow= 0 ; 
             foreach($wardData as $wardKey){     
             	 
             	if($countRow%2==0){
            ?> 
                  
                  	<tr>
                  	  <td width="48%" valign="top">&nbsp;</td>
                  	  <td width="">&nbsp;</td>
                  	  <td width="48%" valign="top">&nbsp;</td>
               	    </tr>
                  	<tr>
                  	
                  	<?php
				$endHtml ="";
             	}else{
             		echo "<td>&nbsp;</td>";  
             		$endHtml ="</tr>";
             		 
             	}
             	$countRow++; 
             	$ss ='';
             	$wardTotal=0;
             	$j=0;
                           		if(!empty($wardKey['Room'])){
	                          		foreach($wardKey['Room'] as $roomKey){
	                          			$occupied =0;
							            $houseKeeping =0;
							            $waiting=0;
							            $available=0;       
							            $maintnence=0;
	                          			foreach($roomData as $key=>$value){             		 
				                            if(is_array($value) && $value['Room']['id']==$roomKey['id']){  
				                            	         
				                            	foreach($value as $bed =>$bedArray){
				                            		if($bed=='Bed' && !empty($bedArray)){
				                            			foreach($bedArray as $bedVal){ 
				                            				
				                            		 		 $class ='';
					                            			 //BOF waiting
				                            		 	     $discharge =false ;
					                            			 if(is_array($roomArr[$bedVal['id']]['WardPatient'])){
					                            			 	 foreach($roomArr[$bedVal['id']]['WardPatient'] as $wpKey){
						                            			 	   if($wpKey['is_discharge']==1){ 
									                            			  //maintain the discharge status
									                            			  $discharge =true;
						                            			 	 	}else{
						                            			 	 		$discharge =false;
						                            			 	 	}
					                            			 	 } 
						                            		 }
							                            	 //EOF waiting
					                            			 if($bedVal['patient_id']==0){
					                            			 	 //BOF housekeeping , check the bed released time.
						                            		 	 //then it shud be in housekeeping state till 45 min from released time
							                             		 //calculate time diff
							                             		 $convertDate = strtotime($bedVal['released_date']);
							                             		 $currentTime = mktime();
							                             		 $minus = $currentTime - $convertDate ; 
							                             		 $intoMin = round(($minus)/60) ;
							                             		 $notAvail=  true ;
					                            			 	 //EOF housekeeping
					                            			 	 //if($intoMin<=45 && $bedVal['is_released']==0){
					                            			 	 /*if($bedVal['is_released']==0){
							                            			 	$class = 'hsKeeping';
							                            			 	$notAvail=  false ;
				                            		 					$bedCount[] = $houseKeeping++ ; 
									                             }else*/ if($bedVal['is_released']==1){
									                             	$class = 'bedWait';
									                             	$notAvail=  false ;
									                             	$waiting++;
									                             }
									                             
									                             if($bedVal['under_maintenance']==1){
					                            			 		$class = 'bedMaintain';
					                            			 		$maintnence++;
					                            			 	 }else if($notAvail){
					                            			 		$class = 'bedAvail';
					                            			 		$available++;
					                            			 	 }
					                                   		 }else{ 
						                            				$occupied++; 	 			                            			 	  
										                     } 
									                     }
							                          } 
							                      }
						                      } 
				             				}	 
		                          			?>
				                       		 
				                           	<?php
				                           	 $occBed = (int)$occupied+(int)$houseKeeping+(int)$waiting+(int)$maintnence;
				                           	 $total =(int)$occBed+(int)$available ; 
				                           	 $wardTotal  = $wardTotal+$total ; 
				                           	 $roomHtml = '<div class="roomName">';
		                                	 $roomHtml .= '<div class="room">'.$roomKey['name'].'</div>';
		                              	     $roomHtml .='<div class="clr"></div>';
	                                         $roomHtml .='<div class="roomStatus">';
	                                         $roomHtml .= '<table width="" cellpadding="0" cellspacing="0" border="0" align="center">';
		                                     $roomHtml .=   '<tr><td width="17" align="center">'.$available.'</td>';
		                                     $roomHtml .= '<td width="17" align="center">'.$occBed.'</td>';
		                                     $roomHtml .= '<td width="17" align="center">'.$total.'</td>';                                      
	                                         $roomHtml .=  '</tr>';
	                                         $roomHtml .=     '<tr>';
	                                         $roomHtml .=      '<td align="center" class="roomAvail">&nbsp;</td>';
	                                         $roomHtml .=      '<td align="center" class="roomOccupied">&nbsp;</td>';
	                                         $roomHtml .=         '<td align="center" class="roomTotal">&nbsp;</td>';
	                                         $roomHtml .=      '</tr>';
	                                         $roomHtml .= '</table>';
	                                         $roomHtml .= '</div>';
	                          				 $roomHtml .= '</div>';
	                          				 
	                           				$ss  .= $roomHtml ; 
	                           			} //EOF foreach 
                          			}//EOF if
                          			 ?>
             	
                  	  <td valign="top"><table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                        <tr>
                          <th>
                            	<div style="float:left;"><?php  echo $wardKey['Ward']['name']; ?></div>
                              	<div style="float:right; font-weight:normal;">Beds : <strong><?php echo $wardTotal ;?></strong></div>
                          </th>
                        </tr>
                        <tr>
                          <td>
                          	 <?php 
                          	 		if($ss){echo $ss ;}
                          	 		else{
                          	 			 
                          				echo "<div align='center'>";
                          				echo "<strong>No Room Added </strong>";
                          				echo "</div>";
                          				 
                          	 		}
                          	 
                          	 ?>
	                          </td>
	                        </tr>
	                      </table></td> 
             	<?php
             	echo $endHtml ;
             }
			//EOF new code
			?>
			 </table>
             <div class="clr">&nbsp;</div>    
		 
   
 
  <script>
  jQuery(document).ready(function(){
	   
		  $('.bedOcup').mouseover(function(){
			  $('.loginForm').hide();
			  var currentID = $(this).attr('id');
			  var pos = 	$(this).position();
			    
			  var cc = $('#loginBox-'+currentID)
			  cc.css('top',pos.top+30); 
			  cc.css('left',pos.left); 
			  cc.css('right',pos.right); 
			  cc.show(); 
		  }); 
			
		  $('.loginForm').mouseout(function(){
			  $(this).hide(); 
		  });

		  

	  	  	
		//BOF pan test 
		  $(".tabularForm").hover(function(login) {
			 
		        if(!($(login.target).parent('.bedOcup').length > 0)) {
		        	$('.loginForm').hide();
				}
		  });
		  
		  $(".bedAvail").hover(function(login) {
				 
		        if(!($(login.target).parent('.bedOcup').length > 0)) {
		        	$('.loginForm').hide();
				}
		  });
		  $(".bedMaintain").hover(function(login) {
				 
		        if(!($(login.target).parent('.bedOcup').length > 0)) {
		        	$('.loginForm').hide();
				}
		  });
		  
 			//EOF pan test
 			
		  
  });

	$(function() { 
	    var button = $('.bedOcup');
	    var currentID = $(this).attr('id');
		var box = $('#loginBox-'+currentID)
	    
	    var form = $('.loginForm');
	    
	    button.removeAttr('href');
	    button.mouseup(function(login) {
	    
	   // box.toggle(); 
	    button.toggleClass('active');
	    });
	    form.mouseup(function() { 
	        return false;
	    });
	    $(this).mouseup(function(login) {
	        if(!($(login.target).parent(this).length > 0)) {
	            button.removeClass('active'); 
	            box.hide();
	           // box.css('height','0px');   
	           // $("#loginForm").validationEngine('hide');
	        }
	    });
	});
</script>
