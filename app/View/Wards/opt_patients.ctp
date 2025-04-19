
<?php 
 	 echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3','jquery.ui.widget','jquery.ui.mouse','jquery.ui.core'));
	 echo $this->Html->css(array( 'jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css')); 
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4' )); ?>
	 
	 
 <style>
 .loginContainer {
    position:relative;
    float:right;
    font-size:12px;
    margin-top:40px;
    z-index:100;
}

/* Login Button */
#loginButton { 
    display:inline-block;
    float:right;
    background:#ffffff; 
    border:1px solid #cacaca; 
    border-radius:3px;
    -moz-border-radius:3px;
    position:relative;
    z-index:30;
    cursor:pointer;
}

/* Login Button Text */
#loginButton span {
    color:#0c8dc5; 
    font-size:14px; 
    font-weight:bold; 
    text-shadow:1px 1px #fff; 
    padding:7px 25px 9px 10px;
    background:url(../img/loginArrow.png) no-repeat 60px 9px;
    display:block
}

#loginButton:hover {
    background:#ffffff;
}

/* Login Box */
/*#loginBox {
    position:absolute;
    top:34px;
    right:0;
    display:none;
    z-index:29;
}*/

/* If the Login Button has been clicked */    
#loginButton.active {
    border-radius:3px 3px 0 0;
}

#loginButton.active span {
    background-position:60px -78px;
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
    width:248px; 
    border:1px solid #cacaca;
    border-radius:3px 0 3px 3px;
    -moz-border-radius:3px 0 3px 3px;
    margin-top:-1px;
    background:#ffffff;
    padding:6px;
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

#body label {
    color:#3a454d;
    margin:9px 0 0 0;
    display:block;
    float:left;
}

.loginForm #body fieldset label {
    display:block;
    float:none;
    margin:0 0 6px 0;
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

