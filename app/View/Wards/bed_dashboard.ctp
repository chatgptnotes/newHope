<?php
     echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	 echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));?>
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
    width:260px; 
    border:1px solid #000000;
    border-radius:3px 3px 3px 3px;
    -moz-border-radius:3px 3px 3px 3px;
    -webkit-border-radius:3px 3px 3px 3px;
    -o-border-radius:3px 3px 3px 3px;
    margin-top:-1px;
    background:#ffffff;
    /*padding:6px;*/
    -moz-box-shadow:    0px 0px 3px 2px #000;
  	-webkit-box-shadow: 0px 0px 3px 2px #000;
  	box-shadow:         0px 0px 3px 2px #000;
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
     color: #3a454d;
    display: block;
    float: left;
    font-weight: normal;
    margin: 0 0 5px;
    width: 100px;
}

/*.loginForm #body fieldset label {
    display:block;
    float:none;
    margin:0 0 6px 0;
}*/
.loginForm .content{
	color: #3a454d;
    float: initial;
    margin-bottom: 5px;
    width: 251px;
	
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
	float: right;
    width: 252px;	
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
    .headingLoc {
     background: none repeat scroll 0 0 #d2ebf2 !important;
    border-bottom: 1px solid #3e474a;
    color: #31859c !important;
    font-size: 12px;
    padding: 5px 8px;
    text-align: left;
}
.bedInfo{
	margin-top: 56px;
	height: 10px;
	width: 100%;
	font-size: 13px;
	color:#800080;
}

 </style>
 
<div class="inner_title">
<h3>&nbsp; <?php echo __('Bed Dashbord') ; ?></h3>
<span>
	<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
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
<?php  }  ?> 
   
              <table width="" cellpadding="0" cellspacing="0" border="0" align="right">
                     <tr>
                         <td width="33"><div class="bedWait"></div></td>
                            <td width="65" class="tdLabel2">Available</td>
                            <td width="33"><div class="bedAvail"></div></td>
                            <td width="70" class="tdLabel2">Occupied</td>
                            <td width="33"><div class="bedOcup "></div></td>
                            <td width="70" class="tdLabel2">Overstay</td>
                            <td width="33"><div class="bedMaintain"></div></td>
                             <td width="70" class="tdLabel2">Maintenance</td>
                         <!--<td width="33"><div class="hsKeeping"></div></td>
                            <td width="70" class="tdLabel2">Housekeeping</td>-->
                        </tr>
                      
                 </table>
             <table width="100%" cellpadding="5" cellspacing="5" border="0">
                  	
             <?php  
             	//hidden ele to maintain selected patient
             	echo $this->Form->hidden('selectedPatient',array('id'=>'selectedPatient','value'=>'','autocomplete'=>"off"));
				echo $this->Form->hidden('selectedBed',array('id'=>'selectedBed','value'=>'','autocomplete'=>"off"));
             	echo $this->Form->hidden('dischargePatient',array('id'=>'dischargePatient','value'=>'','autocomplete'=>"off")); ?>
           
           <?php foreach($bedData as $roomKey =>$roomVal){ 
                  	   $roomArr[$roomVal['Bed']['id']] = $roomVal; 
                }
                $TotalBed = 0;
                $vacentBed =0;
                $occupiedtBed =0;
                $overStayBed =0;
                $actualBed =0;
                $maintenance =0;
                 $TotalBed =count($bedData);
                      
              if(!empty($rooms)){    
				         	
             	foreach($rooms as $key=>$value){
				?>
				<?php /*if($key == 0 or $oldLocation != $value['Room']['location_id']){?>
				<tr><th class="headingLoc" colspan="3"><?php echo $location[$value['Room']['location_id']]?></th></tr>
				<?php $oldLocation = $value['Room']['location_id'];
				}*/ ?>
				<?php 
             		$endHtml = '';
	             	if(($key%2) == 0){
	             		if($key>1) echo "</tr>"; 
	             		?>
	             		<tr>
	                    <td width="370" valign="top" style="min-width:370px;">
	             		<?php
	             		$endHtml =  '</td><!--<td width="30" style="min-width:30px;">-->';
	             		 
	             	}else{ ?>
	             		 
	                    </td>
	                    <td width="370" valign="top" style="min-width:370px;">
	             	<?php 
	             		$endHtml = "</td>";
	             	}	
             ?>  
             <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                 <tr>
                 	<th><?php  echo  $value['Ward']['name']."&nbsp-&nbsp".$value['Room']['name'];?></th>
                 </tr>
                 <tr>
                 	<td>
                       <?php 
                            if(is_array($value)){
                            foreach($value as $bed =>$bedArray)
                            {                            	
                            	if($bed=='Bed' && !empty($bedArray)){
                            		 foreach($bedArray as $bedVal){
                            		 		 $class ='';
                            		 		 #debug($roomArr[$bedVal[id]][TariffList]);
                            		 	     //BOF waiting
                            		 	     /*$discharge =false ;
	                            			 if(is_array($roomArr[$bedVal['id']]['WardPatient'])){
	                            			 	 foreach($roomArr[$bedVal['id']]['WardPatient'] as $wpKey){
	                            			 	 	if($wpKey['is_discharge']==1){ 
				                            			//maintain the discharge status
				                            			$discharge =true;
	                            			 	 	}else{
	                            			 	 		$discharge =false;
	                            			 	 	}
	                            			 	 } 
		                            		 }*/
			                            	 //EOF waiting
	                            			 if($bedVal['patient_id']==0){
												$occupiedtBed++;
	                            			 	 //BOF housekeeping
	                            			 	 //check the bed released time.
		                            		 	 //then it shud be in housekeeping state till 45 min from released time
			                             		 //calculate time diff
			                             		 $convertDate = strtotime($bedVal['released_date']);
			                             		 $currentTime = mktime();
			                             		 $minus = $currentTime - $convertDate ; 
			                             		 $intoMin = round(($minus)/60) ;
	                            			 	 //EOF housekeeping
	                            			 	 $notAvail=  true ;
	                            			 	 if($bedVal['is_released']==1 && $intoMin<=45){
					                             	$class = 'bedWaits';
					                             	$notAvail=  false ;
					                             	//echo "<div class=".$class." id=".$bedVal['id']." title='".$value['Room']['bed_prefix'].$bedVal['bedno']."'></div>";
					                             } 
					                             if($bedVal['under_maintenance']==1){
														$maintenance++;
	                            			 		$class = 'bedMaintains';
	                            			 		echo "<div class=".$class." title='Maintenance'>";
	                            			 		
	                            			 	 }else if($notAvail==true){
	                            			 		$class = 'bedWaits';
	                            			 		echo "<div class=".$class." title='Available'>";
	                            			 	    //echo "<div>".$value['Room']['bed_prefix'].$bedVal['bedno']."</div>";
												} ?>
												<div class="bedInfo"><?php echo "Bed : ".$value['Room']['bed_prefix'].$bedVal['bedno'];?></div>
												<?php echo "</div>";?>
	          									<?php  }else{ 
													$calDate="";
													$noOfdays = 0;
													$noOfdays = (int) $roomArr[$bedVal[id]]['PackageEstimate']['no_of_days'] + (int) $roomArr[$bedVal[id]]['PackageEstimate']['days_in_icu'];
												if($noOfdays != 0){

													$Date = $roomArr[$bedVal['id']]['Patient']['form_received_on'];
													
													$calDate = date('Y-m-d', strtotime($Date. " + ".$noOfdays." days"));
												}    $overDay="";
													if($calDate && strtotime($calDate) < strtotime(date('Y-m-d'))){
														/** cal overstay days */
														$overDay = date_diff(date_create($calDate),date_create(date('Y-m-d')));
														$overStayBed ++;
														echo "<div class='bedOverStay' id=".$bedVal['patient_id']." title='Occupied'>" ;
													}else{ 
														$actualBed++;
														echo "<div class='bedOccupied' id=".$bedVal['patient_id']." title='Occupied'>";
													}?>           
									            	<?php if($overDay){ ?>
								            			<div class="bedInfo" style=""><?php echo "Bed : ".$value['Room']['bed_prefix'].$bedVal['bedno']."</br>"."Over Stay : ".$overDay->days;?></div>
								            		<?php }else{ ?>
								            		<div class="bedInfo"><?php echo "Bed : ".$value['Room']['bed_prefix'].$bedVal['bedno'];?></div>
								            		<?php }?>
								            		<div style="clear:both"></div>	           
									            	<div class="loginBox loginForm" id="loginBox-<?php echo $bedVal['patient_id'] ; ?>">
										               <div class="profText">
										                			<div class="proHead"><b>Patient Details</b></div>
										                			<div class="clr"></div>
											                
											                		<div class="label"><strong>Name</strong></div>
											                		<div class="content"><strong><?php echo $roomArr[$bedVal['id']]['PatientInitial']['name'].' '.ucfirst($roomArr[$bedVal['id']]['Patient']['lookup_name']) ;?></strong></div>
											                		<div class="clr"></div>
											               			 <div class="label"><strong>Admission Id</strong></div>
											                		<div class="content"><strong><?php echo $roomArr[$bedVal['id']]['Patient']['admission_id'] ;?></strong></div>
											                		<div class="clr"></div>
											                		<div class="label"><strong><?php echo __("Patient Id")?></strong></div>
											                		<div class="content"><strong><?php echo $roomArr[$bedVal['id']]['Patient']['patient_id'] ;?></strong></div>
											                		<div class="clr"></div>
											                		
											                	<!--<div class="label"><strong>Age</strong></div>
											                		<div class="content"><strong><?php echo /* $this->General->getCurrentAge( */$roomArr[$bedVal['Person']['age']]/*)*/ ;?></strong></div>
											                		<div class="clr"></div>
											                		<div class="label"><strong>Visit ID</strong></div>
											                		<div class="content"><strong><?php echo $roomArr[$bedVal['id']]['Patient']['admission_id'] ;?></strong></div>
											                		<div class="clr"></div>
											                													                		
											                		<div class="label"><strong>Sex</strong></div>
											                		<div class="content"><strong><?php echo ucfirst($roomArr[$bedVal['id']]['Patient']['sex']) ;?></strong></div>
											                		<div class="clr"></div>
											                		
											                	 	<div class="label"><strong>Diagnosis</strong></div>
											                		<div class="content"><strong><?php echo $roomArr[$bedVal['id']]['Diagnosis']['final_diagnosis'] ;?></strong></div>
											                		<div class="clr"></div>
											                		
											                		<div><?php echo $this->Html->link('Patient Information',array('controller'=>'persons','action'=>'patient_information',$roomArr[$bedVal['id']]['Person']['id'],'?'=>array('Ward'=>$this->params->query['Ward'])),array('escape'=>false,'class'=>'blueBtn'))?></div> -->
											           </div>
											           
											           <div class="clr"></div>
											            
								            		</div> 
								            		<?php
								            		 echo "</div>";
					                        }
					                        
                            		 	 }
			                         } 
			                     }
		                      }?>
		                                    </td>
		                              </tr>
		                   </table> </td></tr>
		               
             <?php 
             		//echo $endHtml;
             	} 
             	?>
             
               <!--    <tr><td colspan="3"> 
                   	<div align="right">
                   		<?php  //echo $this->Html->link('Back',$moveBack, array('escape' => false,'class'=>"blueBtn"));?>
                   		<?php echo $this->Html->link('Back',array('action'=>'ward_occupancy'),array('escape'=>true,'class'=>'blueBtn'));?>
                   		<input name="" type="button" value="Release" class="blueBtn" id="release"/>
                   		<input name="" type="button" value="Transfer" class="blueBtn" id="transfer"/>
                   		  <input name="" type="button" value="Transfer to OT" class="blueBtn" id="transferToOT"/>
					</div>
                   </td>
                   </tr> -->
                    <?php 
               }?>     	 
                  </table>
   <table width="100%" cellpadding="5" cellspacing="0" border="0"
	style="background-color: #c9c9c9;">
	<tr>
		<td width="" class="tdLabel2"><strong>Quick Info &raquo;</strong></td>
		<td width="" class="tdLabel2"><strong></strong> <?php echo $overStayBed; ?> Over stay </td>
		
		<td width="" class="tdLabel2"><?php echo $actualBed;?> Occupied </td>
		<td width="" class="tdLabel2"><strong></strong> <?php echo $occupiedtBed ?> Free</td>
		<td width="" class="tdLabel2"><?php  echo $maintenance; ?> Maintenance</td>
		<td width="" class="tdLabel2"><?php  echo $TotalBed; ?> Total</td>
		
		<td>&nbsp;</td>
	</tr>
</table>                 
                   
                  
        
  
  <script>
  jQuery(document).ready(function(){
                  <?php if($this->params['data']['otpatientid']) { ?> 
	          $('#<?php echo $this->params['data']['otpatientid']; ?>').addClass('active bedOcupSelected');
                  <?php } ?>
		  $('.bedOccupied, .bedOverStay').mouseover(function(){
			  $('.loginForm').hide();
			  var currentID = $(this).attr('id');
			  var pos = 	$(this).position();
			    
			  var cc = $('#loginBox-'+currentID);
			  cc.css('top',pos.top+75); 
			  cc.css('left',pos.left); 
			  cc.css('right',pos.right); 
			  cc.show(); 
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
		    
		  $('.loginForm').mouseout(function(){
			  $(this).hide(); 
		  });

		  if($('#selectedPatient').val() != ''){
			  $("#"+$('#selectedPatient').val()).removeClass("bedOcup").addClass("bedOcupSelected");
		  }
		  
		  $('.bedOcup').click(function(){ 
			  $('.loginForm').hide();
			  if($(this).attr('class')=='bedOcup bedOcupSelected'){
				  $(this).removeClass("bedOcupSelected").addClass("bedOcup"); 
				  $('#selectedPatient').val('');
			  }else{
				  $('.bedOcupSelected').each(function(index) {
					  $(this).removeClass("bedOcupSelected").addClass("bedOcup");
		  	  	  });
				  $('.hKeepingSelected').each(function(index) {
					  $(this).removeClass("hKeepingSelected").addClass("bedWait");
		  	  	  }); 
				 
				  $(this).removeClass("bedOcup").addClass("bedOcup bedOcupSelected"); 
				  $('#selectedPatient').val($(this).attr('id'));
				  $('#dischargePatient').val('');
				  $('#selectedBed').val('');
			  } 
		  }); 
		  //BOF housekeeping
					 
		  $('.bedWait').click(function(){
			  $('.loginForm').hide();
			  if($(this).attr('class')=='bedWait hKeepingSelected'){
				  $(this).removeClass("hKeepingSelected").addClass("bedWait"); 
				  $('#dischargePatient').val('');
			  }else{
				  
				  $('.hKeepingSelected').each(function(index) {
					  $(this).removeClass("hKeepingSelected").addClass("bedWait");
		  	  	  }); 
				  $('.bedOcupSelected').each(function(index) {
					  $(this).removeClass("bedOcupSelected").addClass("bedOcup");
		  	  	  });
		  	  	 
				  $(this).removeClass("bedWait").addClass("bedWait hKeepingSelected"); 
				  $('#dischargePatient').val($(this).attr('id'));
				  $('#selectedBed').val($(this).attr('id'));
				  $("#selectedPatient").val('');
			  } 
			  
		 });
			 
		 
		  //EOF housekeeping  

		  $('#release').click(function(){
			    var bed_id = $('#selectedBed').val() ;
				if(bed_id==''){
					alert("Please select bed ");
					return false ;
				}
				window.location = "<?php echo $this->Html->url(array("controller" => 'wards', "action" => "release_bed", "admin" => false)); ?>"+"/"+bed_id ;
				/*$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'wards', "action" => "release_bed", "admin" => false)); ?>"+"/"+bed_id,
					  context: document.body,				  		  
					  success: function(data){
						  alert('Selected Bed has been successfully realsed');
					  }
				});*/
		  });
		  
		  $('#transfer').click(function(){
			    var patient_id = $('#selectedPatient').val() ;
				 
			    var wardNameOR="<?php echo $wardName;?>";
			    if(wardNameOR=='Operating Room'){
				   var  wardNameORoom=wardNameOR;
			    }
				if(patient_id==''){
					alert("Please select patient");
					return false ;
				}
				$.fancybox({
		            'width'    : '90%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',
				    'type': 'iframe',
				    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_transfer")); ?>"+'/'+patient_id+'/'+wardNameORoom 
			    });
				
		  });
		  $('#transferToOT').click(function(){
			    var patient_id = $('#selectedPatient').val() ;
			    var wardNameOR="<?php echo $wardName;?>";
			    if(wardNameOR=='Operating Room'){
				   var  wardNameORoom=wardNameOR;
			    }
				if(patient_id==''){
					alert("Please select patient");
					return false ;
				}
				$.fancybox({
		            'width'    : '90%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',
				    'type': 'iframe',
				    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "optPatients")); ?>"+'/'+patient_id+'/'+wardNameORoom 
			    });
				
		  });
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

	    $("#ward_id").change(function(){ 
		    id =$(this).val();
		    window.location.href = '?Location='+id;
		});
	});
	</script>