#WardWardId{
	margin:10px 0px 0px 20px;
}

 </style>
 <!--[if IE]>
 <style>
 	#WardWardId{
		margin:2px 0px 0px 20px;
	} 
 </style>
 <![endif]-->
 

	 
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Patient Transfer To OT', true); ?></h3>
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
<p class="ht5"></p>
	      
  <?php 
  	//echo $this->element('patient_information');
   
  echo $this->Form->create('Ward',array('url'=>array('controller'=>'wards','action'=>'optPatients',$patient_id),'id'=>'ward','inputDefaults'=>array(
  		'div'=>false,'error'=>false,'label'=>false,'style'=>'')));
  $curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
  echo $this->Form->hidden('OptPatient.patient_id',array('value'=>$patient_id,'type'=>'text')) ;
  echo $this->Form->hidden('OptPatient.opt_appointment_id',array('value'=>$opt_appt_id,'type'=>'text')) ;
  echo $this->Form->hidden('selectedBed',array('id'=>'selectedBed','div'=>false,'error'=>false,'label'=>false,'value'=>''));
  ?>
  <table width="" cellpadding="0" cellspacing="0" border="0" align="right">
                     <tr>
                         <td width="33"><div class="bedAvail"></div></td>
                            <td width="65" class="tdLabel2">Available</td>
                            <td width="33"><div class="bedOcup"></div></td>
                            <td width="70" class="tdLabel2">Occupied</td>
                            <td width="33"><div class="bedWait"></div></td>
                            <td width="70" class="tdLabel2">Waiting</td>
                            <td width="33"><div class="bedMaintain"></div></td>
                            <td width="70" class="tdLabel2">Maintenance</td>
                           <td width="33"><div class="hsKeeping"></div></td>
                            <td width="70" class="tdLabel2">Housekeeping</td>
                        </tr>
                   </table>
  <table>
  
  	<tr>
  		<td><?php echo $this->Form->input('OptPatient.in_time', array('type'=>'text','id'=>'in_time','class'=> 'textBoxExpnd in_date','label'=> false, 'div' => false, 'error' => false, 'value'=> $curentTime));?></td>
  		<!--  <td><?php echo $this->Form->input('OptPatient.opt_id',array('type'=>'select','options'=>$otRooms,'empty'=>'Please Select OT Room','class'=>'validate[required,custom[mandatory-enter-only]'/* ,'onchange'=>'this.form.submit();' */));?></td>-->
  		<td><?php echo $this->Form->input('OptPatient.surgery_id',array('type'=>'select','options'=>$surgeries,'empty'=>'Please Select Surgery','id'=>'surgeryId','class'=>'validate[required,custom[mandatory-enter-only]'/* ,'onchange'=>'this.form.submit();' */));?></td>
  		<td><input name="" type="submit" value="Transfer" class="blueBtn" id="transfer" style="margin:0px;"/></td>
  	</tr>
  
  </table> 
  <table width="90%" cellpadding="5" cellspacing="5" border="0" style="margin:20px;">
      <?php 
        if(!empty($otTable)){
	    foreach($otTable as $key=>$value){
	    	$endHtml = '';
		    if(($key%2) == 0){
		    	if($key>1) echo "</tr>";?>
		        <tr>
		        	<td width="300" valign="top">
		            <?php $endHtml =  '</td><td width="30" style="min-width:30px;">';
             }else{ ?>
             		</td>
                    <td width="300" valign="top">
             		<?php 
	             		$endHtml = "</td>";
	          }?>  
              <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
              	<tr>
                	<th><?php  echo $value['Opt']['name'];?></th>
                </tr>
                <tr>
                	<td>
                    <?php if(is_array($value)){

                            			$opt_id = $value['Opt']['id'];
	                            		foreach($value as $table =>$tableArray){
	                            			if($table=='OptTable' && is_array($tableArray)){
		                            			 foreach($tableArray as $tableVal){
		                            			 	$class ='';
		                            			  //BOF waiting
		                            		 	  /*    $discharge =false ;
			                            			 if(is_array($roomArr[$tableVal['id']]['WardPatient'])){
			                            			 	 foreach($roomArr[$tableVal['id']]['WardPatient'] as $wpKey){
					                            			 	if($wpKey['is_discharge']==1){ 
							                            			  //maintain the discharge status
							                            			  $discharge =true;
				                            			 	 	}else{
				                            			 	 		$discharge =false;
				                            			 	 	}
			                            			 	 } 
				                            		 } */
					                            	 //EOF waiting
			                            			 if($tableVal['patient_id']==0){
			                            			 	 //BOF housekeeping
			                            			 	 //check the bed released time.
				                            		 	 //then it shud be in housekeeping state till 45 min from released time
					                             		 //calculate time diff
					                             		 $convertDate = strtotime($tableVal['released_date']);
					                             		 $currentTime = mktime();
					                             		 $minus = $currentTime - $convertDate ; 
					                             		 $intoMin = round(($minus)/60) ;
					                             		  $notAvail=  true ;
			                            			 	 
														if($tableVal['is_released']==1){
							                             	$class = 'bedWait';
							                             	 $notAvail=  false ;
							                             	echo "<div class=".$class." id=".$tableVal['id']." title='".$value['Opt']['name'].$tableVal['id']."'></div>";
							                             }
							                             
							                             if($tableVal['under_maintenance']==1){
			                            			 		$class = 'bedMaintain';
			                            			 		echo "<div class=".$class." title='".$value['Opt']['name'].$tableVal['id']."'></div>";
			                            			 	 }else 
														if($notAvail){
			                            			 		$class = 'bedAvail';
			                            			 		echo "<div class=".$class." id=".$opt_id."_".$tableVal['id']." title='".$value['Opt']['name'].$tableVal['id']."'></div>";
			                            			 	 }
			                            			 }else{ 
			                            			 	echo "<div class='bedOcup' title='".$value['Opt']['name'].$tableVal['id']."'></div>";	
			                            			 	 				                            			 	  
			                            			} 
		                            			}
	                            			} 
	                            		}
                            		}?>
		                                    </td>
		                              </tr>
		                   </table> 
		               
             <?php 
	             		echo $endHtml;
             		}
             		?>
             		
                   <?php 
                }else{
                	 
                	?>
                	<tr><td class="error" id="noroomfound">No Room Found.</td></tr>
                	<?php 
                } 
             ?>          
                  	  
                  </table> 
   
   <script>
   jQuery(document).ready(function(){
		 if($('#selectedBed').val() != ''){
			  $("#"+$('#selectedBed').val()).removeClass("bedAvail").addClass("bedAvailSelected"); 
		 }
		 if($('#noroomfound').length){ 
			  $('#transfer').css('display', 'none');
		 } 
	  	$('.bedAvail').click(function(){
	  		$('.bedAvailSelected').each(function(index) {
	  			$(this).removeClass("bedAvailSelected").addClass("bedAvail");
	  		});  	
	  		$(this).removeClass("bedAvail").addClass("bedAvailSelected"); 
		  	$('#selectedBed').val($(this).attr('id'));   	
	  	});
	  	

	  	$('#transfer').click(function(){
	  		var bed_id = $('#selectedBed').val() ;
	  		var surgery_id = $('#surgeryId').val() ;
			if(bed_id==''){
				alert("Please select bed to transfer patient");
				return false ;
			}
			
			if(surgery_id==''){
				alert("Please select Surgery");
				return false ;
			}
			
			var validateWard = jQuery("#ward").validationEngine('validate');
			if (validateWard){
				$(this).css('display', 'none');
				return true;
			}else{
				return false;
			}
			 
		});
		
	});
   $(document).ready(function(){
		$("#in_time").datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',				 
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
					//minDate : new Date(explode[0],explode[1] - 1,explode[2]),
					//minDate : new Date(),
					maxDate : new Date(),
				});  
		 });
   </script>
   
   